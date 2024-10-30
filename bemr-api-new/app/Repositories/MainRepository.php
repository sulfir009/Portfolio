<?php

namespace App\Repositories;

use App\Interfaces\MainRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class MainRepository implements MainRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll(): array
    {
        return DB::table('main')
            ->join('services', 'main.id_services', '=', 'services.id')
            ->join('countries', 'services.id_country', '=', 'countries.id')
            ->select('main.id', 'main.hash', 'main.campaigns_key_binom', 'main.aff_company_id', 'main.pid',
                'countries.country', 'services.name as service_name')
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
        DB::table('main')->insert($data);
    }

    /**
     * @param $id
     * @return stdClass
     */
    public function getOne($id): stdClass
    {
        return DB::table('main')
            ->join('services', 'main.id_services', '=', 'services.id')
            ->join('countries', 'services.id_country', '=', 'countries.id')
            ->select('main.id', 'main.hash', 'main.campaigns_key_binom', 'main.aff_company_id', 'main.pid',
                'countries.country', 'services.name as service_name')
            ->where('main.id', '=', $id)
            ->first();
    }

    /**
     * @param $id
     * @param array $data
     * @return int
     */
    public function update($id, array $data): int
    {
        return DB::table('main')
            ->where('id', '=', $id)
            ->update($data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        DB::table('main')
            ->where('id', '=', $id)
            ->update(['deleted_at' => Carbon::now()]);
    }

    /**
     * @param $id
     * @return stdClass
     */
    public function getToEdit($id): stdClass
    {
        return DB::table('main')
            ->where('main.id', '=', $id)
            ->first();
    }
}
