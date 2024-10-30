<?php

namespace App\Repositories;

use App\Interfaces\ServiceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class ServiceRepository implements ServiceRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll(): array
    {
        return DB::table('services')
            ->join('countries', 'services.id_country', '=', 'countries.id')
            ->join('business_numbers', 'services.id_business_number', '=', 'business_numbers.id')
            ->join('campaign_codes', 'services.id_campaign_code', '=', 'campaign_codes.id')
            ->join('keywords', 'services.id_keyword', '=', 'keywords.id')
            ->select('services.id', 'services.name', 'countries.country', 'business_numbers.business_number',
                'campaign_codes.campaign_code', 'keywords.keyword')
            ->orderBy('services.id', 'ASC')
            ->get()
            ->toArray();
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return DB::table('services')
            ->select('id', 'name')
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        DB::table('services')->insert($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return DB::table('services')
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
        return DB::table('services')
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
        return DB::table('services')
            ->where('id', '=', $id)
            ->update($data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        DB::table('services')
            ->where('id', '=', $id)
            ->update(['deleted_at' => Carbon::now()]);
    }
}
