<?php

namespace App\Http\Controllers;

use App\Questionnaire;
use App\QuestionnaireAnswer;
use App\QuestionnaireAnswerChoice;
use App\QuestionnaireQuestion;
use App\QuestionnaireRespondent;
use App\QuestionnaireTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function index(){

        $questionnaire = Questionnaire::select('id','name','number_of_respondent','url')->orderBy('name','asc')->get();
        $no            = 1;

        return view('pages.questionnaire.index', compact('no','questionnaire'));

    }

    public function createRespondent($questionnaireId){


        #get judul pertanyaan by kuisioner id
        $questionnaireTitle = QuestionnaireTitle::select('id','name')->where('questionnaire_id', $questionnaireId)->get();
        $questionnaireQuestionModel      = new QuestionnaireQuestion();
        $questionnaireAnswerChoicesModel = new QuestionnaireAnswerChoice();

        #dalam looping
        $questions = [];
        foreach ($questionnaireTitle as $value) {
            # code...
            #get pertanyaan by judul kuisioner
            $choices = [];

            $dataQuestion =  $questionnaireQuestionModel->getDataQuestionsByTitle($value->id);

            foreach ($dataQuestion as $item) {

                $answerChoices = $questionnaireAnswerChoicesModel->getDataAnswerChoiceByQuestionId($item->id);

                $choices[] = [
                    'id' => $item->id,
                    'questions' => $item->desc,
                    'answerChoices' => $answerChoices
                ];
            }

            $no = 1;
            $questions[] = [
                'id' => $value->id,
                'title' => $value->name,
                'questions' => $choices
            ];

            
            #get pilihan jawaban by pertanyaan kuisioner
        }

        // dd($questions);

        // $alphabet = range('A','Z');


        return view('pages.questionnaire.create-respondent', compact('questions','no','questionnaireId'));
    }

    public function storeRespondent(Request $request, $questionId){

        DB::beginTransaction();
        try {
           
            #Validasi
            $request->validate([
                'nik' => 'required|numeric',
                'name' => 'required|string', 
                'gender' => 'required',
                'age' => 'required|numeric',
                'phone_number' => 'required|numeric',
                'address' => 'required|string',
            ]);
    
            #hitung panjang nik, harus 16
            $cekLengthNik = strlen($request->nik);
            if($cekLengthNik <> 16) return redirect()->back()->with(['error' => 'NIK harus 16 angka, cek kembali NIK tersebut!']);
    
            #save ke tb respondent
            $respondent = QuestionnaireRespondent::create([
                'questionnaire_id' => $questionId,
                'nik' => $request->nik,
                'name' => $request->name,
                'address' => $request->address,
                'gender' => $request->gender,
                'age' => $request->age,
                'created_by' => Auth::user()->id
            ]);
    
            $answerChoice['answerChoice'] = $request->answerchoice;

            $questionnaireAnswerChoicesModel = new QuestionnaireAnswerChoice();
    
            foreach ($answerChoice['answerChoice'] as $key => $value) {
    
                #get id dari save respondent
                #get number by answerChoice id / id pilihan nya
                $questionnaireAnswerChoices = $questionnaireAnswerChoicesModel->select('id','questionnaire_question_id','number')->where('id', $value)->first();
                $AnswerChoicesId            =  $questionnaireAnswerChoices->id;
                $QuestionnaireQestionId     =  $questionnaireAnswerChoices->questionnaire_question_id;
                $AnswerChoicesNumber        =  $questionnaireAnswerChoices->number;
            
                #save jawaban kuisioner pilihan ganda
                QuestionnaireAnswer::create([
                    'questionnaire_question_id' => $QuestionnaireQestionId,
                    'questionnaire_respondent_id' => $respondent->id,
                    'questionnaire_answer_choice_id' => $AnswerChoicesId,
                    'number' => $AnswerChoicesNumber,
                    'created_by' => Auth::user()->id
                ]);
    
            }
    
            #save jawaban kuisioner essay
            DB::commit();
            return redirect()->back()->with(['success' => 'Kuisioner berhasil disimpan!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Kuisioner gagal disimpan!'. $e->getMessage()]);
        }

    }
}
