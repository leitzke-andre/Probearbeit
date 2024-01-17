<?php

namespace App\Service;

use App\Repository\WorkUnitRepository;

class CSVReportService
{
    private WorkUnitRepository $workUnitRepository;

    public function __construct(WorkUnitRepository $workUnitRepository){
        $this->workUnitRepository = $workUnitRepository;
    }

    public function getCSVReportContent(): string
    {

    }

}