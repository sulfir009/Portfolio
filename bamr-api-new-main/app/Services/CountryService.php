<?php

namespace App\Services;

use App\Interfaces\CountryRepositoryInterface;


class CountryService
{
    protected CountryRepositoryInterface $countryRepository;

    public function __construct(
        CountryRepositoryInterface $countryRepository
    )
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return array
     */
    public function getCountries(): array
    {
        $countries = $this->countryRepository->getAll();
        return compact('countries');
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'country' => $data['country'],
            'ip_address' => $data['ip_address'],
        ];
        $this->countryRepository->store($data);
    }

    /**
     * @param $country
     * @return array
     */
    public function getOne($country): array
    {
        return $this->countryRepository->getOne($country->id);

    }

    /**
     * @param $country
     * @return array
     */
    public function getToEdit($country): array
    {
        $country = $this->countryRepository->getToEdit($country->id);
        return compact('country');
    }

    /**
     * @param $country
     * @param mixed $data
     * @return void
     */
    public function update($country, mixed $data): void
    {
        $data = [
            'country' => $data['country'],
            'ip_address' => $data['ip_address'],
        ];
        $this->countryRepository->update($country->id, $data);

    }

    /**
     * @param $country
     * @return void
     */
    public function delete($country): void
    {
        $this->countryRepository->delete($country->id);

    }
}
