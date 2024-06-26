<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Event;
use App\CostLess;
use App\Forecast;
use App\CostEvent;
use App\EventDetail;
use App\ForecastDesc;
use App\EventCategory;
use App\FamilyGroup;
use App\GiftRecipients;
use App\Helpers\AdminArea;
use App\Models\Village;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Providers\GlobalProvider;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Regency;
use PDF;
use App\Models\District;
use App\OrgDiagram;

class EventController extends Controller
{
    public function index()
    {
        $regency = Regency::select('id', 'name')->where('id', 3602)->first();

        $authAdminDistrict = auth()->guard('admin')->user()->district_id;
        $district  = District::select('name','id')->where('id', $authAdminDistrict)->first();
        $villages  = Village::select('id','name')->where('district_id', $district->id)->get();

        // dd($villages);

        $eventModel = new Event();
        $events     = $eventModel->getEventsByDistrict($district->id);
        if (request()->ajax()) {
            return DataTables::of($events)
                    ->addColumn('action', function($item){
                        return '
                        <div class="row">
                            <div class="col-4">
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-sc-primary text-white dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">...</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="'.route('admin-event-addmember-detail', $item->id).'">
                                                Detail
                                            </a>
                                            <a class="dropdown-item" href="'.route('admin-event-edit', $item->id).'">
                                                Edit
                                            </a>
                                            <a class="dropdown-item" href="'.route('admin-event-gallery', $item->id).'">
                                                Galeri
                                            </a>
                                            <a class="dropdown-item" href="'.route('admin-event-cost-create', $item->id).'">
                                                Tambah Biaya
                                            </a>
                                            <a class="dropdown-item" href="'.route('admin-event-addmember', $item->id).'">
                                                Tambah Peserta
                                            </a>
                                            <a class="dropdown-item" href="'.route('admin-event-addgiftreceipents', $item->id).'">
                                                Tambah Penerima Bingkisan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-6">
                                <a class="btn btn-sm btn-danger ml-3" href="'.route('admin-event-delete', $item->id).'">
                                    <i class="fa fa-trash"></i>
                                </a>
                                </div>
                        </div>
                        ';
                    })->addColumn('dates', function($item){
                        return date('d-m-Y', strtotime($item->date));
                    })
					// ->addColumn('times', function($item){
                        // return date('H:i', strtotime($item->time));
                    // })
					->addColumn('delete', function($item){
                        return ' <a class="dropdown-item" href="'.route('admin-event-delete', $item->id).'">
                                        Hapus
                                </a>';
                    })
                    ->addColumn('address', function($item){
                        // if ($item->district == null) {
                            // return $item->regency;
                        // }elseif($item->village == null){
                            // return 'KEC. ' .$item->district.',<br>'.''.$item->regency.'';
                        // }
                        // else{
                            // return 'DS.' .$item->village.',<br>'.'KEC.'.$item->district.'<br>'.''.$item->regency.'';
                        // }
						
						return 'DS.' .$item->village ?? '';
						
                    })                   
                    ->rawColumns(['action','dates','delete','address'])
                    ->make();
        }
		
		$regency = Regency::select('id', 'name')->where('id', 3602)->first();
		$event_cat = DB::table('event_categories')->select('id','name')->get();

        return view('pages.admin.event.index', compact('regency','event_cat','district','villages'));
    }
	 
	public function downloadGaleryByEvent(Request $request){
		
		// get data galery event by event kategori event dan desa
		$events = DB::table('event_galleries as a')
				->select('a.descr','a.file')
				->join('events as b','a.event_id','=','b.id')
				->join('event_categories as c','b.event_category_id','=','c.id')
				->where('b.event_category_id', $request->eventcatid)
				->where('b.district_id', $request->district_id)
				->get();
		
		if(count($events) < 1){
			
			return redirect()->back()->with(['error' => 'Tidak ada data']);
			
		}else{
			
			$event_cat = DB::table('event_categories')->select('id','name')->where('id',$request->eventcatid)->first();
			// $village   = DB::table('villages as a')
					// ->select('a.name as village','b.name as district')
					// ->join('districts as b','a.district_id','=','b.id')
					// ->where('a.id', $request->village_id)
					// ->first();
			$districts = DB::table('districts')->select('name')->where('id', $request->district_id)->first(); 
			$village = $districts;
			$pdf  = PDF::LoadView('pages.report.fotoevent', compact('events','event_cat','village'))->setPaper('a4','landscape');
			return $pdf->download('LAPORAN DOKUMENTASI '.strtoupper($event_cat->name).'KECAMATAN '.$village->name.'.pdf');
		}
		
				
	}

