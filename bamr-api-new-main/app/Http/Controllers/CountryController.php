<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CountryController extends BaseController
{
    private CountryService $service;

    public function __construct(CountryService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.country.index', $this->service->getCountries());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.country.add');
    }

    /**
     * @param CountryRequest $request
     * @return RedirectResponse
     */
    public function store(CountryRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()->route('country.index');
    }

    /**
     * @param Country $country
     * @return View
     */
    public function show(Country $country): View
    {
        $country = $this->service->getOne($country);

        return view('dashboard.country.show', compact('country'));
    }

    /**
     * @param Country $country
     * @return View
     */
    public function edit(Country $country): View
    {
        return view('dashboard.country.edit', $this->service->getToEdit($country));
    }

    /**
     * @param CountryRequest $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function update(CountryRequest $request, Country $country): RedirectResponse
    {
        $this->service->update($country, $request->validated());

        return redirect()->route('country.index');
    }

    /**
     * @param Country $country
     * @return RedirectResponse
     */
    public function destroy(Country $country): RedirectResponse
    {
        $this->service->delete($country);

        return redirect()->route('country.index');
    }
}
