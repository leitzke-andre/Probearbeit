<?php

namespace App\Controller;

use App\Service\EvaluationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/evaluation')]
class EvaluationController extends AbstractController
{
    #[Route('/index', name: 'app_evaluation')]
    public function index(): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'controller_name' => 'EvaluationController',
        ]);
    }

    #[Route('/monthly', name: 'app_evaluation_monthlyevaluation')]
    public function monthlyEvaluation(EvaluationService $evaluationService): Response
    {
        return $this->render('evaluation/monthly.html.twig', [
            'controller_name' => 'EvaluationController',
            'reportData' => $evaluationService->getMonthlyReport()
        ]);
    }

    #[Route('/daily', name: 'app_evaluation_dailyevaluation')]
    public function dailyEvaluation(EvaluationService $evaluationService): Response
    {
        return $this->render('evaluation/daily.html.twig', [
            'controller_name' => 'EvaluationController',
            'reportData' => $evaluationService->getDailyReport()
        ]);
    }
}
