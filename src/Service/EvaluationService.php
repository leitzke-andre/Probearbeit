<?php

namespace App\Service;

use App\Repository\WorkUnitRepository;

class EvaluationService
{
    private WorkUnitRepository $workUnitRepository;

    public function __construct(WorkUnitRepository $workUnitRepository){
        $this->workUnitRepository = $workUnitRepository;
    }

    public function getMonthlyReport(): array {
        return $this->getEvaluationReport('Y-m');
    }

    public function getDailyReport(): array {
        return $this->getEvaluationReport('Y-m-d');
    }

    private function getEvaluationReport(string $dateFormat): array {
        $workUnits = $this->workUnitRepository->findAll();
        $reportData = array();
        foreach($workUnits as $workUnit){
            $workPeriod = $workUnit->getStart()->format($dateFormat);
            $project = $workUnit->getProject()->getName();
            if (array_key_exists($workPeriod, $reportData)) {
                if(array_key_exists($project, $reportData[$workPeriod])) {
                    // Add the time to existing time
                    $reportData[$workPeriod][$project] += $workUnit->getTimeElapsedInMinutes();
                } else {
                    // Add the project and time as a new entry
                    $reportData[$workPeriod][$project] = $workUnit->getTimeElapsedInMinutes();
                }
            } else {
                $reportData[$workPeriod] = array($project => $workUnit->getTimeElapsedInMinutes());
            }
        }
        return $reportData;
    }
}