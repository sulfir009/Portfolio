<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Services\ServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * @property ServiceService $service
 */
class ServiceController extends BaseController
{
    public function __construct(ServiceService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.service.index', $this->service->getAll());

    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.service.add', $this->service->getOtherInfo());
    }

    /**
     * @param ServiceRequest $request
     * @return RedirectResponse
     */
    public function store(ServiceRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()->route('service.index');
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $service = $this->service->getOne($id);

        return view('dashboard.service.show', compact('service'));
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('dashboard.service.edit', $this->service->getToEdit($id), $this->service->getOtherInfo());
    }

    /**
     * @param ServiceRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(ServiceRequest $request, $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('service.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('service.index');
    }
}
