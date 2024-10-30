<?php

namespace App\Services;

use App\Interfaces\BusinessNumberRepositoryInterface;

class BusinessNumberService
{
    protected BusinessNumberRepositoryInterface $businessNumberRepository;

    /**
     * @param BusinessNumberRepositoryInterface $businessNumberRepository ;
     */
    public function __construct(
        BusinessNumberRepositoryInterface $businessNumberRepository
    )
    {
        $this->businessNumberRepository = $businessNumberRepository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $business_numbers = $this->businessNumberRepository->getAll();
        return compact('business_numbers');
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'business_number' => $data['business_number'],
        ];
        $this->businessNumberRepository->store($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return $this->businessNumberRepository->getOne($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function getToEdit($id): array
    {
        $business_number = $this->businessNumberRepository->getToEdit($id);
        return compact('business_number');
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function update($id, $data): void
    {
        $data = [
            'business_number' => $data['business_number'],
        ];
        $this->businessNumberRepository->update($id, $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $this->businessNumberRepository->delete($id);
    }
}
