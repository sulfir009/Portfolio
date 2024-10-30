<?php

namespace App\Http\Controllers;

use App\Http\Requests\AffiliatesInfoRequest;
use App\Services\AffiliatesInfoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * @property AffiliatesInfoService $service
 */
class AffiliatesInfoController extends BaseController
{
    public function __construct(AffiliatesInfoService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @param AffiliatesInfoRequest $request
     * @return RedirectResponse
     */
    public function store(AffiliatesInfoRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->back();
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('dashboard.affiliates-info.edit', $this->service->getToEdit($id));
    }

    /**
     * @param AffiliatesInfoRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(AffiliatesInfoRequest $request, $id)
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

        return redirect()->back();
    }

}
