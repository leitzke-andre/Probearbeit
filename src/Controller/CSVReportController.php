<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CSVReportController extends AbstractController
{
    #[Route('/report', name: 'app_csv_report')]
    public function getCSVReport(): Response
    {
        // Fetches data from the service and renders as a CSV to be streamed
        $response = $this->getCSVResponse();
    }

    private function getCSVResponse() {

    }
}
