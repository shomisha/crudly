<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, HasFactory;

    public $timestamps = false;

    public $casts = ['published_at' => 'datetime'];

    public function getDeletedAtColumn()
    {
        return 'archived_at';
    }
}