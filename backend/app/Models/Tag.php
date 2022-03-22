<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * 紐づくメモ一覧を取得する
     */
    public function memos()
    {
        return $this->belongsToMany(Memo::class);
    }
}
