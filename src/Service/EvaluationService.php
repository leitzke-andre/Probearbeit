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
        $workUnits = $this->workUnitRepository->findAll();
        $reportData = array();
        foreach($workUnits as $workUnit){
            $workMonth = $workUnit->getStart()->format('Y-m');
            $project = $workUnit->getProject()->getName();
            if (array_key_exists($workMonth, $reportData)) {
                if(array_key_exists($project, $reportData[$workMonth])) {
                    // Add the time to existing time
                    $reportData[$workMonth][$project] += $workUnit->getTimeElapsedInMinutes();
                } else {
                    // Add the project and time as a new entry
                    $reportData[$workMonth][$project] = $workUnit->getTimeElapsedInMinutes();
                }
            } else {
                $reportData[$workMonth] = array($project => $workUnit->getTimeElapsedInMinutes());
            }
        }
        return $reportData;
    }

    public function getDailyReport(): array {
        $workUnits = $this->workUnitRepository->findAll();
        $reportData = array();
        foreach($workUnits as $workUnit){
            $workMonth = $workUnit->getStart()->format('Y-m-d');
            $project = $workUnit->getProject()->getName();
            if (array_key_exists($workMonth, $reportData)) {
                if(array_key_exists($project, $reportData[$workMonth])) {
                    // Add the time to existing time
                    $reportData[$workMonth][$project] += $workUnit->getTimeElapsedInMinutes();
                } else {
                    // Add the project and time as a new entry
                    $reportData[$workMonth][$project] = $workUnit->getTimeElapsedInMinutes();
                }
            } else {
                $reportData[$workMonth] = array($project => $workUnit->getTimeElapsedInMinutes());
            }
        }
        return $reportData;
    }
}