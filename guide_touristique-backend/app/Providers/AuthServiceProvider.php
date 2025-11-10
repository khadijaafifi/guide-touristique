<?php

namespace App\Providers;

use App\Models\Itinerary;
use App\Policies\ItineraryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les politiques d'accès pour l'application.
     *
     * @var array
     */
    protected $policies = [
        Itinerary::class => ItineraryPolicy::class,
    ];

    /**
     * Enregistre les services d'authentification.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Enregistre les politiques pour Itinerary
        Gate::define('view-itinerary', [ItineraryPolicy::class, 'view']);
        Gate::define('update-itinerary', [ItineraryPolicy::class, 'update']);
        Gate::define('delete-itinerary', [ItineraryPolicy::class, 'delete']);
    }
}
