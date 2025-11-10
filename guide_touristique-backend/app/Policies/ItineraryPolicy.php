<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Itinerary;

class ItineraryPolicy
{
    /**
     * Détermine si l'utilisateur peut voir l'itinéraire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Itinerary  $itinerary
     * @return bool
     */
    public function view(User $user, Itinerary $itinerary)
    {
        return $user->id === $itinerary->user_id;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour l'itinéraire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Itinerary  $itinerary
     * @return bool
     */
    public function update(User $user, Itinerary $itinerary)
    {
        return $user->id === $itinerary->user_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer l'itinéraire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Itinerary  $itinerary
     * @return bool
     */
    public function delete(User $user, Itinerary $itinerary)
    {
        return $user->id === $itinerary->user_id;
    }
}
