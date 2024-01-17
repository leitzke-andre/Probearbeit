<?php

namespace App\Service;

use App\Repository\WorkUnitRepository;

const HEADER_ID = "Id";
const HEADER_START_TIME = "Start time";
const HEADER_END_TIME = "End time";
const HEADER_PROJECT = "Project";
const REPORT_TIME_FORMAT = "Y-m-d H:i:s";

class CSVReportService
{
    private WorkUnitRepository $workUnitRepository;


    public function __construct(WorkUnitRepository $workUnitRepository){
        $this->workUnitRepository = $workUnitRepository;
    }

    /**
     * Gets the entire Work Unit data set formatted as CSV.
     * @return string
     */
    public function getCSVReportContent(): string
    {
        $entries = $this->workUnitRepository->findAll();

        // Get a file pointer to output stream which will be exported as CSV
        $fp = fopen('php://output', 'w', 'w');

        // Add the headers to CSV file
        fputcsv(
            $fp,
            array(HEADER_ID, HEADER_START_TIME, HEADER_END_TIME, HEADER_PROJECT)
        );

        // Add each entry as a separate line
        foreach ($entries as $entry) {
            fputcsv(
                $fp,
                array(
                    $entry->getId(),
                    $entry->getStart()->format(REPORT_TIME_FORMAT),
                    $entry->getEnd()->format(REPORT_TIME_FORMAT),
                    $entry->getProject()->getName()
                )
            );
        }

        // Get the stream contents to return the CSV file
        $csvBody = stream_get_contents($fp);

        // Close the file pointer, we don't want to risk memory leaks :)
        fclose($fp);

        return $csvBody;
    }

}