<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Manga extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'volume',
        'author',
        'genre',
        'publisher',
        'description',
        'stock',
        'availability',
        'cover_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($manga) {
            $originalSlug = $slug = Str::slug($manga->name);
            $count = 1;
            
            while (static::whereSlug($slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            
            $manga->slug = $slug;
        });

        static::updating(function ($manga) {
            if ($manga->isDirty('name')) {
                $originalSlug = $slug = Str::slug($manga->name);
                $count = 1;

                while (static::whereSlug($slug)->where('id', '!=', $manga->id)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }

                $manga->slug = $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}