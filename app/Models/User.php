<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'mobile',
        'profile_pic',
        'status',
        'online_status'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }


    static function boot(){
        parent::boot();

        static::created(function(Model $model){
            if($model->role_id == ""){
                $model->update([
                    'role_id' => Role::where('title','user')->first()->id,
                ]);
            }
        });

    }


     public function user_list($name, $email, $mobile)
    {
        // echo $name, $email, $mobile;die;
        return User::OrderBy('name')
        ->where('role_id',2)
        ->Where(function($query) use ($name) {
            if (isset($name) && !empty($name)) {
                $query->where('name', 'LIKE', "%".$name."%");
                        //$query->Orwhere('last_name', 'LIKE', "%".$name."%");
            }
        })->Where(function($query) use ($email) {
            if (isset($email) && !empty($email)) {
                $query->where('email', 'LIKE', "%".$email."%");
            }
        })->Where(function($query) use ($mobile) {
            if (isset($mobile) && !empty($mobile)) {
                $query->where('mobile', 'LIKE', "%".$mobile."%");
            }
        })->paginate(10);
    }

    public function categories(){
      return $this->hasOne(Category::class,'id','category_id');
  }
}
