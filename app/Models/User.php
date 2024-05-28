<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'occupation',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses(){
        return $this->belongsToMany(Course::class,'course_students');
    }

    public function subcribe_transactions(){
        return $this->hasMany(SubcribeTransaction::class);
    }

    public function hasActiveSubcription(){
        $latesSubcription = $this->subcribe_transactions()
        ->where('is_paid',true)
        ->latest('updated_at')
        ->first();
        // return $this->subcribe_transactions()->where('status','active')->exists();

        if(!$latesSubcription){
            return false;
        }

        $subcriptionEndDate = Carbon::parse($latesSubcription->subcription_start_date)->addMonths(1);
        return Carbon::now()->lessThanOrEqualTo($subcriptionEndDate);
    }
}
