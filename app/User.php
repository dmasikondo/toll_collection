<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'names', 'email', 'password','surname','sex','slug','national_id','approved_at','approver_id','suspended_at','suspender_id','cellphone_no',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'suspended_at' => 'datetime',
    ];
    /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
       // return $this->phone_number;
        return '+263772230183';
    }    

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function approver()
    {
        return $this->belongsTo(User::class);
    }

    public function suspender()
    {
        return $this->belongsTo(User::class);
    } 
    /**
     * user is deleted
     */

    public function isDeleted()
    {
        return !is_null($this->deleted_at);
    }   

    /**
     * Assign user a role
     */

    public function assignRole($role)
    {
       // $check_if_role_exists = Role::where('name',$role)->get();
            

        return $this->roles()->save(Role::firstOrCreate(['name' =>$role]));
    } 

    /**
      * Check if the user has role of 
    */   

    public function hasRole($role)
    {
        return $this->roles->contains('name',$role);
    }


    public function dataCapturer()
    {
       return  $this->hasMany(Vehicle::class, 'registrating_officer');
    }

    /**
     *  A user has many vehicles
     */

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

}