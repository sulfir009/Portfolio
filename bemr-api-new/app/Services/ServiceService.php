<?php

namespace App\Services;

use App\Interfaces\BusinessNumberRepositoryInterface;
use App\Interfaces\CampaignCodeRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\KeywordRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;

class ServiceService
{
    protected ServiceRepositoryInterface $serviceRepository;
    protected CountryRepositoryInterface $countryRepository;
    protected BusinessNumberRepositoryInterface $businessNumberRepository;
    protected CampaignCodeRepositoryInterface $campaignCodeRepository;
    protected KeywordRepositoryInterface $keywordRepository;

    /**
     * @param ServiceRepositoryInterface $serviceRepository ;
     */
    public function __construct(
        ServiceRepositoryInterface        $serviceRepository,
        CountryRepositoryInterface        $countryRepository,
        BusinessNumberRepositoryInterface $businessNumberRepository,
        CampaignCodeRepositoryInterface   $campaignCodeRepository,
        KeywordRepositoryInterface        $keywordRepository
    )
    {
        $this->serviceRepository = $serviceRepository;
        $this->countryRepository = $countryRepository;
        $this->businessNumberRepository = $businessNumberRepository;
        $this->campaignCodeRepository = $campaignCodeRepository;
        $this->keywordRepository = $keywordRepository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $services = $this->serviceRepository->getAll();
        return compact('services');
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'name' => $data['name'],
            'id_country' => $data['id_country'],
            'id_business_number' => $data['id_business_number'],
            'id_campaign_code' => $data['id_campaign_code'],
            'id_keyword' => $data['id_keyword']
        ];
        $this->serviceRepository->store($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return $this->serviceRepository->getOne($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function getToEdit($id): array
    {
        $service = $this->serviceRepository->getToEdit($id);
        return compact('service');
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function update($id, $data): void
    {
        $data = [
            'name' => $data['name'],
            'id_country' => $data['id_country'],
            'id_business_number' => $data['id_business_number'],
            'id_campaign_code' => $data['id_campaign_code'],
            'id_keyword' => $data['id_keyword']
        ];
        $this->serviceRepository->update($id, $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $this->serviceRepository->delete($id);
    }

    /**
     * @return array
     */
    public function getOtherInfo(): array
    {
        $countries = $this->countryRepository->getAll();
        $business_numbers = $this->businessNumberRepository->getAll();
        $campaign_codes = $this->campaignCodeRepository->getAll();
        $keywords = $this->keywordRepository->getAll();
        return compact('countries', 'business_numbers', 'campaign_codes', 'keywords');
    }
}
