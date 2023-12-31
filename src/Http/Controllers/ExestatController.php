<?php

namespace Kbaas\Exestat\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kbaas\Exestat\Enums\ExestatSort;
use Kbaas\Exestat\Exestat;
use Kbaas\Exestat\ExestatCachedResult;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ExestatController extends Controller
{
    /**
     * @var Exestat
     */
    private Exestat $exestat;

    /**
     * @param Exestat $exestat
     */
    public function __construct(Exestat $exestat)
    {
        $this->exestat = $exestat;
    }

    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $sort = request()->has('sort') ? ExestatSort::from(request()->get('sort')) : ExestatSort::LATEST;
        $results = $this->exestat->getCache($sort);

        return view('exestat::pages.index', [
            'results' => $results,
            'currentSort' => $sort
        ]);
    }

    /**
     * @param Request $request
     * @param string $uuid
     * @return View
     */
    public function detail(Request $request, string $uuid): View
    {
        $result = null;

        /** @var ExestatCachedResult $cache */
        foreach ($this->exestat->getCache(ExestatSort::LATEST) as $cache) {
            if ($cache->getUuid() === $uuid) {
                $result = $cache;
                break;
            }
        }

        if (!$result) {
            abort(404);
        }

        return view('exestat::pages.detail', [
            'result' => $result,
            'omitThreshold' => abs(floatval($request->query('omit_threshold', 0)))
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function clear(): RedirectResponse
    {
        $this->exestat->clearCache();

        return redirect()->route('exestat.index');
    }
}
