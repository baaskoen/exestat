<?php

namespace Kbaas\Exestat\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Kbaas\Exestat\Exestat;
use Kbaas\Exestat\ExestatCachedResult;

class ExestatController extends Controller
{
    public function index(): View
    {
        $start = microtime(true);
        $results = Exestat::getCache();

        usort($results, function (ExestatCachedResult $a, ExestatCachedResult $b) {
            return $a->dateTime->gt($b->dateTime) ? -1 : 1;
        });

        return view('exestat::index', [
            'results' => $results,
            'time' => (microtime(true) - $start) * 1000
        ]);
    }
}
