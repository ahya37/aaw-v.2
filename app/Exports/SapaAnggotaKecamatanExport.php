<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class SapaAnggotaKecamatanExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected $data;
    protected $districtName;

    public function __construct($data, string $districtName)
    {
        $this->data = $data;
        $this->districtName = $districtName;
    }

    public function collection() 
    {
        $data = $this->data;

        $results = [];
        $no      = 1;
        foreach ($data as $value) {
            $results[] = [
                'no' => $no++,
                'desa' => $value->desa,
                'peserta' => $value->peserta == 0 ? '0' : $value->peserta,
                'anggota_korte' => $value->anggota_korte == 0 ? '0' : $value->anggota_korte,
                'biaya' => ''
            ];
        }

        return collect($results);
    }

    public function headings(): array
    {
        return [
            'NO',
            'DESA',
            'PESERTA',
            'ANGGOTA KORTE',
            'BIAYA'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class =>  function (AfterSheet $event){

                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
              
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ]
                ]);
            }
        ] ;  
    }

    public function title(): string
    {
        $title = 'KEC.'.$this->districtName;
        return $title;
    }

}