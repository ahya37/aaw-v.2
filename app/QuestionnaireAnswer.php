<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionnaireAnswer extends Model
{
    public function getData($id){
        $sql = "SELECT answer.id, answer.name FROM answer_choice_categories as answer JOIN questionnaire_answer_choices as questionnaire ON answer.id = questionnaire.answer_choice_category_id WHERE questionnaire_question_id = $id";
        return DB::select($sql);
    }

    public function data($id){
        $sql = "SELECT a.number, b.name FROM questionnaire_answer_choices AS a JOIN answer_choice_categories AS b ON a.number = b.id WHERE questionnaire_question_id = $id ";
        return collect(\DB::select($sql))->first();
    }

}
