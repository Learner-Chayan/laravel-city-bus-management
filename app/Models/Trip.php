<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    //protected $table = "trips";
    protected $guarded = [];

    public function bus()
    {
        return $this->belongsTo(Bus::class,'bus_id','id');
    }
    public function driver()
    {
        return $this->belongsTo(User::class,'driver_id','id');
    }
    public function checker()
    {
        return $this->belongsTo(User::class,'checker_id','id');
    }
    public function helper()
    {
        return $this->belongsTo(User::class,'helper_id','id');
    }
    
}
