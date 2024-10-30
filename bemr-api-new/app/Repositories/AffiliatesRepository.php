<?php

namespace App\Repositories;

use App\Interfaces\AffiliatesRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class AffiliatesRepository implements AffiliatesRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll(): array
    {
        return DB::table('affiliates')
            ->select('id', 'pid', 'api_key')
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
        DB::table('affiliates')->insert($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return DB::table('affiliates')
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
        return DB::table('affiliates')
            ->where('id', '=', $id)
            ->first();
    }

    public function update($id, array $data): int
    {
        return DB::table('affiliates')
            ->where('id', '=', $id)
            ->update($data);
    }

    public function delete($id): void
    {
        DB::table('affiliates')
            ->where('id', '=', $id)
            ->update(['deleted_at' => Carbon::now()]);
    }
}
