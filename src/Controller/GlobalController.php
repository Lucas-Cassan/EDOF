<?php

namespace App\Controller;

use App\Entity\InfoGlobal;
use App\Form\InfoGlobalType;
use App\Repository\InfoGlobalRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlobalController extends AbstractController
{
    #[Route('/global', name: 'app-global')]
    public function index(Request $request, ManagerRegistry $doctrine, InfoGlobalRepository $infoGlobalRepository): Response
    {
        $idGlobal = 1;
        $Global = $infoGlobalRepository->find($idGlobal);

        $form = $this->createForm(InfoGlobalType::class, $Global);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $infos = [
                'numero' => $form->get('numero')->getData(),
                'nomOrganisme' => $form->get('nomOrganisme')->getData(),
                'nom' => $form->get('nom')->getData(),
                'prenom' => $form->get('prenom')->getData(),
                'Ville' => $form->get('Ville')->getData(),
                'cp' => $form->get('cp')->getData(),
                'numeroVoie' => $form->get('numeroVoie')->getData(),
                'natureVoie' => $form->get('natureVoie')->getData(),
                'libelleVoie' => $form->get('libelleVoie')->getData(),
                'telfix' => $form->get('telfix')->getData(),
                'email' => $form->get('email')->getData(),
                'garantie' => $form->get('garantie')->getData(),
            ];

            $Global->setAccesHandicapes($form->get('accesHandicapes')->getData());
            $Global->setInfos($infos);

            $em = $doctrine->getManager();
            $em->persist($Global);
            $em->flush();
        };

        return $this->render('global/index.html.twig', [
            'controller_name' => 'Modifier les informations générales',
            'headerType' => 'add',
            'Form' => $form->createView(),
            'Infos' => $Global
        ]);
    }
}
