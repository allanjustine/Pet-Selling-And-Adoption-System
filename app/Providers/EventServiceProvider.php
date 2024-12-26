<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */

     protected $observers = [
        \App\Models\AdditionalPayment::class => [
            \App\Observers\AdditionalPaymentObserver::class
        ],
        \App\Models\Adoption::class => [
            \App\Observers\AdoptionObserver::class
        ],
        \App\Models\Breed::class => [
            \App\Observers\BreedObserver::class
        ],
        \App\Models\Category::class => [
            \App\Observers\CategoryObserver::class
        ],
        \App\Models\Comment::class => [
            \App\Observers\CommentObserver::class
        ],
        \App\Models\Like::class => [
            \App\Observers\LikeObserver::class
        ],
        \App\Models\Message::class => [
            \App\Observers\MessageObserver::class
        ],
        \App\Models\PaymentMethod::class => [
            \App\Observers\PaymentMethodObserver::class
        ],
        \App\Models\Pet::class => [
            \App\Observers\PetObserver::class
        ],
        \App\Models\Rating::class => [
            \App\Observers\RatingObserver::class
        ],
        \App\Models\SellerAccount::class => [
            \App\Observers\SellerAccountObserver::class
        ],
    ];

    
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}