<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Referal;
use Carbon\Carbon;
use App\VoucherHistory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Providers\GlobalProvider;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
    public function index()
    {
        return view('pages.admin.reward.index');
    }

    public function indexAdmin()
    {
        return view('pages.admin.reward.admin');
    }

    public function getPoinByMonth()
    {
            $gF = new GlobalProvider();
            $start = date('2021-08-18');
            $range = request()->range;
            
            $exRange = explode('-', $range);
            $year    = $exRange[0];
            $month   = $exRange[1];

            // $date1 = date_create($start); 
            // $date2 = date_create($end); 
            
            // $interval = date_diff($date1, $date2); 
        
            // jumlah hari
            $days = 0;
            $rangeMonth = 1;
            $mode = 0;

            $referalModel = new Referal();
            $referalPoint = $referalModel->getPointByThisMonth($year, $month);
            $totalReferal = collect($referalPoint)->sum(function($q){
                return $q->total_referal;
            });

            $data = [];
            foreach ($referalPoint as $key => $val) {
                $totalReferalByMember = $val->total_referal - $val->referal_inpoint;
                if ($gF->calPoint($totalReferalByMember) != 0) {
                    # code...
                    $data[] = [
                        'userId' => $val->id,
                        'photo' => $val->photo,
                        'name' => $val->name,
                        'totalReferal' =>  $totalReferalByMember,
                        'poin' => $gF->calPoint($totalReferalByMember),
                        'nominal' => $gF->decimalFormat($gF->callNominal($gF->calPoint($totalReferalByMember))),
                        'totalNominal' => $gF->callNominal($gF->calPoint($totalReferalByMember))
                        // 'days' => $days,
                        // 'date' => $start.'/'.$end,
                        // 'month' => $monthCategory
                    ];
                }
                
            }
            $totalPoint = collect($data)->sum(function($q){
                return $q['poin'];
            });
            $totalNominal = collect($data)->sum(function($q){
                return  $q['totalNominal'];
            });
             $totalReferalCalculate = collect($data)->sum(function($q){
                return $q['totalReferal'];
            });

            $result = [
                'monthCategory' => $rangeMonth,
                'mode' => $mode,
                'totalReferalCalculate' => $gF->decimalFormat($totalReferalCalculate),
                'totalPoint' => $totalPoint,
                'totalNominal' => $gF->decimalFormat($totalNominal),
                'data' => $data
            ];
            return $result;
    }

    public function getPoinByMonthDefault()
    {
            $gF = new GlobalProvider();
            $start = date('2021-08-18');
            $end = date('Y-m-d');

            $date1 = date_create($start); 
            $date2 = date_create($end); 
            
            $interval = date_diff($date1, $date2); 
        
            // jumlah hari
            $days = $interval->d;
            $rangeMonth = $interval->m;
            $mode = $gF->getPointMode($days);

            $referalModel = new Referal();
            $referalPoint = $referalModel->getPoint($start, $end);
            $totalReferal = collect($referalPoint)->sum(function($q){
                return $q->total_referal;
            });

            $data = [];
            foreach ($referalPoint as $key => $val) {
                $totalReferalByMember = $val->total_referal - $val->referal_inpoint;
                    # code...
                    
                    $data[] = [
                        'userId' => $val->id,
                        'photo' => $val->photo,
                        'name' => $val->name,
                        'totalReferal' =>  $totalReferalByMember,
                        'poin' => $gF->calPoint($totalReferalByMember),
                        'nominal' => $gF->decimalFormat($gF->callNominal($gF->calPoint($totalReferalByMember))),
                        'totalNominal' => $gF->callNominal($gF->calPoint($totalReferalByMember))
                        // 'days' => $days,
                        // 'date' => $start.'/'.$end,
                        // 'month' => $monthCategory
                    ];
                
            }
            $totalPoint = collect($data)->sum(function($q){
                return $q['poin'];
            });
            $totalNominal = collect($data)->sum(function($q){
                return  $q['totalNominal'];
            });
             $totalReferalCalculate = collect($data)->sum(function($q){
                return $q['totalReferal'];
            });

            $result = [
                'monthCategory' => $rangeMonth,
                'mode' => $mode,
                'totalReferalCalculate' => $gF->decimalFormat($totalReferalCalculate),
                'totalPoint' => $totalPoint,
                'totalNominal' => $gF->decimalFormat($totalNominal),
                'data' => $data
            ];
            return $result;
    }

    public function getPoinByMonthMemberAdmin()
    {
        $gF = new GlobalProvider();

        if (request()->daterange != '') {
            $range = request()->daterange;

            $date  = explode('+', $range);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end   = Carbon::parse($date[1])->format('Y-m-d'); 

            // jumlah hari
            $days = $gF->getDaysTotal($start, $end);
            $monthCategory = $gF->getMonthCategoryMemberAdmin($days);
            $mode = $gF->getPointModeMemberAdmin($days);
            
            $referalModel = new Referal();
            $referalPoint = $referalModel->getPointMemberAdmin($start, $end);
            $totalReferal = collect($referalPoint)->sum(function($q){
                return $q->total_input;
            });
             
            

            $data = [];
            foreach ($referalPoint as $key => $val) {
                $totalInputMember = $val->total_input - $val->input_inpoint;
                if ($gF->getPointMemberAdmin($totalInputMember, $days) > 0) {
                    # code...
                    $data[] = [
                        'userId' => $val->id,
                        'photo' => $val->photo,
                        'name' => $val->name,
                        'totalReferal' => $totalInputMember,
                        'poin' => $gF->getPointMemberAdmin($totalInputMember, $days),
                        'nominal' => $gF->decimalFormat($gF->getPointNominal($gF->getPointMemberAdmin($totalInputMember, $days))),
                        'totalNominal' => $gF->getPointNominal($gF->getPointMemberAdmin($totalInputMember, $days)),
                        'days' => $days,
                        'date' => $start.'/'.$end,
                        'month' => $monthCategory
                    ];
                }
            }

            $totalPoint = collect($data)->sum(function($q){
                return $q['poin'];
            });
             $totalNominal = collect($data)->sum(function($q){
                return $q['totalNominal'];
            });
             $totalReferalCalculate = collect($data)->sum(function($q){
                return $q['totalReferal'];
            });

            $result = [
                'days' => $days,
                'monthCategory' => $monthCategory,
                'mode' => $mode,
                'totalReferal' => $totalReferal,
                'totalPoint' => $totalPoint,
                'totalNominal' => $gF->decimalFormat($totalNominal),
                'totalReferalCalculate' => $totalReferalCalculate,
                'data' => $data
            ];
            return $result;
        }
    }

    public function getPoinByMonthMemberAdminDefaul($daterange)
    {
            $gF = new GlobalProvider();
            $range = $daterange;

            if ($range != '') {
                $date  = explode('+', $range);
                $start = Carbon::parse($date[0])->format('Y-m-d');
                $end   = Carbon::parse($date[1])->format('Y-m-d'); 
            }

            // jumlah hari
            $days = $gF->getDaysTotal($start, $end);
            $monthCategory = $gF->getMonthCategoryMemberAdmin($days);
            $mode = $gF->getPointModeMemberAdmin($days);
            
            $referalModel = new Referal();
            $referalPoint = $referalModel->getPointMemberAdmin($start, $end);
            $totalReferal = collect($referalPoint)->sum(function($q){
                return $q->total_input;
            });

            $data = [];
            foreach ($referalPoint as $key => $val) {
                $totalInputMember = $val->total_input - $val->input_inpoint;
                if ($gF->getPointMemberAdmin($totalInputMember, $days) > 0) {
                    # code...
                    $data[] = [
                        'userId' => $val->id,
                        'photo' => $val->photo,
                        'name' => $val->name,
                        'totalReferal' => $totalInputMember,
                        'poin' => $gF->getPointMemberAdmin($totalInputMember, $days),
                        'nominal' => $gF->decimalFormat($gF->getPointNominal($gF->getPointMemberAdmin($totalInputMember, $days))),
                        'totalNominal' => $gF->getPointNominal($gF->getPointMemberAdmin($totalInputMember, $days)),
                        'days' => $days,
                        'date' => $start.'/'.$end,
                        'month' => $monthCategory
                    ];
                }
            }
            $totalPoint = collect($data)->sum(function($q){
                return $q['poin'];
            });
            $totalNominal = collect($data)->sum(function($q){
                return $q['totalNominal'];
            });
             $totalReferalCalculate = collect($data)->sum(function($q){
                return $q['totalReferal'];
            });

            $result = [
                'days' => $days,
                'monthCategory' => $monthCategory,
                'mode' => $mode,
                'totalReferal' => $totalReferal,
                'totalPoint' => $totalPoint,
                'totalNominal' => $totalNominal,
                'totalReferalCalculate' => $totalReferalCalculate,
                'data' => $data
            ];
            return $result;
    }

    public function saveVoucherHistory()
    {
        
        $token = request()->_token;

        if ($token != null) {
            $userId = request()->userId;
            $point = preg_replace("/[^0-9]/", "", request()->point);
            $nominal = preg_replace("/[^0-9]/", "", request()->nominal);
            $referal = preg_replace("/[^0-9]/", "", request()->referal);
            $daterange = request()->daterange;
            $date = request()->date;
            $month = request()->month;

            $data =  VoucherHistory::create([
                    'user_id' => $userId,
                    'point' => $point,
                    'nominal' => $nominal,
                    'total_data' => $referal,
                    'range' => '[{"date" : '.$date.',"days" : '.$daterange.',"category" : '.$month.'}]',
                    'code' => Str::random(5)
            ]);

          if ($data) {
                $success = true;
                $message = 'Voucher Berhasil';

            }else{
                $success = false;
                $message = 'Voucher Gagal';
            }
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
            
        }

    }
}
