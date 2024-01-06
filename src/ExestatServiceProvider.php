<?php

namespace Kbaas\Exestat;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Kbaas\Exestat\Helpers\ExestatHelper;
use Kbaas\Exestat\Presenters\ExestatPresenter;

class ExestatServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/exestat.php', 'exestat');
        $this->publishes([
            __DIR__ . '/../config/exestat.php' => config_path('exestat.php'),
        ], 'exestat');
        $this->loadViewsFrom(__DIR__ . '/../views', 'exestat');
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        if (!$this->shouldRun()) {
            return;
        }

        $instance = new Exestat();

        $this->app->singleton(Exestat::class, function () use ($instance) {
            return $instance;
        });
        $this->app->singleton(ExestatHelper::class, function () use ($instance) {
            return new ExestatHelper($instance);
        });
        $this->listenForEvents($instance);
    }

    /**
     * @return bool
     */
    private function shouldRun(): bool
    {
        return !$this->app->runningInConsole() && request() && !request()->isMethod('OPTIONS');
    }

    /**
     * @param Exestat $exestat
     * @return void
     */
    private function listenForEvents(Exestat $exestat): void
    {
        $captureEvents = config('exestat.capture_events');

        Event::listen(
            '*',
            function (string $name, array $args) use ($exestat, $captureEvents) {

                if ($exestat->hasEnded()) {
                    return;
                }

                if ($name === RequestHandled::class) {
                    $exestat->stopRecording();
                    return;
                }

                if ($name === QueryExecuted::class) {
                    $exestat->addQueryFromEvent($args[0]);
                }

                if ($captureEvents) {
                    $this->handleEvents($exestat, $name, $args);
                }
            }
        );
    }

    /**
     * @param Exestat $exestat
     * @param string $name
     * @param array $args
     * @return void
     */
    protected function handleEvents(Exestat $exestat, string $name, array $args): void
    {
        $eventPresenters = config('exestat.event_presenters');
        $description = $args['description'] ?? null;

        /**
         * Try to get description from event if it exists
         */
        if ($eventObject = $args[0]) {
            if (property_exists($eventObject, 'description')) {
                $description = $eventObject->description;
            }
        }

        /** @var ExestatPresenter $presenter */
        if (($presenterClass = ($eventPresenters[$name] ?? null))) {
            $presenter = app($presenterClass);
            $description = $presenter->toDescription($args);
        }

        $exestat->record($name, $description, true);
    }
}
