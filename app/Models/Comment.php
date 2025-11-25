<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Report;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['galery_id', 'user_id', 'parent_id', 'body', 'status', 'moderation_note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function galery()
    {
        return $this->belongsTo(Galery::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
