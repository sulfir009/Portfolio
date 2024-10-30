<?php

namespace App\Interfaces;

use stdClass;

interface AffiliatesInfoRepositoryInterface
{

    /**
     * @param $id
     * @return array
     */
    public function getAffiliateInfoById($id): array;

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void;

    /**
     * @param $id
     * @return stdClass
     */
    public function getToEdit($id): stdClass;

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function update($id, array $data): void;

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void;

}
