<?php

namespace App\Repositories;

use App\Interfaces\CampaignCodeRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class CampaignCodeRepository implements CampaignCodeRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll(): array
    {
        return DB::table('campaign_codes')
            ->select('id', 'campaign_code')
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        DB::table('campaign_codes')->insert($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return DB::table('campaign_codes')
            ->where('id', '=', $id)
            ->first()
            ->toArray();
    }

    /**
     * @param $id
     * @return stdClass
     */
    public function getToEdit($id): stdClass
    {
        return DB::table('campaign_codes')
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * @param $id
     * @param array $data
     * @return int
     */
    public function update($id, array $data): int
    {
        return DB::table('campaign_codes')
            ->where('id', '=', $id)
            ->update($data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        DB::table('campaign_codes')
            ->where('id', '=', $id)
            ->update(['deleted_at' => Carbon::now()]);
    }
}
