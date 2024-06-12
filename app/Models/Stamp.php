<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;

    // $fillable プロパティによる一括代入を許可するフィールドの指定
    protected $fillable = [
        'user_id', 'image',
    ];

    // $dates プロパティによる日付フィールドの指定
    protected $dates = ['created_at', 'updated_at', 'other_date_field'];

    // user() 関数による関連定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
