<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'groupname', 'creator_user', 'ai_flg', 'ai_userid',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user');
    }

    public function aiUser()
    {
        return $this->belongsTo(User::class, 'ai_userid');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }
}
