<?php

namespace App\Http\Controllers\Admin;

use App\Tps;
use App\Dapil;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TpsController extends Controller
{
    public function index(){

        $regency = Regency::select('id','name')->where('id', 3602)->first();
        
        return view('pages.admin.tps.index', compact('regency'));

    }

    public function getDataTps(Request $request){

        // DATATABLE
        $orderBy = 'b.name';
        switch ($request->input('order.0.column')) {
            case '3':
                $orderBy = 'b.name';
                break;
        }

        $data = DB::table('tps as a')
                ->select('a.tps_number','a.rt', 'a.rw', 'b.name as village')
                ->join('villages as b','a.village_id','=','b.id');

            
        if($request->input('search.value')!=null){
                $data = $data->where(function($q)use($request){
                    $q->whereRaw('LOWER(b.name) like ? ',['%'.strtolower($request->input('search.value')).'%']);
                });
            }

            if ($request->input('village') != null) {
                            $data->where('a.village_id', $request->village);
            }

            if ($request->input('rt') != null) {
                            $data->where('a.rt', $request->rt);
            }


          $recordsFiltered = $data->get()->count();
          if($request->input('length')!=-1) $data = $data->skip($request->input('start'))->take($request->input('length'));
        
          $data = $data->orderBy('a.village_id','asc');
          $data = $data->orderBy('a.tps_number','asc');
          $data = $data->orderBy($orderBy,$request->input('order.0.dir'));
          $data = $data->get();
          
          $recordsTotal = $data->count();

          return response()->json([
                'draw'=>$request->input('draw'),
                'recordsTotal'=>$recordsTotal,
                'recordsFiltered'=>$recordsFiltered,
                'data'=> $data
            ]);
    }


    public function create(){

        $dapils = new Dapil();
        $dataDapils = $dapils->getRegencyDapil();

        return view('pages.admin.tps.create', compact('dataDapils'));

    }

    public function store(Request $request){

        $this->validate($request, [
            'tpnumber' => 'required',
        ]);

        Tps::create([
            'village_id' => $request->village_id,
            'tps_number' => $request->tpnumber,
            'rt' => $request->rt,
            'rw' => $request->rw
        ]);

        return redirect()->back()->with(['success' => 'TPS berhasil tersimpan!']);

    }


}
