<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeywordRequest;
use App\Services\KeywordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * @property KeywordService $service
 */
class KeywordController extends BaseController
{
    public function __construct(KeywordService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.keyword.index', $this->service->getAll());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.keyword.add');
    }

    /**
     * @param KeywordRequest $request
     * @return RedirectResponse
     */
    public function store(KeywordRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()->route('keyword.index');
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $keyword = $this->service->getOne($id);

        return view('dashboard.keyword.show', compact('keyword'));
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('dashboard.keyword.edit', $this->service->getToEdit($id));
    }

    /**
     * @param KeywordRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(KeywordRequest $request, $id): RedirectResponse
    {
        $this->service->update($id, $request->validated());

        return redirect()->route('keyword.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('keyword.index');
    }
}
