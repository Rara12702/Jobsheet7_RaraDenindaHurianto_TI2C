<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\mataKuliah;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //index js 7
    // public function index(Request $request)
    // {
    //     //fungsi eloquent menampilkan data menggunakan pagination
    //     // $mahasiswa = $mahasiswa = DB::table('mahasiswa')->get(); // Mengambil semua isi tabel
    //     // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(3);
    //     // return view('mahasiswa.index', compact('mahasiswa'));
    //     // with('i', (request()->input('page', 1) - 1) * 5);

    //     // $mahasiswa = Mahasiswa::latest('nim')->paginate(3);
    //     // return view('mahasiswa.index', compact('mahasiswa'));
        
    //     $mahasiswa = Mahasiswa::latest('nim')->paginate(3);
    //     $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
    //     return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
    //     return view('mahasiswa.index', compact('mahasiswa'));
    // }

    public function index()
    {
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::OrderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index',['mahasiswa' =>$mahasiswa, 'paginate'=>$paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //js 7
        //return view('mahasiswa.create');

        $kelas = Kelas::all(); //mendapatkan ddata dari tabel kelas
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
    //melakukan validasi data
    $request->validate([
    'Nim' => 'required',
    'Nama' => 'required',
    'Kelas' => 'required',
    'Jurusan' => 'required',
    'Email' => 'required',
    'Alamat' => 'required',
    'Tanggal_lahir' => 'required',
    ]);

    $mahasiswa = new Mahasiswa;
    $mahasiswa->nim = $request->get('Nim');
    $mahasiswa->nama = $request->get('Nama');
    $mahasiswa->jurusan = $request->get('Jurusan');
    $mahasiswa->email = $request->get('Email');
    $mahasiswa->alamat = $request->get('Alamat');
    $mahasiswa->tanggal_lahir = $request->get('Tanggal_lahir');
    //$mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('Kelas');

    //fungsi eloquent untuk menambah data dengan relasi belongsTo
    $mahasiswa->kelas()->associate($kelas);
    $mahasiswa->save();

    //fungsi eloquent untuk menambah data
    //Mahasiswa::create($request->all());
    //$kelas = Kelas::all(); //mendapatkan data dari tabel kelas
    //jika data berhasil ditambahkan, akan kembali ke halaman utama
    return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //js 7
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        //$Mahasiswa = Mahasiswa::where('nim', $Nim)->firstOrFail();
        //$Mahasiswa = Mahasiswa::where($Nim)->firstOrFail();
        //return view('mahasiswa.detail', compact('Mahasiswa'));
        $mahasiswa = Mahasiswa::With('kelas')->where('nim', $Nim)->first();
         return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //js 7
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        // $Mahasiswa = DB::table('mahasiswa')->where('nim', $Nim)->first();;
        // return view('mahasiswa.edit', compact('Mahasiswa'));
        
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
    $request->validate([
    'Nim' => 'required',
    'Nama' => 'required',
    'Kelas' => 'required',
    'Jurusan' => 'required',
    'Email' => 'required',
    'Alamat' => 'required',
    'Tanggal_lahir' => 'required',
    ]);

    $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
    $mahasiswa->nim = $request->get('Nim');
    $mahasiswa->nama = $request->get('Nama');
    $mahasiswa->jurusan = $request->get('Jurusan');
    $mahasiswa->email = $request->get('Email');
    $mahasiswa->alamat = $request->get('Alamat');
    $mahasiswa->tanggal_lahir = $request->get('Tanggal_lahir');
    //  $mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('Kelas');

    $mahasiswa->kelas()->associate($kelas);
    $mahasiswa->save();

    //fungsi eloquent untuk mengupdate data inputan kita
    //Mahasiswa::where($Nim)->update($request->all());
    //Mahasiswa::where('nim', $Nim)->firstOrFail()->update($request->all());

    //jika data berhasil diupdate, akan kembali ke halaman utama
    return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
      //fungsi eloquent untuk menghapus data
        //Mahasiswa::where($Nim)->delete();
        //Mahasiswa::where('nim', $Nim)->firstOrFail()->delete();
        Mahasiswa::where('nim', $Nim)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
          
    }

    public function nilai($Nim){
        $nilai = Mahasiswa::with('kelas', 'matakuliah')->find($Nim);
        return view('mahasiswa.nilai',compact('nilai'));
    }

    public function searchMahasiswa(Request $request)
    {
        $search     = $request->search;
        $mahasiswa  = Mahasiswa::where("nim", "LIKE", "%$search%")
            ->orWhere("nama", "LIKE", "%$search%")
            ->orWhere("kelas", "LIKE", "%$search%")
            ->orWhere("jurusan", "LIKE", "%$search%")
            ->orWhere("email", "LIKE", "%$search%")
            ->orWhere("alamat", "LIKE", "%$search%")
            ->orWhere("tanggal_lahir", "LIKE", "%$search%")
            ->paginate(3);
        return view('mahasiswa.index', compact('mahasiswa'));
    }
};