<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Questionnaire;
use App\Helpers\ResponseFormatter;

class QuestionnaireController extends Controller
{
    public function index(){
        DB::table('questionnaires')->get();

        return view('pages.admin.questionnaires.index');
    }

    public function create(){

        return view('pages.admin.questionnaires.create');
    }

    public function store(Request $request){
        //validasi data

        $request->validate([
            'name' => 'required',
        ]);

        //ambil data ke dalam variabel
        $nama = $request->name;
        $tanggal = date('Y-m-d h:i:s');

        Questionnaire::create([
            'name' => $nama,
            'created_by' => '1',
            'created_at' => $tanggal,
        ]);

        return redirect()->route('admin-questionnaire')->with(['success' => 'Data Berhasil Ditambahkan']);
    }

    public function getDataQuestionnaire(Request $request){

         // DATATABLE
         $orderBy = 'name';
         switch ($request->input('order.0.column')) {
             case '3':
                 $orderBy = 'name';
                 break;
         }
 
         $data = DB::table('questionnaires')->select('id','name','number_of_respondent');
 
 
         if($request->input('search.value')!=null){
                 $data = $data->where(function($q)use($request){
                     $q->whereRaw('LOWER(name) like ? ',['%'.strtolower($request->input('search.value')).'%']);
                 });
             }
 
          
           $recordsFiltered = $data->get()->count();
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

    public function delete()
    {

        DB::beginTransaction();
        try {

            $id    = request()->id;

            $data = DB::table('questionnaires')->where('id',$id)->delete();

            DB::commit();
            return ResponseFormatter::success([
                'message' => 'Berhasil hapus inventori!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormatter::error([
                'message' => 'Something when wrong!',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit($id){
        $questionnaire = Questionnaire::where('id',$id)->first();

        return view('pages.admin.questionnaires.edit', compact('questionnaire'));
    }

    public function update(Request $request){

        //validasi data
        $request->validate([
            'name' => 'required',
        ]);

        $id = $request->id;
        $nama = $request->name;
        $tanggal = date('Y-m-d h:i:s');

        DB::table('questionnaires')->where('id',$id)->update([
            'name' => $nama,
            'created_by' => '1',
            'created_at' => $tanggal,

        ]);

        return redirect()->route('admin-questionnaire')->with(['success' => 'Data Berhasil Diedit']);
    
    }

}
