<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RolePermission extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
