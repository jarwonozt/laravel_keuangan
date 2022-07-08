@extends('app.master')

@section('konten')

<div class="content-body">

  <div class="row page-titles mx-0 mt-2">
   
   <h3 class="col p-md-0">Laporan Keuangan</h3>

    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan</a></li>
      </ol>
    </div>
  </div>

  <div class="container-fluid">


    <div class="card">

      <div class="card-header pt-4">
        <h3 class="card-title">Filter Laporan</h3>
      </div>
      <div class="card-body">

        <form method="GET" action="{{ route('laporan') }}">
          @csrf
          <div class="row">

            <div class="col-lg-offset-2 col-lg-3">
              <div class="form-group">
                <label>Dari Tanggal</label>
                <input class="form-control datepicker2" placeholder="Dari Tanggal" type="text" required="required" name="dari" value="<?php if(isset($_GET['dari'])){echo $_GET['dari'];} ?>">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group">
                <label>Sampai Tanggal</label>
                <input class="form-control datepicker2" placeholder="Sampai Tanggal" type="text" required="required" name="sampai" value="<?php if(isset($_GET['sampai'])){echo $_GET['sampai'];} ?>">
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label>Kategori</label>
                <select class="form-control" name="kategori">
                  <option value="">Semua Kategori</option>
                  @foreach($kategori as $k)
                  <option <?php if(isset($_GET['kategori'])){ if($_GET['kategori'] == $k->id){echo "selected='selected'";} } ?> value="{{ $k->id }}">{{ $k->kategori }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Tampilkan" style="margin-top: 25px">
              </div>
            </div>

          </div>

        </form>
        <br>
      </div>

    </div>


    @if(isset($_GET['kategori']))

        <div class="card">

          <div class="card-header pt-4">
            <h3 class="card-title">Data Laporan Keuangan</h3>
          </div>
          <div class="card-body">

            <table style="width: 50%">
              <tr>
                <th width="25%">DARI TANGGAL</th>
                <th width="5%" class="text-center">:</th>
                <td>{{ date('d-m-Y',strtotime($_GET['dari'])) }}</td>
              </tr>
              <tr>
                <th width="25%">SAMPAI TANGGAL</th>
                <th width="5%" class="text-center">:</th>
                <td>{{ date('d-m-Y',strtotime($_GET['sampai'])) }}</td>
              </tr>
              <tr>
                <th width="25%">KATEGORI</th>
                <th width="5%" class="text-center">:</th>
                <td>
                  @php
                  $id_kategori = $_GET['kategori'];
                  @endphp

                  @if($id_kategori == "")
                    @php
                    $kat = "SEMUA KATEGORI";
                    @endphp
                  @else
                    @php
                      $katt = DB::table('kategori')->where('id',$id_kategori)->first();
                      $kat = $katt->kategori
                    @endphp
                  @endif

                  {{$kat}}
                </td>
              </tr>
            </table>

            <br>
            <br>
            <a target="_BLANK" href="{{ route('laporan_excel',['kategori' => $_GET['kategori'], 'dari' => $_GET['dari'], 'sampai' => $_GET['sampai']]) }}" class="btn btn-outline-secondary"><i class="fa fa-file-excel-o "></i> &nbsp; CETAK EXCEL</a>
            <a target="_BLANK" href="{{ route('laporan_print',['kategori' => $_GET['kategori'], 'dari' => $_GET['dari'], 'sampai' => $_GET['sampai']]) }}" class="btn btn-outline-secondary"><i class="fa fa-print "></i> &nbsp; CETAK PRINT</a>
            <br>
            <br>
            <br>

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan="2" class="text-center" width="1%">NO</th>
                    <th rowspan="2" class="text-center" width="9%">TANGGAL</th>
                    <th rowspan="2" class="text-center">KATEGORI</th>
                    <th rowspan="2" class="text-center">KETERANGAN</th>
                    <th colspan="2" class="text-center">JENIS</th>
                  </tr>
                  <tr>
                    <th class="text-center">PEMASUKAN</th>
                    <th class="text-center">PENGELUARAN</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $no = 1;
                  $total_pemasukan = 0;
                  $total_pengeluaran = 0;
                  @endphp
                  @foreach($transaksi as $t)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($t->tanggal )) }}</td>
                    <td>{{ $t->kategori->kategori }}</td>
                    <td>{{ $t->keterangan }}</td>
                    <td class="text-center">
                      @if($t->jenis == "Pemasukan")
                      {{ "Rp.".number_format($t->nominal).",-" }}
                      @php $total_pemasukan += $t->nominal; @endphp
                      @else
                      {{ "-" }}
                      @endif
                    </td>
                    <td class="text-center">
                      @if($t->jenis == "Pengeluaran")
                      {{ "Rp.".number_format($t->nominal).",-" }}
                      @php $total_pengeluaran += $t->nominal; @endphp
                      @else
                      {{ "-" }}
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot class="bg-info text-white font-weight-bold">
                  <tr>
                    <td colspan="4" class="text-bold text-right">TOTAL</td>
                    <td class="text-center">{{ "Rp.".number_format($total_pemasukan).",-" }}</td>
                    <td class="text-center">{{ "Rp.".number_format($total_pengeluaran).",-" }}</td>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>

        </div>
        @endif



  </div>
  <!-- #/ container -->
</div>

@endsection