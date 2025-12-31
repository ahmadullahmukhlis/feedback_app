<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use HasFactory, LogsActivity, CausesActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                        ->logOnlyDirty()
                        ->logOnly(['*'])
                        ->useLogName('Role')
                        ->dontSubmitEmptyLogs()
                        ->dontLogIfAttributesChangedOnly(['updated_at'])
                        ;
    }
    public function permission_ids() : HasMany{
        return $this->hasMany(RolePermission::class);
    }
    public function created_by_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_by_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function users() : HasMany
    {
        return $this->hasMany(UserRole::class);
    }
    public function assignedRoles() : HasMany
    {
        return $this->hasMany(RolePermission::class)->select('permission_id');
    }
}
