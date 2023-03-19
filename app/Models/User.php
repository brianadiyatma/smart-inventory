<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;
use Str;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'division_code',
        'position_code',
        'plant_code'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   /**
    * Get all of the comments for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function plant()
   {
       return $this->belongsTo(sap_m_plant::class, 'plant_code','plant_code');
   }

   public function plants()
   {
       return $this->belongsTo(sap_m_plant::class, 'plant_code','id');
   }

   /**
    * Get all of the comments for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function division()
   {
       return $this->belongsTo(m_division::class, 'division_code','division_code');
   }

   public function divisions()
   {
       return $this->belongsTo(m_division::class, 'division_code','id');
   }

   /**
    * Get all of the comments for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function position()
   {
       return $this->belongsTo(m_position::class, 'position_code','position_code');
   }

   public function positions()
   {
       return $this->belongsTo(m_position::class, 'position_code','id');
   }

   public function sendPasswordResetNotification($token){
        
        $url = url('/password/reset').'/'.$token;
        $this->notify(new ResetPasswordNotification($url));
    }

    public function notifikasi(): BelongsToMany
    {
        return $this->belongsToMany(Notifikasi::class, 'user_notifikasi', 'notifikasi_id', 'user_id');
    }

    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'expired_at' => now()->addDays(3) 
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }

}
