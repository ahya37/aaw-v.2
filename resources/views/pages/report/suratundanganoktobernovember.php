<html>
    <head>
        <title>SURAT UNDANGAN</title>
    </head>
    <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 50px;
				height: 100%;
            }

            header {
                position: absolute;
                top: -100px;
                left: 0px;
                right: 0px; 

                /** Extra personal styles **/
                color: rgb(8, 7, 7);
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -100px; 
                left: 0px; 
                right: 0px;
                height: 100px; 

                /** Extra personal styles **/
                color: rgb(8, 7, 7);
                text-align: right;
                line-height: 90px;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;

            }
            #table {
            font-family: Arial, Helvetica, sans-serif;
            color: #666;
            text-shadow: 1px 1px 0px #fff;
            background: #eaebec;
            border: #ccc 1px solid;
            width: 100%
            }
            #table th {
            font-size: 12px;
            padding: 9px auto;
            border-left:1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            background:   #34495e;
            color: #fff;
            }
            #table td {
            font-size: 12px;
            padding: 5px auto;
            border-left:1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            background:  #fff ;
            color: #000;
            padding-left: 5px;
            } 
			  
			#table1 {
				font-family: Arial, Helvetica, sans-serif;
				border: none;
				cellspacing:0;
				margin-bottom: 10px;
				cellspacing:0;
				margin-top:75px;
				font-size: 13px;
            }
			
			#table2 {
				font-family: Arial, Helvetica, sans-serif;
				border: none;
				cellspacing:0;
				margin-bottom: 10px;
				cellspacing:0;
				margin-top:8px;
				font-size: 13px;
				margin-left:10px;
            }
			
			.fonts {
				font-family: Arial, Helvetica, sans-serif;
			}
			
			.fonts2 {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 13px;
			}
			
        </style>
    
<body>
    <header>
	<img src="{{asset('assets/images/kopsurataaw.png')}}" width="800" style="margin-top:-2px">
	<h4 style="margin-top:-4px;" class="fonts">SURAT UNDANGAN</h4> 
    </header>
	<section>
		<table id="table1">
			<tr>
				<td>Nomor</td><td>:</td><td>ISTIMEWA</td>
			</tr>
			<tr>
				<td>Lampiran</td><td>:</td><td>1 Lampiran</td> 
			</tr>
			<tr>
				<td>Perihal</td><td>:</td><td>Surat Undangan Konsolidasi Jaringan Dulur Kang Asep Awaludin</td>
			</tr>
			<tr>
				<td>Sifat</td><td>:</td><td>Wajib</td>
			</tr>
		</table>
		 
         <table id="table2" width="100%">
			<tr> 
				<td>Kepada</td> 
			</tr>
			<tr> 
				<td>Yth. Bapak/Ibu <b>Korcam dan Kordes</b></td> 
			</tr>
			<tr>
				<td>di tempat</td>
			</tr>
		</table>
	</section>
	
	<section>
	
	</section>
		<p class="fonts2">Assalamu’alaikum Warahmatullahi Wabarakatuh</p>
     <section>
		<p class="fonts2">
		Seiring salam dan do’a kami sampaikan semoga bapak/ibu dalam keadaan sehat dan berada dalam lindungan Allah SWT Amin.
		<br>
		<br>
		Bersama dengan surat ini, diwajibkan  untuk kehadiran  <b>Tim Jaringan Dulur AAW Korcam dan Kordes</b> yang akan diselenggarakan pada :</p>
		
		<table id="table2">
			<tr> 
				<td>Hari dan tanggal</td><td>:</td><td>{{$hari}}</td>
			</tr>
			<tr> 
				<td>Waktu</td><td>:</td><td>{{$jam}}</td>
			</tr>
			<tr> 
				<td>Lokasi</td><td>:</td><td>{{$lokasi}}</td>
			</tr>
		</table>
	 </section>
	 <section>
		<p>Demikian Surat ini dibuat, atas dukungan dan kerjasamanya kami ucapkan terima kasih. 
		<br>
		Wassalamu’alaikum Warahmatullahi Wabarakatuh</p>
	 </section>
	 <section class="fonts2" style="text-align: right; margin-bottom:172px;"> 
		<p style="margin-top:35px;">{{$lok_surat}}, {{date('d/m/Y')}}<p>
		<p>Hormat Kami<p>
		<br>
		<b>(SEKERTARIAT JARINGAN DULUR AAW)</b> 
		</p>
	 </section>
	 <section>
	 	<h4 style="margin-top:-4px;" class="fonts">LAMPIRAN</h4> 
	 </section>

	 <section>
	 	<h4>Daftar Korcam</h4>
	 	<table class="table1">
	 		<thead>
	 			<tr>
	 				<th>NO</th>
	 				<th>NAMA</th>
	 				<th>JABATAN</th>
	 			</tr>
	 		</thead>
	 		<tbody>
	 			@php
	 				$no_korcam = 1;
	 			@endphp
	 			@foreach($korcam as $item)
	 			<tr>
	 				<td>{{$no_korcam}}</td>
	 				<td>{{$item->name}}</td>
	 				<td></td>
	 			</tr>
	 			@endforeach
	 		</tbody>
	 	</table>
	 </section>
</body>
</html> 