<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLogs extends Model
{
    protected $fillable = ['user_id', 'action', 'table_name', 'record_id', 'old_value', 'new_value'];

    // Log by user
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
