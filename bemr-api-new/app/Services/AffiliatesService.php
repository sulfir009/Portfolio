<?php

namespace App\Services;

use App\Interfaces\AffiliatesInfoRepositoryInterface;
use App\Interfaces\AffiliatesRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Models\Affiliates;
use stdClass;

/**
 * @property AffiliatesRepositoryInterface $affiliatesRepository
 * @property AffiliatesInfoRepositoryInterface $affiliatesInfoRepository
 * @property CountryRepositoryInterface $countryRepository
 */
class AffiliatesService
{

    public function __construct(
        AffiliatesRepositoryInterface     $affiliatesRepository,
        AffiliatesInfoRepositoryInterface $affiliatesInfoRepository,
        CountryRepositoryInterface        $countryRepository,
    )
    {
        $this->affiliatesRepository = $affiliatesRepository;
        $this->affiliatesInfoRepository = $affiliatesInfoRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $affiliates = $this->affiliatesRepository->getAll();
        return compact('affiliates');
    }


    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'pid' => $data['pid'],
            'api_key' => $data['api_key']
        ];
        $this->affiliatesRepository->store($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return $this->affiliatesRepository->getOne($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function getToEdit($id): array
    {
        $affiliate = $this->affiliatesRepository->getToEdit($id);
        $info = $this->affiliatesInfoRepository->getAffiliateInfoById($id);
        $countries = $this->countryRepository->getAll();
        return compact('affiliate','info', 'countries');
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function update($id, $data): void
    {
        $data = [
            'pid' => $data['pid'],
            'api_key' => $data['api_key']
        ];
        $this->affiliatesRepository->update($id, $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $this->affiliatesRepository->delete($id);
    }
}
