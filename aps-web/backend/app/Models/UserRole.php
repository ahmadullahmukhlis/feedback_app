<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function role() : BelongsTo {
        return $this->belongsTo(Role::class);
    }
}
