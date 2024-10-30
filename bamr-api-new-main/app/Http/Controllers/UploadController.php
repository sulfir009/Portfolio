<?php

namespace App\Http\Controllers;

use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UploadController extends BaseController
{


    /**
     * @return View
     */
    public function index(): View
    {
        return view('upload.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $filepath = null;
        if ($request->hasFile('file')) {

            $filepath = $request->file('file')->store(
                'files',
                'public');
        }
;
        $service = new UploadService();
        $service->parseCsv($filepath);

        return redirect()->route('index');
    }

}
