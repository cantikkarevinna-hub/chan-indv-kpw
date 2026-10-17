<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $table = 'films';

    protected $fillable = ['title', 'sinopsis', 'year', 'poster', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function kritiks()
    {
        return $this->hasMany(Kritik::class);
    }

    public function getPosterAttribute($value)
    {
        if (strpos($value, 'storage/images/') === 0) {
            return 'template/images/'.substr($value, strlen('storage/images/'));
        }

        return $value;
    }
}
