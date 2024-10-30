<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ClickRequest;
use App\Http\Requests\ClickResultRequest;
use App\Http\Requests\ClickSendNumberRequest;
use App\Http\Requests\ClickSendPinRequest;
use App\Services\Api\ClickService;
use Illuminate\Http\JsonResponse;


/**
 * @property ClickService $service
 */
class ClickController extends BaseController

{

    /**
     * @param ClickService $service
     */
    public function __construct(ClickService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @param ClickRequest $request
     * @return JsonResponse
     */
    public function getRequestCode(ClickRequest $request): JsonResponse
    {
        return $this->service->getRequestCode($request->validated());
    }

    /**
     * @param ClickResultRequest $request
     * @return JsonResponse
     */
    public function getResultMessage(ClickResultRequest $request): JsonResponse
    {
        return $this->service->getResultMessage($request);
    }

    /**
     * @param ClickSendNumberRequest $request
     * @return JsonResponse
     */
    public function sendPhoneNumber(ClickSendNumberRequest $request): JsonResponse
    {
        return $this->service->sendPhoneNumber($request->validated());
    }

    /**
     * @param ClickSendPinRequest $request
     * @return JsonResponse
     */
    public function sendPin(ClickSendPinRequest $request): JsonResponse
    {
        return $this->service->sendPin($request->validated());
    }

}
