@extends('layouts.admin')
@section('title', 'Struktur Desa')
@push('addon-style')
    <link href="{{ asset('assets/style/style.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/datatables.min.css') }}" />
@endpush
@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home mb-4" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Daftar Struktur Organisasi Desa</h2>
            </div>
            <div class="dashboard-content mt-4" id="transactionDetails">
                <div class="card card-body mb-4">
                    <div class="row">
                            {{-- <div class="col-md-3"> --}}
                                <div class="form-group">
                                    <input value="{{ $regency->id }}" type="hidden" id="regencyId" class="form-control">
                                </div>
                            {{-- </div> --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="dapil_id" id="selectListArea" class="form-control filter" required></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="district_id" id="selectDistrictId" class="form-control filter"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="village_id" id="selectVillageId" class="form-control filter"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="rt" id="selectRt" class="form-control filter">
                                    </select>
                                </div>
                            </div>
                    </div>

                    <div class="row col-md-12">
                        <a class="btn btn-sm btn-sc-primary text-white" href="{{ route('admin-struktur-organisasi-village-create') }}">+ Tambah</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        @include('layouts.message')
                        <form action="{{ route('admin-event-store') }}" id="register" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <table id="data" class="table table-sm table-striped" width="100%">
                                        <thead>
                                          <tr>
                                            <th scope="col"></th>
                                            <th scope="col">NAMA</th>
                                            <th scope="col">ALAMAT</th>
                                            <th scope="col">RT</th>
                                            <th scope="col">RW</th>
                                            <th scope="col">JABATAN</th>
                                            <th scope="col">NO HP / WA</th>
                                          </tr>
                                        </thead>
                                        <tbody></tbody>
                                      </table>
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
<script type="text/javascript" src="{{ asset('assets/vendor/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('js/org-village-index.js') }}"></script>
    <script>
        AOS.init();
    </script>
@endpush
