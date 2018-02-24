<?php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{

    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address1',
        'address2',
        'city',
        'province',
        'postal_code',
        'lat',
        'lng',
        'phone',
        'website',
        'linkedin',
        'graduated_year',
        'day_rate',
        'specialist_equipment',
        'locum_specialty',
        'practice_management_system',
        'lens_product_knowledge',
        'contact_lens_specialty',
        'average_full_exam_time',
        'handover_between',
        'patient_booking_preference',
        'overview',
        'visible',
        'radius',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function practice()
    {
        return $this->hasOne('App\Practice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {

        return $this->hasMany('App\Invoice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments_options()
    {

        return $this->hasMany('App\PaymentsOptions');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {

        return $this->hasMany('App\Application');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {

        return $this->hasMany('App\Calendar');
    }

    public function feedback()
    {
        return $this->hasOne('App\Feedback');
    }
    public function jobs()
    {
        return $this->hasMany('App\Job');
    }
    public function scopeGetPassword()
    {
        return $this->attributes['password'];

    }
}
