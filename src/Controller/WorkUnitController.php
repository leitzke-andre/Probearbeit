<?php

namespace App\Controller;

use App\Entity\WorkUnit;
use App\Form\WorkUnitType;
use App\Repository\WorkUnitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/work-unit')]
class WorkUnitController extends AbstractController
{
    #[Route('/', name: 'app_work_unit_index', methods: ['GET'])]
    public function index(WorkUnitRepository $workUnitRepository): Response
    {
        return $this->render('work_unit/index.html.twig', [
            'work_units' => $workUnitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_work_unit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workUnit = new WorkUnit();
        $form = $this->createForm(WorkUnitType::class, $workUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $workUnit->isValid()) {
            $entityManager->persist($workUnit);
            $entityManager->flush();

            return $this->redirectToRoute('app_work_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('work_unit/new.html.twig', [
            'work_unit' => $workUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_work_unit_show', methods: ['GET'])]
    public function show(WorkUnit $workUnit): Response
    {
        return $this->render('work_unit/show.html.twig', [
            'work_unit' => $workUnit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_work_unit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkUnit $workUnit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkUnitType::class, $workUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_work_unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('work_unit/edit.html.twig', [
            'work_unit' => $workUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_work_unit_delete', methods: ['POST'])]
    public function delete(Request $request, WorkUnit $workUnit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workUnit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($workUnit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_work_unit_index', [], Response::HTTP_SEE_OTHER);
    }
}
