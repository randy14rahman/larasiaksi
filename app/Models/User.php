<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Zend\Debug\Debug;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
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

    public function getInfoById(int $user_id){

        $sql = "SELECT
                u.id,
                u.nip,
                u.name,
                u.email,
                u.jabatan,
                u.role_id,
                r.level
            from
                users u
                left join roles r on u.role_id=r.id
            where
                u.id = :user_id";
        // Debug::dump($sql);die;

        $data = app('db')->connection()->select($sql,['user_id'=>$user_id]);
        // Debug::dump($data);die;

        return (object) ($data[0]??[]);
    }

    public function getUserIsPettd(){

        $data = app('db')->connection()->select("SELECT u.id, u.nip, u.name, u.email, u.jabatan, u.role_id, r.level from users u left join roles r on u.role_id=r.id where u.is_pettd=1 and r.level in (3,4,5,6)");

        return $data;
    }

    public function getPemarafByUser(int $user_id=0){

        $userInfo = $this->getInfoById($user_id);
        // Debug::dump($userInfo);die;

        $sql = "SELECT
                u.id,
                u.nip,
                u.name,
                u.email,
                u.jabatan,
                u.role_id,
                r.level
            from
                users u
            left join roles r on
                u.role_id = r.id
            where
                u.is_pettd = 1
                and r.level between 3 and :level
                and u.id <> :user_id";

        $data = app('db')->connection()->select($sql, ['level'=>$userInfo->level, 'user_id'=>$userInfo->id]);

        return $data;
    }

    public function getPemarafByLevel(int $level=0){

        $data = app('db')->connection()->select("SELECT u.id, u.nip, u.name, u.email, u.jabatan, u.role_id, r.level from users u left join roles r on u.role_id=r.id where u.is_pettd=1 and r.level between 3 and :level", ['level'=>$level]);

        return $data;
    }
    
}