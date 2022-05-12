<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventInvite extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "events_id"
    ];
    /**
     * Get the user that owns the EventInvite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the user that owns the EventInvite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function events(): BelongsTo
    {
        return $this->belongsTo(Events::class);
    }
}
