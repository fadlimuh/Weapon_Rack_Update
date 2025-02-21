<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weapons extends Model
{
    use HasFactory;

    protected $table = 'weapons';

    protected $primaryKey = 'loadCellID';

    public $timestamps = false; // Tambahkan baris ini

    protected $fillable = [
        'loadCellID',
        'slaveNumber',
        'status',
        'weight',
        'rackNumber',
        'timestamp',
    ];
}
