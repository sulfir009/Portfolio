<?php

namespace App\Interfaces;


use stdClass;

interface MainRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void;

    /**
     * @param $id
     * @return stdClass
     */
    public function getOne($id): stdClass;

    /**
     * @param $id
     * @param array $data
     * @return int
     */
    public function update($id, array $data): int;

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void;

    /**
     * @param $id
     * @return stdClass
     */
    public function getToEdit($id): stdClass;
}
