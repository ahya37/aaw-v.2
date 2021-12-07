@extends('layouts.admin')
@push('addon-style')
    <link
      href="{{ asset('assets/style/style.css') }}"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endpush
@section('title','Dashboard')
@section('content')
<!-- Section Content -->
 <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title mb-4">Dashboard</h2>
                 <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin-dashboard') }}">NASIONAL</a></li>
                     <li class="breadcrumb-item">PROVINSI {{ $province->name }}</li>
                  </ol>
                </nav>

                <div class="dashboard-content">
                  <div class="row mb-2">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-1 col-sm-1">
                              <div class="dropdown show">
                              <a class="btn btn-sm border border-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                PDF
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <a href="{{ route('pdf-members-province', $province->id) }}" class="dropdown-item">Daftar Anggota</a>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-2 col-sm-2">
                          <div class="dropdown show">
                            <a class="btn btn-sm border border-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Excel
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a href="{{ route('report-member-province-excel', $province->id) }}" class="dropdown-item">Anggota Terdaftar</a>
                            <a href="{{ route('report-jobprovince-excel', $province->id) }}" class="dropdown-item">Profesi</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-md-12">
                    
                    <div id="infoTotalRegion" class="alert alert-info">
                      
                    </div>
                  </div>
                </div>
              </div>
             <div class="dashboard-content">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card mb-2 bg-info">
                      <a href="{{ route('members-province', $province->id) }}">
                        <div class="card-body">
                          <div class="dashboard-card-title text-white">
                            Jumlah Anggota
                          </div>
                          <div class="dashboard-card-subtitle">
                            <h4 class="text-white" id="total_member"></h4>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cd-card-primary">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          % Jumlah Anggota
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white" id="total_member_persen"></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cs-card-danger">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          Target Anggota
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white" id="target_anggota"></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="card mb-2 bg-info">
                      <a href="{{ route('villagefilled-province', $province->id) }}">
                        <div class="card-body">
                          <div class="dashboard-card-title text-white">
                            Jumlah Desa Terisi
                          </div>
                          <div class="dashboard-card-subtitle">
                            <h4 class="text-white" id="village_filled"></h4>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cd-card-primary">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          % Desa
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white" id="village_filled_persen"></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2 text-white cs-card-danger">
                      <div class="card-body">
                        <div class="dashboard-card-title text-white">
                          Total Desa
                        </div>
                        <div class="dashboard-card-subtitle">
                          <h4 class="text-white" id="total_village"></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="dashboard-content mt-3">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card mb-2">
                      <div class="card-body">
                         <div id="loadProvince" class="d-none lds-dual-ring hidden overlay">
                          </div>
                          <div class="wrapper" width="100%"> 
                          <div id="districts"></div>
                        </div> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>

               <div class="dashboard-content mt-3">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Terdaftar VS Target (%)</h6>
                         <div id="LoadmemberRegister" class="d-none lds-dual-ring hidden overlay">
                          </div>
                          <div class="wrapper" width="100%"> 
                          <canvas id="memberRegister" width="600" height="250"></canvas> 
                        </div> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="dashboard-content mt-3">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Berdasarkan Jenis Kelamin (%)</h6>
                        <div id="Loadgender" class="d-none lds-dual-ring hidden overlay">
                          </div>
                        <div id="gender"></div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="card-body cart-gender-male text-center">
                            <span class="text-white">Laki-laki</span>
                            <br>
                            <span class="text-white" id="totalMaleGender">
                            </span>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="card-body text-center cart-gender-female">
                            <span class="text-white">Perempuan</span>
                            <br>
                            <span class="text-white" id="totalfemaleGender">
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Berdasarkan Pekerjaan (%)</h6>
                       <div>
                          <div id="Loadjobs" class="d-none lds-dual-ring hidden overlay">
                          </div>
                          <canvas width="" id="jobs"></canvas>
                        </div>
                      </div>
                      {{-- <div class="col-md-12 col-sm-12">
                        <small>Kategori Pekerjaan Terbanyak</small>
                        <div class="row">
                          @foreach ($most_jobs as $row)
                          <div class="col-md-2 col-sm-2 mt-3 mb-2">
                           <div class="btn btn-primary w-20" data-toggle="tooltip" data-placement="top" title="{{ $row->name }} : {{ $row->total_job }}">
                            <small>
                              {{ $row->total_job }}
                            </small>
                          </div>
                          </div>
                          @endforeach
                       </div>
                      </div> --}}
                    </div>
                  </div>
                  <div class="col-md-6 mt-3">
                    <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Berdasarkan Kelompok Umur</h6>
                        <div>
                          <div id="LoadageGroup" class="d-none lds-dual-ring hidden overlay">
                            </div>
                          <canvas id="ageGroup"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mt-3">
                    <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Berdasarkan Generasi Umur</h6>
                         <div id="LoadageGen" class="d-none lds-dual-ring hidden overlay">
                          </div>
                        <div>
                          <canvas id="ageGen"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-12">
                    <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Admin Berdasarkan Input Terbanyak</h6>
                        <div>
                           <div id="Loadinputer" class="d-none lds-dual-ring hidden overlay">
                          </div>
                          <canvas id="inputer"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Berdasarkan Referal Terbanyak</h6>
                        <div>
                          <div id="Loadreferal" class="d-none lds-dual-ring hidden overlay">
                          </div>
                          <canvas id="referal"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-12">
                    <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Capaian Anggota Perhari</h6>
                        <div class="row">
                          <div class="col-12">
                            <div class="input-group mb-3 col-md-4 float-right">
                                <input type="text" id="created_at" name="date" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-12" id="divMemberPerMonth">
                            <canvas id="memberPerMonth"></canvas>
                          </div>
                      </div>
                      <div>
                        <input type="hidden" value="{{ $province->id }}" id="provinceID">
                      </div>
                    </div>
                  </div>
                  <div class="row">

                    <div class="col-md-12">
                     <div class="card mb-2">
                       <div class="card-body">
                         <div class="dashboard-card-title">
                           Daftar Pencapaian Lokasi / Daerah
                         </div>
                         <div class="dashboard-card-subtitle">
                           <div class="table-responsive mt-2">
                               <table id="achievment" class="table table-sm table-striped">
                                   <thead>
                                     <tr>
                                     <th scope="col">Kabupaten/Kota</th>
                                     <th scope="col">Total Target / Kabupaten</th>
                                     <th scope="col">Total Kecamatan</th>
                                     <th scope="col">Realisasi Jumlah Anggota</th>
                                     <th scope="col">Persentasi</th>
                                     <th scope="col">Pencapaian Hari Ini</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                                 </table>
                            </div>
                         </div>
                       </div>
                     </div>
                   </div>

                   <div class="col-md-12 col-sm-12">
                     <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Referal Terbanyak Perbulan</h6>
                        <div class="row">
                          <div class="col-12">
                            <div class="input-group mb-3 col-md-3 float-right">
                              <button onclick="acumulate()" class="btn btn-sm btn-default border mr-2">Akumulasi</button>
                                <input type="text" id="referalOfMount" name="referalOfMount" value="{{ date('M') }}" class="form-control datepicker">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                          <div class="table-responsive mt-3">
                            <table id="dtshowReferalDataReferalByMounth" class="data table table-sm table-striped" width="100%">
                              <thead>
                               
                                  <th scope="col">NO</th>
                                  <th scope="col"></th>
                                  <th scope="col">NAMA</th>
                                  <th scope="col">REFERAL LANGSUNG</th>
                                  <th scope="col">REFERAL TIDAK LANGSUNG</th>
                                  <th scope="col">TOTAL REFERAL</th>
                                  <th scope="col">ALAMAT</th>
                                  <th scope="col">KONTAK</th>
                                </tr>
                                 <tr>
                                    <th colspan="7" id="LoadaReferalByMounth" class="d-none lds-dual-ring hidden overlay"></th>
                                  </tr>
                                <tr>
                                </thead>
                                <tbody id="showReferalDataReferalByMounth">
                                </tbody>
                              </table>
                          </div>
                      </div>
                    </div>
                  </div>
                   </div>

                   <div class="col-md-12 col-sm-12">
                     <div class="card mb-2">
                      <div class="card-body">
                        <h6 class="text-center">Anggota Input Terbanyak</h6>
                        {{-- <div class="row">
                          <div class="col-12">
                            <div class="input-group mb-3 col-md-4 float-right">
                                <input type="text" id="inputerByMonth" name="referalOfMount " class="form-control datepicker">
                          </div>
                        </div>
                      </div> --}}

                      <div class="row">
                          <div class="table-responsive mt-3">
                            <table id="dtshowInputerDataInputerByMounth" class="data table table-sm table-striped" width="100%">
                              <thead>
                               <tr>
                                  <th scope="col"></th>
                                  <th scope="col">NAMA</th>
                                  <th scope="col">JUMLAH ANGGOTA</th>
                                  <th scope="col">ALAMAT</th>
                                  <th scope="col">KONTAK</th>
                                </tr>
                                </thead>
                                
                              </table>
                          </div>
                      </div>
                    </div>
                  </div>
                   </div>
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@push('addon-script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="{{ asset('assets/vendor/highcharts/highcharts.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>  
<script src="{{ asset('js/dashboard-province.js') }}" ></script>
<script>
       var datatable = $('#achievment').DataTable({
            processing: true,
            language:{
              processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
            },
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns:[
                {data: 'name', name:'name'},
                {data: 'target_member', name:'target_member',className: "text-right"},
                {data: 'total_district', name:'total_district', className: "text-right"},
                {data: 'realisasi_member', name:'realisasi_member',className: "text-right"},
                {data: 'persentage', name:'persentage'},
                {data: 'todays_achievement', name:'todays_achievement',className: "text-right"}

            ],
              columnDefs: [
              {
                targets: [1,2,3,5],
                render: $.fn.dataTable.render.number('.', '.', 0, '')
              }
            ],
        });
</script>
@endpush