<?php

namespace App\Services;

use App\Interfaces\AffiliatesInfoRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;

/**
 * @property AffiliatesInfoRepositoryInterface $affiliatesInfoRepository
 * @property CountryRepositoryInterface $countryRepository
 */
class AffiliatesInfoService
{

    public function __construct(
        AffiliatesInfoRepositoryInterface $affiliatesInfoRepository,
        CountryRepositoryInterface        $countryRepository,
    )
    {
        $this->affiliatesInfoRepository = $affiliatesInfoRepository;
        $this->countryRepository = $countryRepository;
    }

    public function getToEdit($id): array
    {
        $info = $this->affiliatesInfoRepository->getToEdit($id);
        $countries = $this->countryRepository->getAll();
        return compact('info', 'countries');
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'id_affiliates' => $data['id_affiliates'],
            'id_country' => $data['id_country'],
            'postback_url' => $data['postback_url'],
        ];
        $this->affiliatesInfoRepository->store($data);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function update($id, $data): void
    {
        $data = [
            'id_country' => $data['id_country'],
            'postback_url' => $data['postback_url'],
        ];
        $this->affiliatesInfoRepository->update($id, $data);
    }

    public function delete($id): void
    {
        $this->affiliatesInfoRepository->delete($id);
    }

}