    public function createCost($id)
    {
         $forecast = Forecast::orderBy('name','desc')->get();
        $forecast_desc = ForecastDesc::orderBy('name','desc')->get();
        return view('pages.admin.event.create-cost', compact('forecast','forecast_desc','id'));
    }
    public function create()
    {
        $eventCategories = EventCategory::select('id','name')->orderBy('name','asc')->get();
        return view('pages.admin.event.create',compact('eventCategories'));
    }

    public function edit($id) 
    {
        $event = Event::where('id', $id)->first();
        $eventCategories = EventCategory::select('id','name')->orderBy('name','asc')->get();
        return view('pages.admin.event.edit', compact('event','eventCategories'));
    }
    
    public function delete($id)
    {
       Event::where('id', $id)->update(['isdelete' => 1]);
        // $event->delete();

        return redirect()->back()->with(['success' => 'Event telah dihapus']);
    }

    public function addMemberEvent($id)
    {
        $event_id = $id;

        $event = Event::select('village_id')->where('id', $id)->first();
        
        // get data korte berdasarkan desa pada event tersebut
        $orgModel = new OrgDiagram();
        $korte    = $orgModel->getDataKorteByDesa($event->village_id);

        // get area admin kecamtan
        $adminArea = new AdminArea();
        $adminAreaResult  = $adminArea::getDistrict();
        $districtId       = $adminAreaResult->id;

        // get data korcam, by akun login kecamatan
        $korcam   = $orgModel->getDataKorcamByAdminDistrict($districtId);
        // get data kordes, by akun login kecamatan
        $kordes   = $orgModel->getDataKordesByVillage($event->village_id);

        // get data kortps where data korte
        $result_korte = [];
        foreach ($korte as $value) {
           $list_anggota = $orgModel->getDataAnggotaByKorte($value->idx);
           $result_korte[] = [
                'id'   => $value->id,
                'name' => $value->NAMA,
                'list_anggota' => $list_anggota,
                'base' => $value->base
           ];
        }
        
        $provinceModel = new Province();
        $province = $provinceModel->getDataProvince();

        $no         = 1;
        
        return view('pages.admin.event.add-participant', compact('province','event_id','result_korte','no','korcam','kordes'));
    }

    public function addRecipientFromTim(Request $request, $eventId)
    {
        $this->validate($request, [
            'participant' => 'required',
        ]);

        // tampung array data peserta event
        $data['participant'] = $request->participant;

        $event = Event::select('address','event_category_id')->where('id', $eventId)->first();
      
        //get kelengkapan data by id dari list peserta
        foreach ($data['participant'] as $key => $value) {
            // cek jika user_id dan event_id sudah ada di detai_event, maka jangan disimpan dua kali
           $eventDetailModel = new EventDetail();

           $eventDetail = $eventDetailModel->where('event_id', $eventId)->where('user_id', $value)->count();
           if ($eventDetail == 0) {
               $anggota = User::select('id','name','village_id','nik')->where('id', $value)->first();
                // simpan kedalam tabel event_detail sebagai peserta
               $eventDetailModel = new EventDetail();
               $eventDetailModel->event_id = $eventId;
               $eventDetailModel->event_category_id = $event->event_category_id;
               $eventDetailModel->village_id = $anggota->village_id;
               $eventDetailModel->user_id = $value;
               $eventDetailModel->nik = $anggota->nik;
               $eventDetailModel->participant = $anggota->name;
               $eventDetailModel->status = 'TIM';
               $eventDetailModel->address = $event->address;
               $eventDetailModel->save();
           } 

        }

        return redirect()->back()->with(['success' => 'Berhasil simpan peserta!']);

    }

    public function addGiftRecipient($id)
    {
        $event_id = $id;
        $provinceModel = new Province();
        $province = $provinceModel->getDataProvince();
        $regency  = 3602;

        #get data keluarga serumah
        $familyGroupModel = new FamilyGroup();
        $familyGroup      = $familyGroupModel->getDataFamilyGroups();

        return view('pages.admin.event.add-giftrecipients', compact('province','event_id','regency','familyGroup'));
    }

    public function storeAddMemberEvent(Request $request)
    {
        $user_id = $request->user_id;
        foreach ($user_id as $key => $value) {
            $eventDetail = new EventDetail();
            $eventDetail->user_id  = $value;
            $eventDetail->event_id = $request->event_id;
            $eventDetail->save();
        }

        return redirect()->route('admin-event')->with(['success' => 'Anggota telah ditambahkan']);
        
    }

