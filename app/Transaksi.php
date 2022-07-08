<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	protected $table = "transaksi";

	protected $fillable = ["tanggal","jenis","kategori_id","nominal","keterangan"];

	public function kategori()
	{
		return $this->belongsTo('App\Kategori');
	}
}
