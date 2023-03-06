@extends('layouts.admin')
@section('title', 'Koordinator Pusat')
@push('addon-style')
    <link href="{{ asset('assets/style/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
@endpush
@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home mb-4" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Tambah Koordinator Pusat</h2>
                <p class="dashboard-subtitle">
                </p>
            </div>

            <div class="row mt-4">
                <div class="col-12 mt-2">
                    <div class="card card-body">
                        <div class="mt-1 mb-1">
                            @include('layouts.message')
                        </div>
                        <form action="{{ route('admin-struktur-organisasi-pusat-save') }}" id="register"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>NIK</label>
                                <input class="form-control" type="hidden" name="idx" value="{{$result_new_idx}}">
                                <input class="form-control" name="nik" placeholder="Input NIK">
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select name="jabatan" class="form-control" id="jabatan">
                                    <option value="">-Pilih Jabatan-</option>
                                    <option value="Ketua">Ketua</option>
                                    <option value="Wakil Ketua">Wakil Ketua</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Wakil Sekretaris">Wakil Sekretaris</option>
                                    <option value="Bendahara">Bendahara</option>
                                    <option value="Wakil Bendahara">Wakil Bendahara</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No.Hp / WA</label>
                                <input class="form-control" name="telp" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-sc-primary text-white" type="submit">Simpan</button>
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
    <script src="{{ asset('assets/vendor/vuetoasted/vue-toasted.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
    <script src="{{ asset('js/create-org-district.js') }}"></script>
@endpush
