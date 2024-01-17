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
        $entries = $this->workUnitRepository->findAll();
        $fp = fopen('php://output', 'w', 'w');

        // Add the headers to CSV file
        fputcsv(
            $fp,
            array('Id', 'Start time', 'End time', 'Project'),
            ','
        );

        // Add each entry as a separate line
        foreach ($entries as $entry) {
            fputcsv(
                $fp,
                array(
                    $entry->getId(),
                    $entry->getStart()->format('Y-m-d H:i:s'),
                    $entry->getEnd()->format('Y-m-d H:i:s'),
                    $entry->getProject()->getName()
                ),
                ','
            );
        }

        $csvBody = stream_get_contents($fp);
        fclose($fp);

        return $csvBody;
    }

}