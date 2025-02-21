<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmprfids extends Model
{
    use HasFactory;

    protected $table = 'tmprfids'; // Nama tabel
    protected $primaryKey = 'nokartu'; // Primary key adalah nokartu
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe data primary key

    protected $fillable = [
        'nokartu', // Kolom yang bisa diisi
    ];

    public $timestamps = true; // Gunakan timestamps
}
