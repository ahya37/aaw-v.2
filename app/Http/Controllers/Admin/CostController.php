<?php

namespace App\Http\Controllers\Admin;

use App\Cost;
use App\CostLess;
use App\Exports\CostExport;
use App\Forecast;
use App\ForecastDesc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\GlobalProvider;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Excel;

class CostController extends Controller
{
    public $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function create()
    {
        $forecast = Forecast::orderBy('name','desc')->get();
        $forecast_desc = ForecastDesc::orderBy('name','desc')->get();
        return view('pages.admin.cost.create', compact('forecast','forecast_desc'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'forecast_id' => 'required',
            'forecast_desc_id' => 'required',
            'received_name' => 'required',
            'nominal' => 'required',
            'file' => 'nullable|mimes:jpeg,jpg,png,pdf'
        ]);

       if ($request->hasFile('file')) {
                $fileImage = $request->file->store('assets/cost','public');
            }else{
                $fileImage = 'NULL';
            }

        // 
        CostLess::create([
            'date' => date('Y-m-d', strtotime($request->date)),
            'forcest_id' => $request->forecast_id,
            'forecast_desc_id' => $request->forecast_desc_id,
            'received_name' => $request->received_name,
            'village_id' => $request->village_id,
            'nominal' => $request->nominal,
            'file' => $fileImage,
        ]);

        return redirect()->back()->with(['success' => 'Pengeluaran telah tersimpan']);
    }

    public function addForecast(Request $request)
    {
        Forecast::create([
            'name' => strtoupper($request->name)
        ]);

        return redirect()->back()->with(['success' => 'Perkiaraan telah tersimpan']);
    }

    public function addForecastDesc(Request $request)
    {
        ForecastDesc::create([
            'name' => strtoupper($request->name)
        ]);

        return redirect()->back()->with(['success' => 'Uraian telah tersimpan']);
    }

    public function listCostPolitic()
    {
         $costModel = new Cost();
         $cost      = $costModel->getDataCost();
         $total     = collect($cost)->sum(function($q){
             return $q->nominal;
         });

         $gF = new GlobalProvider();
         $no = 1;

         if (request('date') != '') {
             $daterange =  request('date');
             $date  = explode('+', $daterange);

             $start = Carbon::parse($date[0])->format('Y-m-d');
             $end   = Carbon::parse($date[1])->format('Y-m-d');

              $cost     = $costModel->getDataCostRange($start, $end);

              $total     = collect($cost)->sum(function($q){
                    return $q->nominal;
                });
            }


        return view('pages.admin.cost.index', compact('cost','gF','no','total'));
    }

    public function getDataCost()
    {
        $costModel = new Cost();
        $cost      = $costModel->getDataCost();
        $data = [];

        foreach($cost as $val){
            $data[] = array(
                'date' => $val->date,
                'forecast' => $val->forcest,
                'forecast_desc' => $val->forecast_desc,
                'village_id' => $val->village_id,
                'member' => $val->member,
            );
        }

        return response()->json($data);
    }

    public function downloadPDF($daterange)
    {
             $gF = new GlobalProvider();
             $date  = explode('+', $daterange);

             $start = Carbon::parse($date[0])->format('Y-m-d');
             $end   = Carbon::parse($date[1])->format('Y-m-d');
             
            $costModel = new Cost();

            $cost     = $costModel->getDataCostRange($start, $end);
            $no = 1;

            $total     = collect($cost)->sum(function($q){
                    return $q->nominal;
                });
            $date_report = date('d-m-Y', strtotime($start)) .' - '. date('d-m-Y', strtotime($end));

        $pdf = PDF::LoadView('pages.admin.report.cost-politic', compact('cost','gF','date_report','no','total'))->setPaper('landscape');;
        return $pdf->download('LAPORAN COST POLITIC '.$date_report.'.pdf');
             
    }

    public function downloadExcel($daterange)
    {
             $gF = new GlobalProvider();
             $date  = explode('+', $daterange);

             $start = Carbon::parse($date[0])->format('Y-m-d');
             $end   = Carbon::parse($date[1])->format('Y-m-d');
             
            $date_report = date('d-m-Y', strtotime($start)) .' - '. date('d-m-Y', strtotime($end));

        return $this->excel->download(new CostExport($start, $end), 'LAPORAN COST POLITIK '.$date_report.'.xls');
             
    }
}
