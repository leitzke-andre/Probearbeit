<?php

namespace App\Controller;

use App\Service\CSVReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CSVReportController extends AbstractController
{
    #[Route('/report', name: 'app_csv_report')]
    public function getCSVReport(CSVReportService $csvReportService): Response
    {
        // Fetches data from the service and renders as a CSV to be streamed
        $content = $csvReportService->getCSVReportContent();
        $response = $this->getCSVResponse();
        $response->setContent($content);
        return $response;
    }

    private function getCSVResponse() {
        $response = new Response();
        $response->headers->set('Content-Encoding', 'UTF-8');
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename=report.csv');
        return $response;
    }
}
