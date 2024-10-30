<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignCodeRequest;
use App\Services\CampaignCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * @property CampaignCodeService $service
 */
class CampaignCodeController extends BaseController
{
    public function __construct(CampaignCodeService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.campaign_code.index', $this->service->getAll());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.campaign_code.add');
    }

    /**
     * @param CampaignCodeRequest $request
     * @return RedirectResponse
     */
    public function store(CampaignCodeRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()->route('campaign-code.index');
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $campaign_code = $this->service->getOne($id);

        return view('dashboard.campaign_code.show', compact('campaign_code'));
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('dashboard.campaign_code.edit', $this->service->getToEdit($id));
    }

    /**
     * @param CampaignCodeRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(CampaignCodeRequest $request, $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('campaign-code.index');
    }

    public function destroy($id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('campaign-code.index');
    }
}
