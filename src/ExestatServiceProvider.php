<?php

namespace Kbaas\Exestat;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Kbaas\Exestat\Presenters\ExestatPresenter;

class ExestatServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/exestat.php', 'exestat');
        $this->loadViewsFrom(__DIR__ . '/../views', 'exestat');
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        if (!$this->app->runningInConsole() && !request()->isMethod('OPTIONS')) {
            Exestat::init();
            $this->listenForEvents();
        }
    }

    /**
     * @return void
     */
    private function listenForEvents(): void
    {
        $eventPresenters = config('exestat.event_presenters');
        $captureEvents = config('exestat.capture_events');

        Event::listen('*', function (string $name, array $args) use ($eventPresenters, $captureEvents) {

            if (Exestat::hasEnded()) {
                return;
            }

            if ($name === RequestHandled::class) {
                Exestat::stopRecording();
                return;
            }

            if (!$captureEvents) {
                return;
            }

            $description = null;

            /** @var ExestatPresenter $presenter */
            if (($presenterClass = ($eventPresenters[$name] ?? null))) {
                $presenter = app($presenterClass);
                $description = $presenter->toDescription($args);
            }

            Exestat::record($name, $description);
        });
    }
}
