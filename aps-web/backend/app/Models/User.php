<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity, CausesActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->logOnly(['*'])
            ->useLogName('Users')
            ->dontSubmitEmptyLogs()
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ;
    }

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
        'password' => 'hashed',
        'change_password' => 'boolean',
        'is_active' => 'boolean',
    ];


    public static function permissions()
    {
        if (auth()->id() == 1) {
            return [];
        }

        return Cache::remember('permission_keys_'.auth()->id(), 60*24*30, function() {
            $permissions = auth()->user()->load(['roles.role']);
            $permission_ids = $permissions->roles->pluck('role.assignedRoles')->flatten()->pluck('permission_id')->unique()->toArray();
            return Permission::whereIn('id', $permission_ids)->select('key')->get()->map(function($item) {
                return $item->key;
            });
        });
    }

    public function roles() : HasMany
    {
        return $this->hasMany(UserRole::class)->with('role');
    }

    public static function isAllowed($permission, $abort=true)
    {
        $request = request();
        if ($request->user()->id == 1){
            return true;
        }
        $result = in_array($permission, self::permissions()->toArray());
        if (!$result){
            if ($abort){
                abort(403, 'Not allowed');
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
    public function  support() : HasMany
    {
        return $this->hasMany(Support::class ,'user_id');
    }
}
