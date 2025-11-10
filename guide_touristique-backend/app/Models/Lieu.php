<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Lieu extends Model
{
    //
    protected $table="lieux";
    protected $fillable = [ 'nom',
    'description',
    'categorie',
    'adresse',
    'image',
    'latitude',
    'longitude'
    ];
    public function itineraries()
{
    return $this->belongsToMany(Itinerary::class, 'itinerary_lieu')
                ->withPivot('ordre')
                ->withTimestamps();
}
public function getImageUrlAttribute()
{
    return $this->image 
        ? asset(Storage::url($this->image)) 
        : null;
}
}
