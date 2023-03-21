<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class KorDesExport implements FromCollection,  WithHeadings, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $villageid;

    public function __construct(int $village)
    {
        $this->villageid = $village;
    }

    public function collection()
    {
        $village_id  =  $this->villageid;

        $village = DB::table('org_diagram_village as a')->select('a.name','a.base','a.title','a.rt','b.gender','c.name as village','d.name as district')
                    ->join('users as b','a.nik','=','b.nik')
                    ->join('villages as c','a.village_id','=','c.id')
                    ->join('districts as d','a.district_id','=','d.id')
                    ->where('a.village_id', $village_id)->get();

        $rt      = DB::table('org_diagram_rt as a')->select('a.name','a.base','a.title','a.rt','b.gender','c.name as village','d.name as district')
                    ->join('users as b','a.nik','=','b.nik')
                    ->join('villages as c','a.village_id','=','c.id')
                    ->join('districts as d','a.district_id','=','d.id')
                    ->where('a.village_id', $village_id)->whereNotNull('a.nik')->where('a.base','KORRT')->orderBy('a.rt','asc')->get();
        $data    = $village->merge($rt);

        $results = [];
        $no      = 1;
        foreach ($data as $value) {
            $results[] = [
                'no' => $no++,
                'name' => $value->name,
                'jk' => $value->gender == 1 ? 'P' : 'L',
                'rt' => $value->rt,
                'title' => $value->base == 'KORDES' ? $value->title : $value->base,
                'village' => $value->village,
                'district' => $value->district 
            ];
        }

        $result = collect($results);
        return $result;
    }

    public function headings(): array
    {
        return [
            'NO',
            'NAMA',
            'JENIS KELAMIN',
            'RT',
            'JABATAN',
            'DESA',
            'KECAMATAN',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                
                // $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                // $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);

                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);

                $data = $this->collection()->where('jk','L');
                $total_L = collect($data)->count();

                $event->sheet->appendRows(array(
                    array('','JUMLAH LAKI','',$total_L),
                ), $event);
                
                $data2 = $this->collection()->where('jk','P');
                $total_P = collect($data2)->count();

                $event->sheet->appendRows(array(
                    array('','JUMLAH PEREMPUAN','',$total_P),
                ), $event);
            }
        ];
    }
}
