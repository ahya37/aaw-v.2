<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionnaireQuestion extends Model
{
    protected $table   = 'questionnaire_questions';
    protected $guarded = [];

    public function getDataQuestionnaireQuestion($id){
        $sql = "SELECT id, description, type FROM questionnaire_questions WHERE questionnaire_title_id=$id";
        return DB::select($sql);
    }

    public function editData($titleId){
        $sql = "SELECT id, description, type FROM questionnaire_questions WHERE id=$titleId";
        return collect(\DB::select($sql))->first();
    }

    public function insertData($userId,$date,$desc){
        $sql = "INSERT INTO questionnaire_questions (description,created_at,created_by) VALUES('$desc','$date','$userId')";
        return DB::insert($sql);
    }

    public function updateData($id,$desc,$type,$userId,$date){
        $sql = "UPDATE questionnaire_questions SET description='$desc', type='$type', updated_at='$date', updated_by='$userId' WHERE id=$id";
        return DB::update($sql);
    }

    // public function delete($id){
    //     $sql = "DELETE FROM questionnaire_questions WHERE id=$id";
    //     return DB::delete($sql);
    // }

}
