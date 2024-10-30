<?php

namespace App\Services;

use App\Interfaces\CampaignCodeRepositoryInterface;


class CampaignCodeService
{
    protected CampaignCodeRepositoryInterface $campaignCodeRepository;

    /**
     * @param CampaignCodeRepositoryInterface $campaignCodeRepository
     */
    public function __construct(
        CampaignCodeRepositoryInterface $campaignCodeRepository
    )
    {
        $this->campaignCodeRepository = $campaignCodeRepository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $campaign_codes = $this->campaignCodeRepository->getAll();
        return compact('campaign_codes');
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'campaign_code' => $data['campaign_code'],
        ];
        $this->campaignCodeRepository->store($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return $this->campaignCodeRepository->getOne($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function getToEdit($id): array
    {
        $campaign_code = $this->campaignCodeRepository->getToEdit($id);
        return compact('campaign_code');
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function update($id, $data): void
    {
        $data = [
            'campaign_code' => $data['campaign_code'],
        ];
        $this->campaignCodeRepository->update($id, $data);

    }

    public function delete($id): void
    {
        $this->campaignCodeRepository->delete($id);
    }
}
