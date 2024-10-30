<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainRequest;
use App\Models\Main;
use App\Services\MainService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * @property MainService $service
 */
class MainController extends BaseController
{

    public function __construct(MainService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.main.index', $this->service->getMain());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.main.add', $this->service->getServices());
    }

    /**
     * @param MainRequest $request
     * @return RedirectResponse
     */
    public function store(MainRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()->route('main.index');
    }

    /**
     * @param Main $main
     * @return View
     */
    public function show(Main $main): View
    {
        $main = $this->service->getOne($main);

        return view('dashboard.main.show', compact('main'));
    }

    /**
     * @param Main $main
     * @return View
     */
    public function edit(Main $main): View
    {
        return view('dashboard.main.edit', $this->service->getToEdit($main));
    }

    /**
     * @param MainRequest $request
     * @param Main $main
     * @return RedirectResponse
     */
    public function update(MainRequest $request, Main $main): RedirectResponse
    {
        $this->service->update($main, $request->validated());

        return redirect()->route('main.index');
    }

    /**
     * @param Main $main
     * @return RedirectResponse
     */
    public function destroy(Main $main): RedirectResponse
    {
        $this->service->delete($main);

        return redirect()->route('main.index');
    }
}
