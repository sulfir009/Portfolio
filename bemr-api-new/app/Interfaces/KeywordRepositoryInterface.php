<?php

namespace App\Interfaces;


use stdClass;

interface KeywordRepositoryInterface
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
     * @return array
     */
    public function getOne($id): array;

    /**
     * @param $id
     * @return stdClass
     */
    public function getToEdit($id): stdClass;

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
}
