<?php

namespace Kbaas\Exestat\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Kbaas\Exestat\Enums\ExestatSort;
use Kbaas\Exestat\Exestat;
use Kbaas\Exestat\ExestatCachedResult;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ExestatController extends Controller
{
    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $sort = request()->has('sort') ? ExestatSort::from(request()->get('sort')) : ExestatSort::LATEST;
        $results = Exestat::getCache($sort);

        return view('exestat::pages.index', [
            'results' => $results,
            'currentSort' => $sort
        ]);
    }

    /**
     * @param string $uuid
     * @return View
     */
    public function detail(string $uuid): View
    {
        $result = null;

        /** @var ExestatCachedResult $cache */
        foreach (Exestat::getCache() as $cache) {
            if ($cache->getUuid() === $uuid) {
                $result = $cache;
                break;
            }
        }

        if (!$result) {
            abort(404);
        }

        return view('exestat::pages.detail', [
            'result' => $result
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function clear(): RedirectResponse
    {
        Exestat::clearCache();

        return redirect()->route('exestat.index');
    }
}
