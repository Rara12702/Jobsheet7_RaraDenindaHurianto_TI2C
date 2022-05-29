<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\mataKuliah;

class Mahasiswa extends Model //Definisi Model
{
    protected $table='mahasiswa'; //eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswa
    protected $primaryKey='nim'; //memamnggil isi DB dengan primay key
    
    //js 7
    //protected $primaryKey = 'id_mahasiswa'; // Memanggil isi DB Dengan primarykey
    /**
    * The attributes that are mass assignable.
    **
    * @var array
    */

        protected $fillable = [
            'nim',
            'nama',
            'kelas_id',
            'jurusan',
            'email',
            'alamat',
            'tanggal_lahir',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function matakuliah(){
        return $this->belongsToMany(mataKuliah::class, 'mahasiswa_matakuliah', 'mahasiswa_id', 'matakuliah_id')
            ->withPivot('nilai');
    }
    
    // for search
    public static function getByNim($Nim)
    {
        return self::where('nim', $Nim)->firstOrFail();
    }
};