<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Clocking;
use App\Form\CreateClockingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clockings')]
class ClockingCollectionController extends
AbstractController
{

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/create', name: 'app_Clocking_create', methods: [
        'GET',
        'POST',
    ])]
    public function createClocking(Request $request, EntityManagerInterface $entityManager): Response 
        {
            $clocking = new Clocking();
            $form = $this->createForm(CreateClockingType::class, $clocking);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($clocking);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_clocking_list');
            }
                
            return $this->render('app/clocking/create.html.twig', [
                'form' => $form->createView(),
                
            ]);
        }
    
        #[Route('/', name: 'app_clocking_list', methods: ['GET'])]
        public function listClockings(): Response
        {
            // Add logic to list clockings if needed
            return $this->render('clocking/list.html.twig');
        }
    }
    