<?php

namespace App\Service;

use App\Repository\WorkUnitRepository;

class EvaluationService
{
    private WorkUnitRepository $workUnitRepository;

    public function __construct(WorkUnitRepository $workUnitRepository){
        $this->workUnitRepository = $workUnitRepository;
    }

    /**
     * Returns the data for the Evaluation Report, aggregated per month.
     * @return array
     */
    public function getMonthlyReport(): array {
        return $this->getEvaluationReport('Y-m');
    }

    /**
     * Returns the data for the Evaluation Report, aggregated per day.
     * @return array
     */
    public function getDailyReport(): array {
        return $this->getEvaluationReport('Y-m-d');
    }

    /**
     * Returns the evaluation report based on the periodicity defined by the date format.
     * 'Y-m-d' returns the report aggregated per day.
     * 'Y-m' returns the report aggregated per month.
     * Each period may have multiple entries, as each Project is reported separately.
     * @param string $dateFormat
     * @return array
     */
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