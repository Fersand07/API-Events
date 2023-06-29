<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'date',
        'description',
        'image',
    ];


    protected function imageUrl(): Attribute{
        return Attribute::make(
            get: fn ($value) => Storage::disk('s3')->url($this->image)
        );
    }
}
