<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class KorCamExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $districtid;

    public function __construct(int $district)
    {
        $this->districtid = $district;

    }

    public function collection()
    {
        $district_id  =  $this->districtid;

        $korcam = DB::table('org_diagram_district as a')->select('b.id','b.nik','a.name','a.base','a.title','b.gender','d.name as district','e.name as village')
                    ->join('users as b','a.nik','=','b.nik')
                    ->join('districts as d','a.district_id','=','d.id')
					->join('villages as e','b.village_id','=','e.id')
                    ->where('a.district_id', $district_id)
                    ->orderBy('e.name','asc')
					->orderBy('a.level_org','asc')
                    
                    ->get();
					
		$kordes = DB::table('org_diagram_village as a')->select('b.nik','b.id','a.name','a.base','a.title','a.rt','b.gender','c.name as village','d.name as district')
                    ->join('users as b','a.nik','=','b.nik')
                    ->join('villages as c','a.village_id','=','c.id')
                    ->join('districts as d','a.district_id','=','d.id')
                    ->where('a.district_id', $district_id)
                    ->orderBy('a.level_org','asc')
					->orderBy('c.name','asc')
                    ->get();
					
		$korte = DB::table('org_diagram_rt as a')->select('b.nik','b.id','a.name','a.base','a.title','a.rt','b.gender','c.name as village','d.name as district')
                    ->join('users as b','a.nik','=','b.nik')
                    ->join('villages as c','a.village_id','=','c.id')
                    ->join('districts as d','a.district_id','=','d.id')
                    ->where('a.district_id', $district_id)
					->orderBy('c.name','asc')
					->where('a.base','KORRT')
					
                    ->get();
		
		$data    = $korcam->merge($kordes); #merge kedua array
		$data    = $data->merge($korte);
 
        $results = [];
        $no      = 1;
        foreach ($data as $value) {
			# BERAPA ANGGOTA YANG MEMILIKI REFERAL PERKECAMATAN
			 $male   = DB::table('users')->select('gender')->where('gender',0)->where('user_id', $value->id)->count();
             $female = DB::table('users')->select('gender')->where('gender',1)->where('user_id', $value->id)->count();
						
			$tim = '';
			if($value->base == 'KORCAM'){
				$tim = "KORCAM ($value->title)";
			}else if($value->base == 'KORDES'){
				$tim = "KORDES ($value->title)";
			}else if($value->base == 'KORRT'){
				$tim = "KOR $value->title";
			}
			
            $results[] = [
                'no' => $no++,
				'nik' => "'$value->nik",
                'name' => $value->name,
                'jk' => $value->gender == 1 ? 'P' : 'L',
				'referal' => $male+$female,
				'male' => $male,
				'female' => $female,
                'title' => $tim,
                'village' => $value->village,
                'district' => $value->district,
				'desc' => ''
            ];
        }
            
        $result = collect($results);
        return $result;

    }

    public function headings(): array
    {
        return [
            'NO',
            'NIK',
            'NAMA',
            'JENIS KELAMIN',
            'REFERAL',
            'LAKI-LAKI',
            'PEREMPUAN',
            'TIM',
            'DESA',
            'KECAMATAN',
            'KETERANGAN',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                
                // $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(40);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);

                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true,
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