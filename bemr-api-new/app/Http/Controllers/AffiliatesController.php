<?php

namespace App\Http\Controllers;

use App\Http\Requests\AffiliatesRequest;
use App\Models\Affiliates;
use App\Services\AffiliatesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * @property AffiliatesService $service
 */
class AffiliatesController extends BaseController
{

    public function __construct(AffiliatesService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.affiliates.index', $this->service->getAll());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.affiliates.add');
    }

    /**
     * @param AffiliatesRequest $request
     * @return RedirectResponse
     */
    public function store(AffiliatesRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('affiliates.index');
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $affiliate = $this->service->getOne($id);

        return view('dashboard.affiliates.show', compact('affiliate'));
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('dashboard.affiliates.edit', $this->service->getToEdit($id));
    }

    /**
     * @param AffiliatesRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(AffiliatesRequest $request, $id)
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('affiliates.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('affiliates.index');
    }
}
