<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personnels extends Model
{
    use HasFactory;

    protected $table = 'personnels';
    public $timestamps = false;

    protected $fillable = [
        'personnel_id',
        'loadCellID',
        'nokartu',
        'nama',
        'pangkat',
        'nrp',
        'jabatan',
        'kesatuan',
    ];

    protected $primaryKey = 'personnel_id';
    public function weapon()
    {
        return $this->hasOne(weapons::class, 'loadCellID', 'loadCellID'); // Sesuaikan foreign key
    }

    // public function tmprfid()
    // {
    //     return $this->belongsTo(tmprfids::class, 'nokartu', 'nokartu');
    // }
}
