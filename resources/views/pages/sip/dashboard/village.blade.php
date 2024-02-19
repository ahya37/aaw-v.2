@extends('layouts.sip.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
		
@endpush
@section('content')
    <div class="container">
        <div class="page-content">
		
		   <div class="card"> 
                <div class="card-body">
					<p id="district"></p>
                </div> 
              </div>  
			   
              <div class="card">
                <div class="card-body">
                <canvas id="myChart"></canvas> 
                </div> 
              </div>
			  
			   <div class="card"> 
                <div class="card-body">
					<table class='table' id='datatable'>
						<thead>
							<tr> 
								<th class="text-center">NO</th>
								<th>DESA</th>
								<th class="text-center">TPS</th>
								<th class="text-center">ANGGOTA</th>
								<th class="text-center">PESERTA KUNJUNGAN</th>
								<th class="text-center">SUARA</th> 
								<th class="text-center">%</th> 
							</tr>
						</thead>
						<tbody id="datasuara"></tbody>
						<tfoot id="datajmlsuara">
							<tr> 
								<td colspan="2" align="right"><b>JUMLAH</b></td>
								<td id="jmltps"  class="text-center"></td>
								<td id="jmlanggota"  class="text-center"></td>  
								<td id="jmlpesertakunjungan"  class="text-center"></td>  
								<td id="jmlhasilsuara"  class="text-center"></td>  
								<td id="jmlpersentage"  class="text-center"></td>  
							</tr>
						</tfoot>
					</table>
                </div> 
              </div> 
			  
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="{{ asset('js/sip/village.js') }}"></script>
@endpush