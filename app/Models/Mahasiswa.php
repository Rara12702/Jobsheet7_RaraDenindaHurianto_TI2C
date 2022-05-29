<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Model //Definisi Model
{
    protected $table='mahasiswa'; // Eloquent akan membuat model mahasiswa menyimpan record ditabel mahasiswa
    protected $primaryKey = 'id_mahasiswa'; // Memanggil isi DB Dengan primarykey
    /**
    * The attributes that are mass assignable.
    **
    * @var array
    */

        protected $fillable = [
        'Nim',
        'Nama',
        'Kelas',
        'Jurusan',
        'Email',
        'Alamat',
        'Tanggal_lahir',
    ];

    // for search
    public static function getByNim($Nim)
    {
        return self::where('nim', $Nim)->firstOrFail();
    }
};
