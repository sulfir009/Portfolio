<?php

namespace App\Services\Api;

use App\Interfaces\Api\ClickRepositoryInterface;
use App\Library\BinomClickApi;
use App\Traits\CurlTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClickService
{
    use CurlTrait;

    protected ClickRepositoryInterface $clickRepository;

    /**
     * @param ClickRepositoryInterface $clickRepository
     */
    public function __construct(
        ClickRepositoryInterface $clickRepository,
    )
    {
        $this->clickRepository = $clickRepository;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function getRequestCode($data): JsonResponse
    {
        Log::channel('incomeData')->info($data);
        $partnersInfo = $this->getPartnerInfoData($data['hash']);
        $binomCompanyKey = $partnersInfo['campaigns_key_binom'];
        $idPartnerInfo = $partnersInfo['id'];
        $getClick = new BinomClickApi($binomCompanyKey);
        $binomClickId = $getClick->DataClick['clickid'] ?? 'empty';
        $affiseClickId = $data['clickid'] ?? ''; 
        $params = [
            'clickid' => $binomClickId,
            'external_id' => Str::uuid()->toString()
        ];

        Log::channel('sendDataToPartner')->info($params);
        if ($binomClickId) {
            $this->clickRepository->insertClick($binomClickId, $affiseClickId, $idPartnerInfo, $data, $params['external_id']);
            return response()->json(
                [
                    'status' => 200,
                    'statusText' => 'OK',
                    'serviceInfo' => [
                        'clickid' => $binomClickId,
                        'external_id' => $params['external_id'] ?? null,
                    ]
                ]);

        } else {

            return response()->json(['status' => 400, 'statusText' => 'wrongData']);
        }

    }

    /**
     * @param $hash
     * @return array|null
     */
    public function getPartnerInfoData($hash): ?array
    {
        $partner = $this->clickRepository->getMain($hash);

        return $partner ? (array)$partner : null;
    }

    /**
     * @param $data
     * @param $url
     * @param $partner
     * @param $pass
     * @return mixed
     */
    public function sendDataToPartner($data, $url , $partner, $pass): mixed
    {
        $token = base64_encode($partner . ':' . $pass);
        $test = [
            'partner_id' => $partner,
            'password' => $pass,
            'token' => $token,
        ];
        Log::channel('test')->info($test);
        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . $token,
                'Content-Type: application/json']
        ];
        $response = json_decode($this->curl($url, $options), true);

        Log::channel('partnerResponse')->info($response);

        return $response;
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function getResultMessage($request): JsonResponse
    {
        $data = $request->all();
        Log::channel('postBackIncomeData')->info($data);
            $binomClickId = $data['clickid'];
            $sum = $data['payout'] ?? 0;
            $partnersInfo = $this->getPartnerInfoByClickId($binomClickId);
            if (isset($partnersInfo)) {
                $pid = $partnersInfo['pid'] ?? 0;
                $url = $partnersInfo['postback_url'];
                $affiliateClickId = $this->getPartnerClickId($binomClickId);
                $affiliateClickId = $affiliateClickId['aff_click_id'];
                $this->binomPostBack($binomClickId, $sum);
                $this->updateClickIdInfo($binomClickId);
                $this->sendPostBackToPartner($pid, $affiliateClickId, $sum, $url);

                return response()->json(['status' => 200, 'statusText' => "OK"]);
            } else {
                return response()->json(['status' => 400, 'statusText' => "wrongData"]);
            }

    }

    /**
     * @param $binomClickId
     * @return array|null
     */
    public function getPartnerClickId($binomClickId): ?array
    {
        $id = $this->clickRepository->getPartnerClickId($binomClickId);

        return $id ? (array)$id : null;
    }

    /**
     * @param $binomClickId
     * @return array|null
     */
    public function getPartnerInfoByClickId($binomClickId): ?array
    {
        $info = $this->clickRepository->getPartnerInfoByClickId($binomClickId);

        return $info ? (array)$info : null;
    }

    /**
     * @param $binomClickid
     * @return void
     */
    public function updateClickIdInfo($binomClickid): void
    {
        $this->clickRepository->setCharged($binomClickid);
    }

    /**
     * @param $clickid
     * @param $payout
     * @return void
     */
    public function binomPostBack($clickid, $payout): void
    {
        $options = [
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ];
        $url = config('app.postback_binom_url');
        $this->curl($url . $clickid . '&' . 'payout=' . $payout, $options);
    }

    /**
     * @param $pid
     * @param $affiliateClickId
     * @param $sum
     * @param $url
     * @return void
     */
    public function sendPostBackToPartner($pid, $affiliateClickId, $sum, $url): void
    {
        $url = str_ireplace("{subid}", $affiliateClickId, $url);
        $url = str_ireplace("{payout}", $sum, $url);
        Log::channel('postBackToPartner')->info($pid . "  " . $url);

        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => false,
        ];
        $this->curl($url, $options);

    }

    /**
     * @param $data
     * @return void
     */
    public function sendDataToAffise($data): void
    {
        $options = [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(config('app.affise_api_key')),
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HEADER => false,
        ];
        $url = config('app.affise_url');
        $html = json_decode($this->curl($url, $options), true);

        Log::channel('affiseData')->info($html);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function sendPhoneNumber($data): JsonResponse
    {
        Log::channel('incomeData')->info($data);
        $partnersInfo = $this->getPartnerInfoData($data['hash']);
        $partnersInfoUrl = $this->getPartnerInfoByClickId($data['clickid']);
        $partner = $partnersInfo['partner_id'];
        $pass = $partnersInfo['password'];
        $sendData = [
            'partner_id' => $partner,
            'msisdn' => $data['msisdn'],
            'session_id' => $data['clickid'],
            'operator_id' => $partnersInfo['operator_id'],
            'additional_data' => [
                'clickid' => $data['clickid'],
                'bfd' =>[
                    'opt_id' => $partnersInfoUrl['external_id']
                ]
            ]
        ];
        $url = config('app.partner_postback_url');
        Log::channel('sendDataToPartner')->info($sendData);
        $response = $this->sendDataToPartner($sendData, $url, $partner, $pass);
        if (!$response['status']) {
            return response()->json(
                [
                    'status' => 200,
                    'statusText' => $response['description']
                ]
            );
        } else {

            return response()->json(['status' => 400, 'statusText' => $response['description']]);
        }
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function sendPin($data): JsonResponse
    {
        Log::channel('incomeData')->info($data);
        $partnersInfo = $this->getPartnerInfoData($data['hash']);
        $partnersInfoUrl = $this->getPartnerInfoByClickId($data['clickid']);
        $url = $partnersInfoUrl['postback_url'];
        $parts = parse_url($url);
        $query = $parts['query'];
        parse_str($query, $params);
        $sum = $params['sum'];
        $partner = $partnersInfo['partner_id'];
        $pass = $partnersInfo['password'];
        $sendData = [
            'partner_id' => $partnersInfo['partner_id'],
            'otp' => $data['pin'],
            'msisdn' => $data['msisdn'],
            'session_id' => $data['clickid'],
            'callback_url' => 'https://bemr.maininvoke.space/api/get-confirm-message?clickid=' . $data['clickid'] . '&payout=' . $sum
        ];
        Log::channel('sendDataToPartner')->info($sendData);
            $url = config('app.partner_is_subscribed_url');
            //$redirectUrl = config('app.partner_redirect_url');

        $response = $this->sendDataToPartner($sendData, $url, $partner, $pass);

        if ($response['status'] == 4) {
            return response()->json([
                'status' => 200,
                'statusText' => $response['description'],
                //'redirect_url' => $redirectUrl . $data['clickid']
            ]);
        } else {
            return response()->json(['status' => 400, 'statusText' => $response['description']]);
        }

    }

    public function getAffiseClickId($pid, $offerId, $data): string
    {
        $url = "https://pk.tendr.space/click?pid=" . $pid . "&" . "offer_id=" . $offerId;
        $url = $url . "&sub1=" . $data['subid1'] . "&sub2=" . $data['subid2'] . "&sub3=" . $data['subid3'] . "&sub4=" . $data['subid4'] . "&sub5=" . $data['subid5'] . "&format=json";
        $options = [
            CURLOPT_HTTPHEADER => [
                'Accept-Language: en',
                'User-Agent:' . $data['user_agent'],
                'X-Forwarded-For:' . $data['user_ip'],
            ],
        ];
        $response = json_decode($this->curl($url, $options), true);
        return $response['clickid'];
    }

}
