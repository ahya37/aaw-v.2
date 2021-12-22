<html>
    <head>
        <title>ANGGOTA BERDASARKAN REFERAL </title>
    </head>
    <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }

            header {
                position: fixed;
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
            table {
            font-family: Arial, Helvetica, sans-serif;
            color: #666;
            text-shadow: 1px 1px 0px #fff;
            background: #eaebec;
            border: #ccc 1px solid;
            width: 100%
            }
            table th {
            font-size: 10px;
            padding: 5px auto;
            border-left:1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            background:   #34495e;
            color: #fff;
            }
            table td {
            font-size: 10px;
            padding: 5px auto;
            border-left:1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            background:  #fff ;
            color: #000;
            padding-left: 5px;
            }
        </style>
    
<body>
    <header>
        <h5>
            LAPORAN ANGGOTA REFERAL
        </h5> 
        <hr>
    </header>
    <div style="margin-bottom: 2px">
        <small>REFERAL   : {{ $user->name }}</small>
    </div>
        <section align="justify">
            <table cellspacing='0'>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>DESA</th>
                        <th>KECAMATAN</th>
                        <th>KABUPATEN / KOTA</th>
                        <th>PROVINSI</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>TELEPON</th>
                        <th>WHATSAPP</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($members as $row)
                   <tr>
                       <td>{{ $no++ }}</td>
                       <td>{{ $row->name }}</td>
                       <td>{{ $row->village }}</td>
                       <td>{{ $row->district }}</td>
                       <td>{{ $row->regency }}</td>
                       <td>{{ $row->province }}</td>
                       <td>{{ $row->rt }}</td>
                       <td>{{ $row->rw }}</td>
                       <td>{{ $row->phone_number }}</td>
                       <td>{{ $row->whatsapp }}</td>
                   </tr>                       
                   @endforeach
                </tbody>
            </table>
        </section>
        
         <footer>
             <small>
                 {{-- Dicetak Oleh : {{ auth()->guard('admin')->user()->name }} --}}
             </small>
        </footer>
</body>
</html>