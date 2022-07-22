<?php

namespace App\Controller;

use App\Entity\Action;
use App\Form\ActionType;
use App\Form\FormationType;
use App\Entity\Formation;
use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\ActionRepository;
use App\Repository\FormationRepository;
use App\Repository\SessionRepository;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FormationController extends AbstractController
{
    /**
     * @Route("/", name="list-formation")
     */
    public function index(FormationRepository $formationRepository): Response
    {
        $Formations = $formationRepository->findAll();

        return $this->render('formation/listFormation.html.twig', [
            'controller_name' => 'Liste des formations',
            'headerType' => 'listFormation',
            'Formations' => $Formations

        ]);
    }

    /**
     * @Route("/nouvelle-formation", name="new-formation")
     */
    public function newFormation(Request $request, ManagerRegistry $doctrine): Response
    {
        $Formation = new Formation();
        $form = $this->createForm(FormationType::class, $Formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $date = new \DateTime('', new DateTimeZone('Europe/Paris'));

            $Formation->setNumero($form->get('numero')->getData());
            $Formation->setDatecrea($date);
            $Formation->setDatemaj($date);
            $Formation->setIntituleFormation($form->get('intituleFormation')->getData());
            $Formation->setObjectifFormation($form->get('objectifFormation')->getData());
            $Formation->setResultatsAttendus($form->get('resultatsAttendus')->getData());
            $Formation->setContenuFormation($form->get('contenuFormation')->getData());
            $Formation->setParcoursDeFormation($form->get('parcoursDeFormation')->getData());
            $Formation->setObjectifGeneralFormation($form->get('objectifGeneralFormation')->getData());

            ///////////////////////////////////////////////////////////////
            //À CHANGER AVANT LE 8 SEPTEMBRE PAR LES CODES :
            //RNCP (INCONNU), 
            //RS (INCONNU),
            //CPF(Accompagnement à la création-reprise d'entreprise	= CPF203, Bilan de compétences = CPF202).
            $Formation->setCertifInfo($form->get('certifInfo')->getData());
            ///////////////////////////////////////////////////////////////

            $Formation->setExtraResumeContenu($form->get('extraResumeContenu')->getData());

            $em->persist($Formation);
            $em->flush();

            $id_newFormation = $Formation->getId();
            return $this->redirectToRoute(
                'new-action',
                array('idFormation' => $id_newFormation)
            );
        };

        return $this->render('formation/newFormation.html.twig', [
            'controller_name' => 'Ajouter une formation',
            'headerType' => 'add',
            'Form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supp-formation/{idFormation}", name="del-formation")
     */
    public function delFormation(FormationRepository $formationRepository, Request $request, ManagerRegistry $doctrine, $idFormation): Response
    {
        $formationSelect = $formationRepository->find($idFormation);

        $em = $doctrine->getManager();
        $em->remove($formationSelect);
        $em->flush();

        return $this->redirectToRoute(
            'list-formation',
        );
    }

    /**
     * @Route("/formation/{idFormation}", name="view-formation")
     */
    public function viewFormation(FormationRepository $formationRepository, $idFormation, Request $request, ManagerRegistry $doctrine): Response
    {
        $Formation = $formationRepository->find($idFormation);
        $idFormation = $Formation->getId();
        $name = $Formation->getNumero();

        $form = $this->createForm(FormationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime('', new DateTimeZone('Europe/Paris'));

            $Formation->setNumero($form->get('numero')->getData());
            $Formation->setDatemaj($date);
            $Formation->setIntituleFormation($form->get('intituleFormation')->getData());
            $Formation->setObjectifFormation($form->get('objectifFormation')->getData());
            $Formation->setResultatsAttendus($form->get('resultatsAttendus')->getData());
            $Formation->setContenuFormation($form->get('contenuFormation')->getData());
            $Formation->setParcoursDeFormation($form->get('parcoursDeFormation')->getData());
            $Formation->setObjectifGeneralFormation($form->get('objectifGeneralFormation')->getData());

            ///////////////////////////////////////////////////////////////
            //À CHANGER AVANT LE 8 SEPTEMBRE PAR LES CODES :
            //RNCP (INCONNU), 
            //RS (INCONNU),
            //CPF(Accompagnement à la création-reprise d'entreprise	= CPF203, Bilan de compétences = CPF202).
            $Formation->setCertifInfo($form->get('certifInfo')->getData());
            ///////////////////////////////////////////////////////////////

            $Formation->setExtraResumeContenu($form->get('extraResumeContenu')->getData());

            $em = $doctrine->getManager();
            $em->persist($Formation);
            $em->flush();
            $this->addFlash('message', 'Formation mise à jour');
        };

        return $this->render('formation/viewFormation.html.twig', [
            'controller_name' => 'Formation : ' . $Formation->getIntituleFormation(),
            'headerType' => 'formation',
            'Form' => $form->createView(),
            'Name' => $name,
            'Formation' => $Formation,
            'idFormation' => $idFormation
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////
    /////////////           GESTION DES ACTIONS DE FORMATION        /////////////
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/nouvelle-action/{idFormation}", name="new-action")
     */
    public function newAction(Request $request, ManagerRegistry $doctrine, $idFormation, FormationRepository $formationRepository): Response
    {
        $Action = new Action();
        $form = $this->createForm(ActionType::class, $Action);
        $FormationSelect = $formationRepository->find($idFormation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $date = new \DateTime('', new DateTimeZone('Europe/Paris'));

            $Action->setNumero($form->get('numero')->getData());
            $Action->setDatecrea($date);
            $Action->setDatemaj($date);
            $Action->setNiveauEntreeObligatoire($form->get('niveauEntreeObligatoire')->getData());
            $Action->setModalitesEnseignement($form->get('modalitesEnseignement')->getData());
            $Action->setConditionsSpecifiques($form->get('conditionsSpecifiques')->getData());
            $Action->setModalitesEntreesSorties($form->get('modalitesEntreesSorties')->getData());
            $Action->setUrlWeb($form->get('urlWeb')->getData());
            $Action->setRestauration($form->get('restauration')->getData());
            $Action->setHebergement($form->get('hebergement')->getData());
            $Action->setTransport($form->get('transport')->getData());
            $Action->setLangueFormation($form->get('langueFormation')->getData());
            $Action->setModalitesRecrutement($form->get('modalitesRecrutement')->getData());
            $Action->setModalitesPedagogiques($form->get('modalitesPedagogiques')->getData());
            $Action->setCodePerimetreRecrutement($form->get('codePerimetreRecrutement')->getData());
            $Action->setNombreHeuresCentre($form->get('nombreHeuresCentre')->getData());
            $Action->setNombreHeuresEntreprise($form->get('nombreHeuresEntreprise')->getData());

            $Action->setFormation($FormationSelect);

            $Extras = [
                'modalitesHandicap' => $form->get('modalitesHandicap')->getData(),
                'infoAdmission' => $form->get('infoAdmission')->getData(),
                'codeModalitesAdmission' => $form->get('codeModalitesAdmission')->getData(),
                'codeGfe' => $form->get('codeGfe')->getData(),
                'codeTypeHoraire' => $form->get('codeTypeHoraire')->getData(),
                'codeRythmeFormation' => $form->get('codeRythmeFormation')->getData(),
                'fraisAnpec' => $form->get('fraisAnpec')->getData(),
                'fraisCertifInclusFraisAnpec' => $form->get('fraisCertifInclusFraisAnpec')->getData(),
                'detailFraisAnpec' => $form->get('detailFraisAnpec')->getData(),
                'codeModeleEconomique' => $form->get('codeModeleEconomique')->getData(),
                'autresServices' => $form->get('autresServices')->getData(),
                'tauxTva' => $form->get('tauxTva')->getData(),
                'fraisHt' => $form->get('fraisHt')->getData(),
                'fraisTtc' => $form->get('fraisTtc')->getData(),
                'existencePrerequis' => $form->get('existencePrerequis')->getData(),
            ];
            $Action->setExtras($Extras);
            $em->persist($Action);
            $em->flush();

            $id_newAction = $Action->getId();
            return $this->redirectToRoute(
                'new-session',
                array('idAction' => $id_newAction)
            );
        };
        return $this->render('formation/newAction.html.twig', [
            'controller_name' => 'Ajouter une action',
            'headerType' => 'add',
            'Form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list-action/{idFormation}", name="list-action")
     */
    public function listAction(ActionRepository $ActionRepository, $idFormation, FormationRepository $formationRepository): Response
    {
        $Actions = $ActionRepository->findBy(
            ['formation' => $idFormation],
        );
        $Formation = $formationRepository->find($idFormation);

        return $this->render('formation/listAction.html.twig', [
            'controller_name' => 'Actions de la formation : ' . $Formation->getIntituleFormation(),
            'headerType' => 'listAction',
            'Actions' => $Actions,
            'idFormation' => $idFormation,
            'nameFormation' => $Formation->getIntituleFormation()
        ]);
    }

    /**
     * @Route("/supp-action/{idAction}", name="del-action")
     */
    public function delAction(ActionRepository $ActionRepository, ManagerRegistry $doctrine, $idAction): Response
    {
        $actionSelect = $ActionRepository->find($idAction);
        $formationSelect = $actionSelect->getFormation()->getId();

        $em = $doctrine->getManager();
        $em->remove($actionSelect);
        $em->flush();

        return $this->redirectToRoute(
            'list-action/' . $formationSelect,
        );
    }

    /**
     * @Route("/action/{idAction}", name="view-action")
     */
    public function viewAction(Request $request, ManagerRegistry $doctrine, $idAction, ActionRepository $ActionRepository): Response
    {
        $Action = $ActionRepository->find($idAction);
        $idAction = $Action->getId();
        $idFormation = $Action->getFormation()->getId();
        $name = $Action->getNumero();

        $form = $this->createForm(ActionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime('', new DateTimeZone('Europe/Paris'));

            $Action->setNumero($form->get('numero')->getData());
            $Action->setDatemaj($date);
            $Action->setNiveauEntreeObligatoire($form->get('niveauEntreeObligatoire')->getData());
            $Action->setModalitesEnseignement($form->get('modalitesEnseignement')->getData());
            $Action->setConditionsSpecifiques($form->get('conditionsSpecifiques')->getData());
            $Action->setModalitesEntreesSorties($form->get('modalitesEntreesSorties')->getData());
            $Action->setUrlWeb($form->get('urlWeb')->getData());
            $Action->setRestauration($form->get('restauration')->getData());
            $Action->setHebergement($form->get('hebergement')->getData());
            $Action->setTransport($form->get('transport')->getData());
            $Action->setLangueFormation($form->get('langueFormation')->getData());
            $Action->setModalitesRecrutement($form->get('modalitesRecrutement')->getData());
            $Action->setModalitesPedagogiques($form->get('modalitesPedagogiques')->getData());
            $Action->setCodePerimetreRecrutement($form->get('codePerimetreRecrutement')->getData());
            $Action->setNombreHeuresCentre($form->get('nombreHeuresCentre')->getData());
            $Action->setNombreHeuresEntreprise($form->get('nombreHeuresEntreprise')->getData());

            $Extras = [
                'modalitesHandicap' => $form->get('modalitesHandicap')->getData(),
                'infoAdmission' => $form->get('infoAdmission')->getData(),
                'codeModalitesAdmission' => $form->get('codeModalitesAdmission')->getData(),
                'codeGfe' => $form->get('codeGfe')->getData(),
                'codeTypeHoraire' => $form->get('codeTypeHoraire')->getData(),
                'codeRythmeFormation' => $form->get('codeRythmeFormation')->getData(),
                'fraisAnpec' => $form->get('fraisAnpec')->getData(),
                'fraisCertifInclusFraisAnpec' => $form->get('fraisCertifInclusFraisAnpec')->getData(),
                'detailFraisAnpec' => $form->get('detailFraisAnpec')->getData(),
                'codeModeleEconomique' => $form->get('codeModeleEconomique')->getData(),
                'autresServices' => $form->get('autresServices')->getData(),
                'tauxTva' => $form->get('tauxTva')->getData(),
                'fraisHt' => $form->get('fraisHt')->getData(),
                'fraisTtc' => $form->get('fraisTtc')->getData(),
                'existencePrerequis' => $form->get('existencePrerequis')->getData(),
            ];

            $Action->setExtras($Extras);

            $em = $doctrine->getManager();
            $em->persist($Action);
            $em->flush();
            $this->addFlash('message', 'Action mise à jour');
        };

        return $this->render('formation/viewAction.html.twig', [
            'controller_name' => 'Action : ' . $Action->getNumero(),
            'headerType' => 'action',
            'Form' => $form->createView(),
            'Name' => $name,
            'Action' => $Action,
            'idAction' => $idAction,
            'idFormation' => $idFormation
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////
    /////////////                   GESTION DES SESSION             /////////////
    ////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/nouvelle-session/{idAction}", name="new-session")
     */
    public function newSession(Request $request, ManagerRegistry $doctrine, $idAction, ActionRepository $actionRepository): Response
    {
        $Session = new Session();
        $form = $this->createForm(SessionType::class, $Session);
        $ActionSelect = $actionRepository->find($idAction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $date = new \DateTime('', new DateTimeZone('Europe/Paris'));

            $Session->setNumero($form->get('numero')->getData());
            $Session->setDatecrea($date);
            $Session->setDatemaj($date);
            $Session->setDebut($form->get('debut')->getData());
            $Session->setFin($form->get('fin')->getData());
            $Session->setEtatRecrutement($form->get('etatRecrutement')->getData());
            $Session->setAction($ActionSelect);
            $Session->setGarantie($form->get('garantie')->getData());

            $Extras = [
                "modalitesParticulieres" => $form->get('modalitesParticulieres')->getData()
            ];

            $Session->setExtras($Extras);

            $em->persist($Session);
            $em->flush();

            return $this->redirectToRoute(
                'list-formation'
            );
        };
        return $this->render('formation/newSession.html.twig', [
            'controller_name' => 'Ajouter une session',
            'headerType' => 'add',
            'Form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list-session/{idAction}", name="list-session")
     */
    public function listSession(ActionRepository $ActionRepository, $idAction, SessionRepository $sessionRepository): Response
    {
        $Session = $sessionRepository->findBy(
            ['Action' => $idAction],
        );
        $Action = $ActionRepository->find($idAction);

        return $this->render('formation/listSession.html.twig', [
            'controller_name' => 'Sessions de l’action : ' . $Action->getNumero(),
            'headerType' => 'listSession',
            'Sessions' => $Session,
            'idAction' => $idAction,
            'nameAction' => $Action->getNumero()
        ]);
    }

    /**
     * @Route("/supp-session/{idSession}", name="del-session")
     */
    public function delSession(SessionRepository $sessionRepository, ManagerRegistry $doctrine, $idSession): Response
    {
        $sessionSelect = $sessionRepository->find($idSession);
        $actionSelect = $sessionSelect->getAction()->getId();

        $em = $doctrine->getManager();
        $em->remove($sessionSelect);
        $em->flush();

        return $this->redirectToRoute(
            'list-action/' . $actionSelect,
        );
    }
}
