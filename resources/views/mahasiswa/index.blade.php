@extends('mahasiswa.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
            </div>
            <br><br>
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                        <p>{{ $message }}</p>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-error">
                        <p>{{ $message }}</p>
            </div>
            @endif
            <form class="form-inline" method="POST" action="{{ route('mahasiswa.search') }}">
                @csrf
                <input name="search" class="form-control mr-sm-2" type="text" autocomplete="off"
                    placeholder="Ketik yang Anda Cari">
                <button class="btn btn-success" type="submit">Cari Mahasiswa</button>
            </form>
        </div>
</div>
    
    <table class="table table-bordered">
    <tr>
        <th>Nim</th>
        <th>Nama</th>
        <th>Foto</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th>Email</th>
        <th>Alamat</th>   
        <th>Tanggal Lahir</th>
        <th width="280px">Action</th>
    </tr>

    @foreach($paginate as $mhs)
                        <tr>
                        <td>{{ $mhs ->nim }}</td>
                        <td>{{ $mhs ->nama }}</td>
                        <!-- <td><img width="50px"
                            src="{{ $mhs->foto ? asset('storage/' . $mhs->foto) : asset('storage/images/default.png') }}"
                            alt="{{ $mhs->foto }}"> -->
                        <td><img width="150px" src="{{ asset('storage/' . $mhs->foto) }}"></td>
                        <td>{{ $mhs ->kelas->nama_kelas }}</td>
                        <td>{{ $mhs ->jurusan }}</td>
                        <td>{{ $mhs ->email }}</td>
                        <td>{{ $mhs ->alamat }}</td>
                        <td>{{ $mhs ->tanggal_lahir }}</td>
                        <td>
                        <form action="{{ route('mahasiswa.destroy',['mahasiswa'=>$mhs->nim]) }}" method="POST">

                                    <a class="btn btn-info" href="{{ route('mahasiswa.show',$mhs->nim) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$mhs->nim) }}">Edit</a>
            @csrf
            @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <br>
                        <a class="btn btn-warning" href="{{ route('mahasiswa.nilai',$mhs->nim) }}">Nilai</a>
                    </form>
                        </td>
                        </tr>
 @endforeach
</table>

{!! $paginate->links() !!}

@endsection 