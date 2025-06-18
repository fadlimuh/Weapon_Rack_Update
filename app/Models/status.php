<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status extends Model
{
    use HasFactory;

    protected $table = 'status';
    public $timestamps = false; // jika tidak menggunakan timestamps
    protected $primaryKey = 'loadCellID';

    protected $fillable = [
        'loadCellID',
        'tanggal',
        'time_in',
        'time_out',
        'duration',
    ];

    public function personnel()
    {
        return $this->belongsTo(personnels::class, 'loadCellID', 'loadCellID');
    }

    // Accessors for formatting attributes
    public function getTanggalAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    public function getTimeInAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('H:i:s');
    }

    public function getTimeOutAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('H:i:s') : null;
    }
}
