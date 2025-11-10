<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItineraryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permet à tout utilisateur authentifié de créer un itinéraire
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lieux' => 'required|array',
            'lieux.*.id' => 'required|exists:lieux,id',  // Vérifie que le lieu existe
            'lieux.*.ordre' => 'required|integer',       // Vérifie l'ordre des lieux
        ];
    }
}