    public function storeAddMemberEventAjax()
    {
        $user_id = request()->userId;
        $token   = request()->_token;
        $even_Id   = decrypt(request()->eventId);
        $eventDetailModel = new EventDetail();

        if ($token != null) {

            $memberOfEvent = $eventDetailModel::where('user_id', $user_id)
                                                ->where('event_id',$even_Id)->count();
            if ($memberOfEvent > 0) {

                $success = false;
                $message = "Sudah terdaftar";

                return response()->json([
                'success' => $success,
                'message' => $message,
            ]);
            }else{

                $event =  EventDetail::create([
                    'user_id' => $user_id,
                    'event_id' => $even_Id
                ]);
                
                if ($event) {
                    $success = true;
                    $message = "Berhasil menambahkan";
    
                }else{
                    $success = false;
                    $message = "Gagal menambahkan";
                }
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }

        }
        
    }

    public function storeAddParticipant($event_id, $user_id)
    {
        $user = User::select('name','village_id')->where('id', $user_id)->first();

        $village = Village::with(['district.regency'])->where('id', $user->village_id)->first();
        $address = 'DS. '. $village->name. ', KEC. ' .$village->district->name. ', '. $village->district->regency->name;

        $eventDetail = new EventDetail();
            $eventDetail::create([
                'event_id' => $event_id,
                'participant' => strtoupper($user->name),
                'address' =>  $address
            ]);

        return redirect()->back()->with(['success' => 'Berhasil menambahkan peserta']);

    }

    public function storeAddParticipantOther(Request $request, $event_id)
    {
        $name = $request->name;
        $data['village_id'] = $request->village_id;
        
        foreach ($name as $key => $value) {
            $village = Village::with(['district.regency'])->where('id', $data['village_id'][$key])->first();
            $address = 'DS. '. $village->name. ', KEC. ' .$village->district->name. ', '. $village->district->regency->name;

            $eventDetail = new EventDetail(); 
            $eventDetail->event_id  = $event_id;
            $eventDetail->participant  = strtoupper($value);
            $eventDetail->address  = $address;
            $eventDetail->save();
        }

        // dd($address);

        // $address = '';
        // if ($request->village_id == null ) {
        //     $address = null;
        // }else{
        //     $village = Village::with(['district.regency'])->where('id', $request->village_id)->first();
        //     $address = 'DS. '. $village->name. ', KEC. ' .$village->district->name. ', '. $village->district->regency->name;
        // }

        // $eventDetail = new EventDetail();
        //     $eventDetail::create([
        //         'event_id' => $event_id,
        //         'participant' => strtoupper($request->name),
        //         'address' => $address
        //     ]);

        return redirect()->back()->with(['success' => 'Berhasil menambahkan peserta']);

    }

