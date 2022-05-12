<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
        "user_id"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $visible = [
        "id",
        "name",
        "description",
        "user"
    ];
}
