<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswa = $mahasiswa = DB::table('mahasiswa')->get(); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(3);
        // return view('mahasiswa.index', compact('mahasiswa'));
        // with('i', (request()->input('page', 1) - 1) * 5);

        // $mahasiswa = Mahasiswa::latest('nim')->paginate(3);
        // return view('mahasiswa.index', compact('mahasiswa'));
        
        $mahasiswa = Mahasiswa::latest('nim')->paginate(3);
        $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create');
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

    //fungsi eloquent untuk menambah data
    Mahasiswa::create($request->all());

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
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::where('nim', $Nim)->firstOrFail();
        //$Mahasiswa = Mahasiswa::where($Nim)->firstOrFail();
    return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
    $Mahasiswa = DB::table('mahasiswa')->where('nim', $Nim)->first();;
    return view('mahasiswa.edit', compact('Mahasiswa'));
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

    //fungsi eloquent untuk mengupdate data inputan kita
    //Mahasiswa::where($Nim)->update($request->all());
    Mahasiswa::where('nim', $Nim)->firstOrFail()->update($request->all());

    //jika data berhasil diupdate, akan kembali ke halaman utama
    return redirect()->route('mahasiswa.index')
    ->with('success', 'Mahasiswa Berhasil Diupdate');
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
        Mahasiswa::where('nim', $Nim)->firstOrFail()->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');  
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
