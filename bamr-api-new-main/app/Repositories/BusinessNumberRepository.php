<?php

namespace App\Repositories;

use App\Interfaces\BusinessNumberRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class BusinessNumberRepository implements BusinessNumberRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll(): array
    {
        return DB::table('business_numbers')
            ->select('id', 'business_number')
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
        DB::table('business_numbers')->insert($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return DB::table('business_numbers')
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
        return DB::table('business_numbers')
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
        return DB::table('business_numbers')
            ->where('id', '=', $id)
            ->update($data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        DB::table('business_numbers')
            ->where('id', '=', $id)
            ->update(['deleted_at' => Carbon::now()]);
    }
}
