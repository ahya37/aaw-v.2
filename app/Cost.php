<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cost extends Model
{
    protected $table = 'cost';
    protected $guarded = [];

    public function getDataCost()
    {
        $sql = "SELECT a.date, a.nominal, b.name as forcest, c.name as forecast_desc, d.village_id , d.name as member ,
            e.name as village , f.name as district , g.name as regency 
            from cost_les as a
            join forecast as b on a.forcest_id = b.id 
            join forecast_desc as c on a.forecast_desc_id = c.id 
            join users as d on a.user_id = d.id
            join villages as e on d.village_id = e.id 
            join districts as f on e.district_id = f.id 
            join regencies as g on f.regency_id = g.id";
        return DB::select($sql);
    }

    public function getDataCostRange($start, $end)
    {
        $sql = "SELECT a.date, a.nominal, b.name as forcest, c.name as forecast_desc, d.village_id , d.name as member ,
            e.name as village , f.name as district , g.name as regency 
            from cost_les as a
            join forecast as b on a.forcest_id = b.id 
            join forecast_desc as c on a.forecast_desc_id = c.id 
            join users as d on a.user_id = d.id
            join villages as e on d.village_id = e.id 
            join districts as f on e.district_id = f.id 
            join regencies as g on f.regency_id = g.id 
            where a.date  BETWEEN  '$start' and '$end' ";
        return DB::select($sql);
    }
}