<?php

namespace App\Exports;

use App\Transaksi;
use App\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$kategori = Kategori::orderBy('kategori','asc')->get();
    	if($_GET['kategori'] == ""){
    		$transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
    		->whereDate('tanggal','<=',$_GET['sampai'])
    		->get();
    	}else{
    		$transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
    		->whereDate('tanggal','>=',$_GET['dari'])
    		->whereDate('tanggal','<=',$_GET['sampai'])
    		->get();
    	}
            // $transaksi = Transaksi::orderBy('id','desc')->get();
    	return view('app.laporan_excel',['transaksi' => $transaksi, 'kategori' => $kategori]);
    	// return Kategori::all();
    }
}
