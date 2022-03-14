<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
    ];

    /**
     * 紐づくユーザーを取得する
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 紐づくタグ一覧を取得する
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'memo_tags');
    }
}
