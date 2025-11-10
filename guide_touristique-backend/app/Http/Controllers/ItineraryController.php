<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Itineraire;
use App\Models\Itinerary;

class ItineraryController extends Controller
{
    public function index()
    {
        // Charger les itinéraires avec leurs lieux associés
        $itineraires = Itinerary::with('lieux')->get();

        return response()->json($itineraires);
    }
}
?>