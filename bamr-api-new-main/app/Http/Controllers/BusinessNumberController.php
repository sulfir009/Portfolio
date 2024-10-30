<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessNumberRequest;
use App\Services\BusinessNumberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * @property BusinessNumberService $service
 */
class BusinessNumberController extends BaseController
{
    public function __construct(BusinessNumberService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.business_number.index', $this->service->getAll());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.business_number.add');
    }

    /**
     * @param BusinessNumberRequest $request
     * @return RedirectResponse
     */
    public function store(BusinessNumberRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()->route('business-number.index');
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $business_number = $this->service->getOne($id);

        return view('dashboard.business_number.show', compact('business_number'));
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('dashboard.business_number.edit', $this->service->getToEdit($id));
    }

    public function update(BusinessNumberRequest $request, $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('business-number.index');
    }

    public function destroy($id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('business-number.index');
    }
}
