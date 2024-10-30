<?php

namespace App\Repositories;

use App\Interfaces\AffiliatesInfoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use stdClass;

class AffiliatesInfoRepository implements AffiliatesInfoRepositoryInterface
{

    /**
     * @param $id
     * @return array
     */
    public function getAffiliateInfoById($id): array
    {
        return DB::table('affiliates_info')
            ->join('countries', 'affiliates_info.id_country', '=', 'countries.id')
            ->select('affiliates_info.id as info_id', 'id_country', 'postback_url', 'country')
            ->where('id_affiliates', '=', $id)
            ->get()
            ->toArray();
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        DB::table('affiliates_info')->insert($data);
    }

    /**
     * @param $id
     * @return stdClass
     */
    public function getToEdit($id): stdClass
    {
        return DB::table('affiliates_info')
            ->where('id', '=', $id)
            ->first();
    }

    public function update($id, array $data): void
    {
        DB::table('affiliates_info')
            ->where('id', '=', $id)
            ->update($data);
    }

    public function delete($id): void
    {
        DB::table('affiliates_info')->delete($id);
    }
}
