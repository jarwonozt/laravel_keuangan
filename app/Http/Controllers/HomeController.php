<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Kategori;
use App\Transaksi;
use App\User;

use Hash;
use Auth;
use File;

use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kategori = Kategori::all();
        $transaksi = Transaksi::all();
        $tanggal = date('Y-m-d');
        $bulan = date('m');
        $tahun = date('Y');

        $pemasukan_hari_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereDate('tanggal',$tanggal)
        ->first();

        $pemasukan_bulan_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereMonth('tanggal',$bulan)
        ->first();

        $pemasukan_tahun_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereYear('tanggal',$tahun)
        ->first();

        $seluruh_pemasukan = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->first();

        $pengeluaran_hari_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereDate('tanggal',$tanggal)
        ->first();

        $pengeluaran_bulan_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereMonth('tanggal',$bulan)
        ->first();

        $pengeluaran_tahun_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereYear('tanggal',$tahun)
        ->first();

        $seluruh_pengeluaran = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->first();

        return view('app.index',
            [
                'pemasukan_hari_ini' => $pemasukan_hari_ini, 
                'pemasukan_bulan_ini' => $pemasukan_bulan_ini,
                'pemasukan_tahun_ini' => $pemasukan_tahun_ini,
                'seluruh_pemasukan' => $seluruh_pemasukan,
                'pengeluaran_hari_ini' => $pengeluaran_hari_ini, 
                'pengeluaran_bulan_ini' => $pengeluaran_bulan_ini,
                'pengeluaran_tahun_ini' => $pengeluaran_tahun_ini,
                'seluruh_pengeluaran' => $seluruh_pengeluaran,
                'kategori' => $kategori,
                'transaksi' => $transaksi,
            ]
        );
    }

    public function kategori()
    {
        $kategori = Kategori::orderBy('kategori','asc')->get();
        return view('app.kategori',['kategori' => $kategori]);
    }

    public function kategori_aksi(Request $req)
    {
        $nama = $req->input('nama');
        Kategori::create(['kategori' => $nama]);
        return redirect('kategori')->with('success','Kategori telah disimpan');
    }

    public function kategori_update($id, Request $req)
    {
        $nama = $req->input('nama');
        $kategori = Kategori::find($id);
        $kategori->kategori = $nama;
        $kategori->save();
        return redirect('kategori')->with('success','Kategori telah diupdate');
    }

    public function kategori_delete($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        $tt = Transaksi::where('kategori_id',$id)->get();

        if($tt->count() > 0){
            $transaksi = Transaksi::where('kategori_id',$id)->first();
            $transaksi->kategori_id = "1";
            $transaksi->save();
        }
        return redirect('kategori')->with('success','Kategori telah dihapus');
    }

    public function password()
    {
        return view('app.password');
    }

    public function password_update(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
        // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password telah diganti!");

    }


    public function transaksi()
    {
        $kategori = Kategori::orderBy('kategori','asc')->get();
        $transaksi = Transaksi::orderBy('id','desc')->get();
        return view('app.transaksi',['transaksi' => $transaksi, 'kategori' => $kategori]);
    }

    public function transaksi_aksi(Request $req)
    {
        $tanggal = $req->input('tanggal');
        $jenis = $req->input('jenis');
        $kategori = $req->input('kategori');
        $nominal = $req->input('nominal');
        $keterangan = $req->input('keterangan');

        Transaksi::create([
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'kategori_id' => $kategori,
            'nominal' => $nominal,
            'keterangan' => $keterangan,
        ]);

        return redirect()->back()->with("success","Transaksi telah disimpan!");
    }


    public function transaksi_update($id, Request $req)
    {
        $tanggal = $req->input('tanggal');
        $jenis = $req->input('jenis');
        $kategori = $req->input('kategori');
        $nominal = $req->input('nominal');
        $keterangan = $req->input('keterangan');

        $transaksi = Transaksi::find($id);
        $transaksi->tanggal = $tanggal;
        $transaksi->jenis = $jenis;
        $transaksi->kategori_id = $kategori;
        $transaksi->nominal = $nominal;
        $transaksi->keterangan = $keterangan;
        $transaksi->save();

        return redirect()->back()->with("success","Transaksi telah diupdate!");
    }

    public function transaksi_delete($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();
        return redirect()->back()->with("success","Transaksi telah dihapus!");
    }

    public function laporan()
    {
        if(isset($_GET['kategori'])){
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
            return view('app.laporan',['transaksi' => $transaksi, 'kategori' => $kategori]);
        }else{
            $kategori = Kategori::orderBy('kategori','asc')->get();
            // $transaksi = Transaksi::orderBy('id','desc')->get();
            return view('app.laporan',['transaksi' => array(), 'kategori' => $kategori]);
        }
    }

    public function laporan_print()
    {       
        if(isset($_GET['kategori'])){
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
            return view('app.laporan_print',['transaksi' => $transaksi, 'kategori' => $kategori]);
        }
    }

    public function laporan_excel()
    {
        return Excel::download(new LaporanExport, 'Laporan.xlsx');
    }

    public function user()
    {
        $user = User::all();
        return view('app.user',['user' => $user]);
    }

    public function user_add()
    {
        return view('app.user_tambah');
    }

    public function user_aksi(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'level' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('foto');
        
        // cek jika gambar kosong
        if($file != ""){
            // menambahkan waktu sebagai pembuat unik nnama file gambar
            $nama_file = time()."_".$file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'gambar/user';
            $file->move($tujuan_upload,$nama_file);
        }else{
            $nama_file = "";
        }
 
 
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => $request->level,
            'foto' => $nama_file
        ]);

        return redirect(route('user'))->with('success','User telah disimpan');
    }

    public function user_edit($id)
    {
        $user = User::find($id);
        return view('app.user_edit', ['user' => $user]);
    }

     public function user_update($id, Request $req)
    {
         $this->validate($req, [
            'nama' => 'required',
            'email' => 'required|email',
            'level' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $name = $req->input('nama');
        $email = $req->input('email');
        $password = $req->input('password');
        $level = $req->input('level');
        

        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        if($password != ""){
            $user->password = bcrypt($password);
        }

        // menyimpan data file yang diupload ke variabel $file
        $file = $req->file('foto');
        
        // cek jika gambar tidak kosong
        if($file != ""){
            // menambahkan waktu sebagai pembuat unik nnama file gambar
            $nama_file = time()."_".$file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'gambar/user';
            $file->move($tujuan_upload,$nama_file);

            // hapus file gambar lama
            File::delete('gambar/user/'.$user->foto);

            $user->foto = $nama_file;
        }
        $user->level = $level;
        $user->save();

        return redirect(route('user'))->with("success","User telah diupdate!");
    }

    public function user_delete($id)
    {
        $user = User::find($id);
        // hapus file gambar lama
        File::delete('gambar/user/'.$user->foto);
        $user->delete();

        return redirect(route('user'))->with("success","User telah dihapus!");
    }
}
