<?php

namespace App\Http\Controllers;

use App\Referal;
use App\User;
use App\VoucherHistory;
use App\VoucherHistoryAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Providers\GlobalProvider;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RewardController extends Controller
{
    public function index()
    {
            $gF = new GlobalProvider();
            $userId = Auth::user()->id;
            $voucher = VoucherHistory::where('user_id', $userId)->first();
            $voucherAdmin = VoucherHistoryAdmin::where('user_id', $userId)->first();
            return view('pages.reward.index', compact('voucher','gF','voucherAdmin'));

    }

    public function getPoinByMonthDefaultByAccountMember()
    {
            $code = request()->code;
            $user = User::select('id','level')->where('code', $code)->first();
            $level = $user->level;

            if ($user != null) {
                # code...
                $user_id = $user->id;
                $gF = new GlobalProvider();

                $start = date('2021-08-18');
                $end = date('Y-m-d');

                $date1 = date_create($start); 
                $date2 = date_create($end); 

                $interval = date_diff($date1, $date2); 

    
                // jumlah hari
                $days = $interval->d;
                $monthCategory = $interval->m;
                // $mode = $level == 0 ? $gF->getPointMode($days) : $gF->getPointModeMemberAdmin($days);
                
                $referalModel = new Referal();
                $inputPoint   =  $referalModel->getPointByMemberAccount($start, $end, $user_id);

                if ($inputPoint != null) {
                                        
                    $inpoint =  $inputPoint->input_inpoint; 
                    $totalInputMember = $inputPoint->total_input - $inpoint;
        
                    $result = [
                        'monthCategory' => $monthCategory,
                        'point' => $gF->calPointAdmin($totalInputMember),
                        'totalData' => $totalInputMember,
                        'nominal' => $gF->decimalFormat($gF->callNominal($gF->calPointAdmin($totalInputMember))),
                    ];
        
                    return $result;
                }else{

        
                     $result = [
                        'monthCategory' => $monthCategory,
                        'point' => 0,
                        'totalData' => 0,
                        'nominal' => 0,
                    ];
        
                    return $result;
                }

            }
    }

    public function getPoinByMonthByAccountMember()
    {
            $code = request()->code;
            $user = User::select('id','level')->where('code', $code)->first();
            $level = $user->level;

            if ($user != null) {

                    $user_id = $user->id;
                    $gF = new GlobalProvider();
                    $start = date('2021-08-18');
                    $end = request()->range;
                
                    // jumlah hari
                    $date1 = date_create($start); 
                    $date2 = date_create($end); 

                    $interval = date_diff($date1, $date2); 
        
                    // jumlah hari
                    $days = $interval->d;
                    $monthCategory = $interval->m;
                    
                    $referalModel = new Referal();
                    $inputPoint  =  $referalModel->getPointByMemberAccount($start, $end, $user_id);
                    // $inputPoint = $referalModel->getPointByMemberAccount($start, $end, $user_id);
                    
                    if ($inputPoint != null) {
                        $inpoint =  $inputPoint->input_inpoint; 
                        $totalInputMember = $inputPoint->total_input - $inpoint;
                        
            
                        $result = [
                            'monthCategory' => $monthCategory,
                            'point' => $gF->calPointAdmin($totalInputMember),
                            'totalData' => $totalInputMember,
                            'nominal' => $gF->decimalFormat($gF->callNominal($gF->calPointAdmin($totalInputMember))),
                        ];
            
                        return $result;
                    }else{
                         $result = [
                            'monthCategory' => $monthCategory,
                            'point' => 0,
                            'totalData' => 0,
                            'nominal' => 0,
                        ];
            
                        return $result;
                    }
                
    


            }
    }

    public function getPoinByMonthDefaultByAccountMemberReferal()
    {
            $code = request()->code;
            $user = User::select('id','level')->where('code', $code)->first();
            $level = $user->level;

            if ($user != null) {
                # code...
                $userId = $user->id;
                $gF = new GlobalProvider();

                $start = date('2021-08-18');
                $end = date('Y-m-d');
                
                $date1 = date_create($start); 
                $date2 = date_create($end); 

                $interval = date_diff($date1, $date2); 

    
                // jumlah hari
                $days = $interval->d;
                $monthCategory = $interval->m;
                // $mode = $level == 0 ? $gF->getPointMode($days) : $gF->getPointModeMemberAdmin($days);
                
                $referalModel = new Referal();
                $inputPoint   =  $referalModel->getPointByMemberAccountReferal($start, $end, $userId);

                if ($inputPoint != null) {
                                        
                    $inpoint =  $inputPoint->referal_inpoint; 
                    $totalReferal = $inputPoint->total_referal - $inpoint;
        
                    $result = [
                        'monthCategoryReferal' => $monthCategory,
                        'pointReferal' => $gF->calPoint($totalReferal),
                        'totalDataReferal' => $totalReferal,
                        'nominalReferal' => $gF->decimalFormat($gF->callNominal($gF->calPoint($totalReferal))),
                    ];
        
                    return $result;
                }else{

        
                     $result = [
                        'monthCategoryReferal' => $monthCategory,
                        'pointReferal' => 0,
                        'totalDataReferal' => 0,
                        'nominalReferal' => 0,
                    ];
        
                    return $result;
                }

            }
    }

    public function getPoinByMonthByAccountMemberReferal()
    {
            $code = request()->code;
            $user = User::select('id','level')->where('code', $code)->first();
            $level = $user->level;

            if ($user != null) {
                # code...
                $userId = $user->id;
                $gF = new GlobalProvider();

                $start = date('2021-08-18');
                $end = request()->range;


                $date1 = date_create($start); 
                $date2 = date_create($end); 

                $interval = date_diff($date1, $date2); 

    
                // jumlah hari
                $days = $interval->d;
                $monthCategory = $interval->m;
                // $mode = $level == 0 ? $gF->getPointMode($days) : $gF->getPointModeMemberAdmin($days);
                
                $referalModel = new Referal();
                $inputPoint   =  $referalModel->getPointByMemberAccountReferal($start, $end, $userId);

                if ($inputPoint != null) {
                                        
                    $inpoint =  $inputPoint->referal_inpoint; 
                    $totalReferal = $inputPoint->total_referal - $inpoint;
        
                    $result = [
                        'monthCategoryReferal' => $monthCategory,
                        'pointReferal' => $gF->calPoint($totalReferal),
                        'totalDataReferal' => $totalReferal,
                        'nominalReferal' => $gF->decimalFormat($gF->callNominal($gF->calPoint($totalReferal))),
                    ];
        
                    return $result;
                }else{

        
                     $result = [
                        'monthCategoryReferal' => $monthCategory,
                        'pointReferal' => 0,
                        'totalDataReferal' => 0,
                        'nominalReferal' => 0,
                    ];
        
                    return $result;
                }

            }
    }

    public function dtVoucherHistoryReferal()
    {
        $gF = new GlobalProvider();
        $code = request()->code;
        $user = User::select('id','level')->where('code', $code)->first();
        $userId = $user->id;
        $voucherModel = new VoucherHistory();
        $voucher      = $voucherModel->getListVoucherByMember($userId);

         $data = [];
            foreach ($voucher as $item) {
                $data [] = [
                    'totalPoint' => $item->point,
                    'totalNominal' => $gF->decimalFormat($item->nominal),
                    'date' => date('d-m-Y H:i', strtotime($item->created_at)),
                ];
            }

            $result = [
                'data' => $data
            ];
            
            return $result;
    }

    public function dtVoucherHistoryAdmin()
    {
        $gF = new GlobalProvider();
        $code = request()->code;
        $user = User::select('id','level')->where('code', $code)->first();
        $userId = $user->id;
        $voucherModel = new VoucherHistoryAdmin();
        $voucher      = $voucherModel->getListVoucherByMember($userId);

        $data = [];
        foreach ($voucher as $item) {
            $data [] = [
                'totalPoint' => $item->point,
                'totalNominal' => $gF->decimalFormat($item->nominal),
                'date' => date('d-m-Y H:i', strtotime($item->created_at)),
            ];
        }

        $result = [
            'data' => $data
        ];
        
        return $result;
    }
}
