<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = ['nom'];

    public function lieux()
    {
        return $this->belongsToMany(Lieu::class, 'itineraire_lieu')
                    ->withPivot('ordre')
                    ->orderBy('pivot_ordre');
    }
}

// app/Models/Lieu.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
    protected $fillable = ['nom', 'description', 'adresse', 'latitude', 'longitude', 'image', 'categorie'];

    // éventuellement la relation inverse si nécessaire
    public function itineraires()
    {
        return $this->belongsToMany(Itinerary::class, 'itineraire_lieu');
    }
}
?>