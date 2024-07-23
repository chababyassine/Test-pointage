<?php

namespace App\Controller;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Form\ClockingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/clocking')]
class ClockingController extends AbstractController
{
    #[Route('/', name: 'clocking_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $clockings = $em->getRepository(Clocking::class)->findAll();

        return $this->render('clocking/index.html.twig', [
            'clockings' => $clockings,
        ]);
    }

    #[Route('/new', name: 'clocking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $clocking = new Clocking();
        $form = $this->createForm(ClockingType::class, $clocking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Automatically persist related ClockingProjects
            foreach ($clocking->getClockingsProjects() as $clockingProject) {
                $clockingProject->setClocking($clocking);
                $em->persist($clockingProject);
            }
            $em->persist($clocking);
            $em->flush();

            return $this->redirectToRoute('clocking_index');
        }

        return $this->render('clocking/new.html.twig', [
            'clocking' => $clocking,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'clocking_show', methods: ['GET'])]
    public function show(Clocking $clocking): Response
    {
        return $this->render('clocking/show.html.twig', [
            'clocking' => $clocking,
        ]);
    }

    #[Route('/{id}/delete', name: 'clocking_delete', methods: ['POST'])]
    public function delete(Request $request, Clocking $clocking, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clocking->getId(), $request->request->get('_token'))) {
            $em->remove($clocking);
            $em->flush();
        }

        return $this->redirectToRoute('clocking_index');
    }
}
