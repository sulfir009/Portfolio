<?php

namespace App\Repositories;

use App\Interfaces\KeywordRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class KeywordRepository implements KeywordRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll(): array
    {
        return DB::table('keywords')
            ->select('id', 'keyword')
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
        DB::table('keywords')->insert($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return DB::table('keywords')
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
        return DB::table('keywords')
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
        return DB::table('keywords')
            ->where('id', '=', $id)
            ->update($data);
    }

    public function delete($id): void
    {
        DB::table('keywords')
            ->where('id', '=', $id)
            ->update(['deleted_at' => Carbon::now()]);
    }
}
