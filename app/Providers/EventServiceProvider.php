<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Database\Events\QueryExecuted' => [
            'App\Listeners\QueryListener',
        ],
        'App\Events\ViewPost' => [
            'App\Listeners\UpdatePostViewCache',
        ],
        'App\Events\VotePost' => [
            'App\Listeners\UpdatePostVoteCache',
        ],
        'App\Events\VoteComment' => [
            'App\Listeners\UpdateCommentVoteCache',
        ],
        'Overtrue\LaravelUploader\Events\FileUploaded' => [
            'App\Listeners\FileUploadedListener',
        ],
        'App\Events\UserFollow' => [
            'App\Listeners\UserFollowListener',
        ],
        'App\Events\UserCreditChanged' => [
            'App\Listeners\AddUserCreditListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
