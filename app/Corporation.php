<?php

namespace App;

use App\Practice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Corporation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = true;

    protected $appends = ['practices', 'totalEarnings'];

    public function practices() {
        return $this->hasMany( 'App\Practice' );
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function scopeGetPassword()
    {
        return $this->attributes['password'];
    }
    public function getPracticesAttribute()
    {
        return $this->practices()->get();
    }
    public function getTotalEarningsAttribute() {
        $total = 0;
        $this->practices->each(function(Practice $practice) use (&$total) {
            $practice->finished_jobs->each(function(Job $job) use (&$total) {
                $total += $job->total;
            });
        });
        return $total;
    }
}
