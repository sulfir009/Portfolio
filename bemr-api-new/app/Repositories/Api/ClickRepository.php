<?php

namespace App\Repositories\Api;

use App\Interfaces\Api\ClickRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class ClickRepository implements ClickRepositoryInterface
{

    /**
     * @param $binomClickId
     * @param $affiseClickId
     * @param $idPartnerInfo
     * @param $data
     * @param $externalId
     * @return void
     */
    public function insertClick($binomClickId, $affiseClickId, $idPartnerInfo, $data, $externalId): void
    {
        Log::channel('incomeData')->info($data);
        DB::table('clicks')
            ->insert([
                'binom_click_id' => $binomClickId,
                'affise_click_id' => $affiseClickId,
                'user_agent' => $data['user_agent'] ?? null,
                'operator' => $data['operator'] ?? null,
                'aff_click_id' => $affiseClickId,
                'aff_id' => null,
                'subid1' => $data['subid1'],
                'subid2' => $data['subid2'],
                'subid3' => $data['subid3'],
                'subid4' => $data['subid4'],
                'subid5' => $data['subid5'],
                'is_charged' => 0,
                'id_main' => $idPartnerInfo,
                'external_id' => $externalId,
            ]);
    }

    /**
     * @param $hash
     * @return Model|Builder|stdClass|null
     */
    public function getMain($hash): Model|Builder|null|stdClass
    {
        return DB::table('main')
            ->join('services', 'main.id_services', '=', 'services.id')
            ->join('countries', 'services.id_country', '=', 'countries.id')
            ->join('business_numbers', 'services.id_business_number', '=', 'business_numbers.id')
            ->join('campaign_codes', 'services.id_campaign_code', '=', 'campaign_codes.id')
            ->join('keywords', 'services.id_keyword', '=', 'keywords.id')
            ->select('main.id', 'main.campaigns_key_binom', 'main.aff_company_id', 'main.pid',
                'main.partner_id', 'main.password', 'main.id_services as service',
                'services.name', 'services.flow', 'countries.country as country_code', 'business_numbers.business_number',
                'campaign_codes.id as id_campaign_code', 'campaign_codes.campaign_code', 'campaign_codes.operator_id', 'keywords.keyword')
            ->where('hash', '=', $hash)
            ->first();
    }

    /**
     * @param $binomClickId
     * @return Model|Builder|stdClass|null
     */
    public function getPartnerClickId($binomClickId): Model|Builder|null|stdClass
    {
        return DB::table('clicks')
            ->select('aff_click_id')
            ->where('binom_click_id', '=', $binomClickId)
            ->first();
    }

    public function getPartnerInfoByClickId($binomClickId): Model|Builder|null|stdClass
    {
        return DB::table('clicks')
            ->join('main', 'clicks.id_main', '=', 'main.id')
            ->join('services', 'main.id_services', '=', 'services.id')
            ->join('countries', 'services.id_country', '=', 'countries.id')
            ->join('affiliates', 'main.pid', '=', 'affiliates.pid')
            ->join('affiliates_info', function ($join) {
                $join->on('affiliates.id', '=', 'affiliates_info.id_affiliates')
                    ->on('services.id_country', '=', 'affiliates_info.id_country');
            })
            ->select('aff_company_id', 'main.pid', 'ip_address', 'postback_url', 'external_id')
            ->where('clicks.binom_click_id', '=', $binomClickId)
            ->first();
    }

    public function setCharged($binomClickid): void
    {
        DB::table('clicks')
            ->where('binom_click_id', '=', $binomClickid)
            ->update(['is_charged' => 1, 'updated_at' => date("Y-m-d H:i:s")]);
    }

    /**
     * @param $requestId
     * @return mixed
     */
    public function getCid($requestId): mixed
    {
        return DB::table('clicks')
            ->select('cid')
            ->where('req_id', '=', $requestId)
            ->get()
            ->map(function ($item) {
                return json_decode(json_encode($item), true);
            })
            ->first();
    }
}
