<?php

namespace Kbaas\Exestat;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kbaas\Exestat\Presenters\ExestatPresenter;

class ExestatServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . './../config/exestat.php', 'exestat');
        $this->loadViewsFrom(__DIR__ . './../views', 'exestat');
        $this->loadRoutesFrom(__DIR__ . './../routes/routes.php');

        Exestat::init();

        $this->listenForEvents();
    }

    /**
     * @return void
     */
    private function listenForEvents(): void
    {
        $presenters = config('exestat.presenters');

        Event::listen('*', function(string $name, array $args) use ($presenters) {

            if (Exestat::hasEnded()) {
                return;
            }

            if ($name === RequestHandled::class) {
                Exestat::end();
                return;
            }

            $description = null;

            /** @var ExestatPresenter $presenter */
            if (($presenterClass = ($presenters[$name] ?? null))) {
                $presenter = app($presenterClass);
                $description = $presenter->toDescription($args);
            }

            Exestat::start($name, $description);
        });
    }
}
