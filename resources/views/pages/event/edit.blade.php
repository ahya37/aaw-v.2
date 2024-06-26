@extends('layouts.app')
@section('title','Edit Event')
@push('addon-style')
    <link href="{{ asset('assets/style/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<!-- Section Content -->
 <div
            class="section-content section-dashboard-home mb-4"
            data-aos="fade-up"
          >
            <div class="container-fluid">
                <div class="dashboard-heading">
                    <h2 class="dashboard-title">Buat Event Baru</h2>
                <p class="dashboard-subtitle">
                </p>
            </div>
            <div class="dashboard-content mt-4" id="transactionDetails">
                <div class="row">
                    <div class="col-md-7 col-sm-12">
                      @include('layouts.message')
                    <form action="{{ route('member-event-update', $event->id) }}" id="register" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="card">
                        <div class="card-body">
                         <div class="row row-login">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <label>Judul Event</label>
                                                <input type="text" name="title" value="{{ $event->title }}" required class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <label>Isi Pengumuman</label>
                                                <textarea name="desc"  required class="form-control" >{{ $event->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <label>Tanggal Event</label>
                                                <input
                                                id="datetimepicker6"
                                                type="text"
                                                class="form-control"
                                                name="date"
                                                autocomplete="off"
                                                value="{{ $event->date }}"
                                                required >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <label>Waktu Event</label>
                                                <input id="timepicker6" type="text" name="time" value="{{ $event->time }}"  required class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                     <hr>
                                     <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 ">
                                                <div class="alert alert-info">Alamat Event</div>
                                            </div>
                                        </div>
                                     </div>
                                      <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 ">
                                                <select name="regency_id" id="selectArea"   class="form-control" >
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 ">
                                                <select name="dapil_id" id="selectListArea"  class="form-control" >
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 ">
                                                <select name="district_id" id="selectDistrictId"  class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 ">
                                                <select name="village_id" id="selectVillageId"  class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                       
                                    <div class="form-group">
                                        <button
                                        type="submit"
                                        class="btn btn-sc-primary text-white  btn-block w-00 mt-4"
                                        >
                                        Simpan
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@push('addon-script')
<script src="{{ asset('assets/vendor/vue/vue.js') }}"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
<script>
    AOS.init();
</script>
<script src="{{ asset('js/event-create.js') }}"></script>

@endpush