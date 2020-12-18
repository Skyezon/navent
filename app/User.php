<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role'
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
    ];

    public function vendorId(){
        $vendor = DB::table('vendors')->where('user_id',$this->id)->first();
        if($vendor == null){
            return null;
        }else{
            return $vendor->id;
        }
    }

    public function memberId(){
        $member = DB::table('event_members')->where('user_id',$this->id)->first();
        if($member != null){
            return $member->id;
        }else{
            return null;
        }
    }

    public function organizerId(){
        $organizer = DB::table('organizers')->where('user_id',$this->id)->first();
        if($organizer == null){
            return null;
        }else{
            return $organizer->id;
        }
    }

    public function getAllRole(){
        $vendorId = $this->vendorId();
        $memberId = $this->memberId();
        $organizerId = $this->organizerId();
        return [
            'vendorId' => $vendorId,
            'memberId' => $memberId,
            'organizerId' => $organizerId
        ];
    }
}
