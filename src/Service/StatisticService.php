<?php

namespace App\Service;

use App\Repository\ParcelRepository;

class StatisticService
{
    /** @var ParcelRepository */
    private $parcelRepository;

    public function __construct(ParcelRepository $parcelRepository)
    {
        $this->parcelRepository = $parcelRepository;
    }

    public function getParcelsCount(array $criteria): int
    {
        return $this->parcelRepository->getParcelsCount($criteria);
    }
}