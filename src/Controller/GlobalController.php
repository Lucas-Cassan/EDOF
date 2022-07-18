<?php

namespace App\Controller;

use App\Entity\InfoGlobal;
use App\Form\InfoGlobalType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlobalController extends AbstractController
{
    #[Route('/global', name: 'app-global')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $Global = new InfoGlobal();
        $form = $this->createForm(InfoGlobalType::class, $Global);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($Global);
            $em->flush();
        };

        return $this->render('global/index.html.twig', [
            'controller_name' => 'Modifier les global',
            'headerType' => 'add',
            'Form' => $form->createView(),
        ]);
    }
}