    public function storeAddRecipient(Request $request, $event_id)
    {

        if ($request->status == 'member') {

            #user_id
            $user  = User::select('id','name')->where('id', $request->member)->first();
            
            #get alamat
            $villages = Village::with(['district.regency'])->where('id', $request->village_id)->first();
            $village  = $villages->name;
            $district = $villages->district->name;
            $regency  = $villages->district->regency->name;

            $address = "DS. $village, KEC. $district, $regency";

            GiftRecipients::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'event_id' => $event_id,
                'address' => $address,
                'notes' => $request->note,
                'cby' => auth()->guard('admin')->user()->id
            ]);


        }else {

            GiftRecipients::create([
                'event_id' => $event_id,
                'name' => strtoupper($request->name),
                'address' => strtoupper($request->address),
                'notes' => $request->note,
                'cby' => auth()->guard('admin')->user()->id
            ]);

        }
       

        return redirect()->back()->with(['success' => 'Berhasil menambahkan penerima bingkisan']);

    }

    public function storeAddRecipientFamilyGroup(Request $request, $event_id)
    {
        $RequestFamilyGroupId = $request->family;
        $RequestMemberFamily  = $request->memberfamily;

        $userModel     = new User();

        #jika ketua familygroup ditentukan sebagai penerima
        #get user_id nya di tb users where user_id yg ada di tb family_group
        $userId = '';
        if ($request->selectedReceipent == '1') {
            $familyGroupModel = new FamilyGroup();
            $familyGroup      = $familyGroupModel->getDataFamilyGroup($RequestFamilyGroupId);

            $user   = $userModel->select('id','village_id','name')->where('id', $familyGroup->user_id)->first();
            $userId = $user->id;
            
        }else{
            
            $userId = $RequestMemberFamily; #bisa digunakna sebagai user_id
            $user  = $userModel->select('village_id','name')->where('id', $userId)->first();
            
        }


        #get alamat
        $villages = Village::with(['district.regency'])->where('id', $user->village_id)->first();
        $village  = $villages->name;
        $district = $villages->district->name;
        $regency  = $villages->district->regency->name;

        $address = "DS. $village, KEC. $district, $regency";

        GiftRecipients::create([
            'user_id' => $userId,
            'name' => $user->name,
            'event_id' => $event_id,
            'family_group_id' => $RequestFamilyGroupId,
            'address' => $address,
            'notes' => $request->note,
            'cby' => auth()->guard('admin')->user()->id
        ]);

        return redirect()->back()->with(['success' => 'Berhasil menambahkan penerima bingkisan']);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'event_category_id' => 'required',
            'address' => 'required',
        ]);

        Event::create([
            'event_category_id' => $request->event_category_id,
            'title' => $request->title,
            'description' => $request->desc,
            'time' => date('H:i', strtotime($request->time)),
            'date' => date('Y-m-d', strtotime($request->date)),
            'regency_id' => $request->regency_id,
            'dapil_id' => $request->dapil_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'address' => $request->address,
			'cby' => auth()->guard('admin')->user()->id
        ]);

        return redirect()->route('admin-event')->with(['success' => 'Event baru telah dibuat']);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'event_category_id' => 'required',
            'desc' => 'required',
        ]);

        $event = Event::where('id', $id)->first();
        $event->update([
            'event_category_id' => $request->event_category_id,
            'description' => $request->desc,
            'time' => date('H:i', strtotime($request->time)),
            'date' => date('Y-m-d', strtotime($request->date)),
            'regency_id' => $request->regency_id == null ? $event->regency_id : $request->regency_id,
            'dapil_id' => $request->dapil_id == null ? $event->dapil_id : $request->dapil_id,
            'district_id' => $request->district_id == null ? $event->district_id : $request->district_id,
            'village_id' => $request->village_id == null ? $event->village_id : $request->village_id
        ]);

        return redirect()->route('admin-event')->with(['success' => 'Event telah diubah']);
    }

    public function eventDetails($id)
    {
        $event_id =$id;
        $event_detail = EventDetail::orderBy('participant','asc')->where('event_id', $event_id)->get();
        $event = Event::select('title')->where('id', $event_id)->first();
        // $event_detail     = $evenDetailModel->getEventDetail($event_id);
        if (request()->ajax()) {
                return DataTables::of($event_detail)
                        ->addColumn('register', function($item){
                            $date = date('d-m-Y', strtotime($item->created_at));
                            return $date;
                        })
                        ->addColumn('no', function($item){
                            $no = 1;
                            return $no++;
                        })
                        ->rawColumns(['register','no'])
                        ->make(true);
                    }

        // biaya
        $cost = CostEvent::where('event_id', $event_id)->get();

        #penerima bingkisan
        $giftRicipient = GiftRecipients::with(['user'])->where('event_id', $event_id)->get();
        $gF = new GlobalProvider();
        $no1= 1;
        $no2= 1;
        
        return view('pages.admin.event.detail', compact('event','cost','gF','giftRicipient','no1','no2'));
    }

    public function costEventStore(Request $request, $id)
    {
        $request->validate([
            'file' => 'nullable|mimes:jpeg,jpg,png,pdf'
        ]);

        if ($request->hasFile('file')) {
                $fileImage = $request->file->store('assets/cost/event','public');

                // simpan juga ke directory cost politik
                $fileImage = $request->file->store('assets/cost/','public');
            }else{
                $fileImage = 'NULL';
            }

            $forecast = Forecast::where('id', $request->forecast_id)->first();

        // simpan ke cost event
            // id, event_id, nominal, file
        CostEvent::create([
            'event_id' => $id,
            'description' => $forecast->name,
            'nominal' => $request->nominal,
            'file' => $fileImage,
        ]);

        $eventModel = new Event();
        $event = $eventModel->getAddressEvent($id);

        $address = $event->village != null ? 'DS. ' .$event->village. ', KEC.'.$event->district. ', '.$event->regency : 'KEC. ' .$event->district. ', '.$event->regency;
        

        // simpan ke cost lest untuk pengeluaran polotik
            // 
        CostLess::create([
            'date' => date('Y-m-d'),
            'forcest_id' => $request->forecast_id,
            'forecast_desc_id' => $request->forecast_desc_id,
            'received_name' => $request->received_name,
            'address' => $address,
            'nominal' => $request->nominal,
            'file' => $fileImage,
        ]);

        return redirect()->route('admin-event')->with(['success' => 'Biaya event telah tersimpan']);
    }

    public function deleteGiftRicipient()
    {

        DB::beginTransaction();
        try {

            $id    = request()->id;

            GiftRecipients::where('id', $id)->delete();

            DB::commit();
            return ResponseFormatter::success([
                'message' => 'Berhasil hapus penerima bingkisan!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormatter::error([
                'message' => 'Something when wrong!',
                'error' => $e->getMessage()
            ]);
        }
    }

    
}
