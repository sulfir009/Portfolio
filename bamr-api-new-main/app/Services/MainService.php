<?php

namespace App\Services;

use App\Interfaces\MainRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;
use Carbon\Carbon;
use stdClass;

/**
 * @property ServiceRepositoryInterface $serviceRepository
 */
class MainService
{
    protected MainRepositoryInterface $mainRepository;


    /**
     * @param MainRepositoryInterface $mainRepository
     * @param ServiceRepositoryInterface $serviceRepository
     */
    public function __construct(
        MainRepositoryInterface    $mainRepository,
        ServiceRepositoryInterface $serviceRepository,
    )
    {
        $this->mainRepository = $mainRepository;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @return array
     */
    public function getMain(): array
    {
        $main = $this->mainRepository->getAll();
        return compact('main');
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'hash' => $data['hash'],
            'campaigns_key_binom' => $data['campaigns_key_binom'],
            'aff_company_id' => $data['aff_company_id'],
            'pid' => $data['pid'],
            'id_services' => $data['id_services'],
        ];
        $this->mainRepository->store($data);
    }

    /**
     * @param $main
     * @return stdClass
     */
    public function getOne($main): stdClass
    {
        return $this->mainRepository->getOne($main->id);
    }

    /**
     * @param $main
     * @param mixed $data
     * @return void
     */
    public function update($main, mixed $data): void
    {
        $data = [
            'hash' => $data['hash'],
            'campaigns_key_binom' => $data['campaigns_key_binom'],
            'aff_company_id' => $data['aff_company_id'],
            'pid' => $data['pid'],
            'id_services' => $data['id_services'],
            'updated_at' => Carbon::now(),
        ];
        $this->mainRepository->update($main->id, $data);
    }

    /**
     * @param $main
     * @return void
     */
    public function delete($main): void
    {
        $this->mainRepository->delete($main->id);
    }

    /**
     * @param $main
     * @return array
     */
    public function getToEdit($main): array
    {
        $main = $this->mainRepository->getToEdit($main->id);
        $services = $this->serviceRepository->getServices();
        return compact('main', 'services');
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        $services = $this->serviceRepository->getServices();
        return compact('services');
    }

}
