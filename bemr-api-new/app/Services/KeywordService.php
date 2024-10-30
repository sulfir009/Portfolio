<?php

namespace App\Services;

use App\Interfaces\KeywordRepositoryInterface;


/**
 * @property KeywordRepositoryInterface $keywordRepository
 */
class KeywordService
{
    public function __construct(
        KeywordRepositoryInterface $keywordRepository
    )
    {
        $this->keywordRepository = $keywordRepository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $keywords = $this->keywordRepository->getAll();
        return compact('keywords');
    }

    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        $data = [
            'keyword' => $data['keyword'],
        ];
        $this->keywordRepository->store($data);
    }

    /**
     * @param $id
     * @return array
     */
    public function getOne($id): array
    {
        return $this->keywordRepository->getOne($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function getToEdit($id): array
    {
        $keyword = $this->keywordRepository->getToEdit($id);

        return compact('keyword');
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function update($id, $data): void
    {
        $data = [
            'keyword' => $data['keyword'],
        ];
        $this->keywordRepository->update($id, $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $this->keywordRepository->delete($id);
    }
}
