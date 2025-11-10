<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryPlace extends Model
{
    //
    public function itineraries()
{
    return $this->belongsToMany(Itinerary::class, 'itinerary_place')->withPivot('order');
}

}
