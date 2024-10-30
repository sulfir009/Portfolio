<?php

namespace App\Interfaces\Api;

interface ClickRepositoryInterface
{


    /**
     * @param $binomClickId
     * @param $affiseClickId
     * @param $idPartnerInfo
     * @param $data
     * @param $externalId
     * @return void
     */
    public function insertClick($binomClickId, $affiseClickId, $idPartnerInfo, $data, $externalId): void;

    /**
     * @param $hash
     * @return mixed
     */
    public function getMain($hash): mixed;

    /**
     * @param $binomClickId
     * @return mixed
     */
    public function getPartnerClickId($binomClickId): mixed;

    /**
     * @param $binomClickId
     * @return mixed
     */
    public function getPartnerInfoByClickId($binomClickId): mixed;

    /**
     * @param $binomClickid
     * @return void
     */
    public function setCharged($binomClickid): void;

    /**
     * @param $requestId
     * @return mixed
     */
    public function getCid($requestId): mixed;
}
