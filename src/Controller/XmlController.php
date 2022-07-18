<?php

namespace App\Controller;

use App\Repository\ActionRepository;
use App\Repository\FormationRepository;
use App\Repository\InfoGlobalRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class XmlController extends AbstractController
{
    #[Route('/xml', name: 'app_xml')]
    public function index(FormationRepository $formationRepository, ActionRepository $actionRepository, SessionRepository $sessionRepository, InfoGlobalRepository $infoGlobalRepository): Response
    {
        $Formations = $formationRepository->findAll();
        $IngoGlobal = $infoGlobalRepository->find(1);

        $xmlfileName = '87818694900011_godiveau_wordpress_obligatoire';
        $xml_dec = "<?xml version='1.0' encoding='ISO-8859-1'?>";
        $rootELementStart = "<lheo xmlns='https://www.of.moncompteformation.gouv.fr'><offres>";
        $rootElementEnd = "</offres></lheo>";
        $xml_doc = $xml_dec;
        $xml_doc .= $rootELementStart;
        /*         dd($IngoGlobal->getInfos());
 */
        foreach ($Formations as $key => $Formation) {
            $Actions = $actionRepository->findBy(
                ['formation' => $Formation->getId()],
            );

            $xml_doc .= "<formation numero='" . $Formation->getNumero() . "' datemaj='" . $Formation->getDatemaj()->format('Ymd') . "' datecrea='" . $Formation->getDatecrea()->format('Ymd') . "'>
      <intitule-formation><![CDATA[" . $Formation->getIntituleFormation() . "]]></intitule-formation>
      <objectif-formation><![CDATA[" . $Formation->getObjectifFormation() . "]]></objectif-formation>
      <resultats-attendus><![CDATA[" . $Formation->getResultatsAttendus() . "]]></resultats-attendus>
      <contenu-formation><![CDATA[" . $Formation->getContenuFormation() . "]]></contenu-formation>
      <parcours-de-formation>" . $Formation->getParcoursDeFormation() . "</parcours-de-formation>
      <objectif-general-formation>" . $Formation->getObjectifGeneralFormation() . "</objectif-general-formation>
      <certification>
        <code-CERTIFINFO>" . $Formation->getCertifInfo() . "</code-CERTIFINFO>
      </certification>
      ";

            foreach ($Actions as $key => $Action) {
                $Sessions = $sessionRepository->findBy(
                    ['action' => $Action->getId()],
                );

                $xml_doc .= "
      <action numero='" . $Action->getNumero() . "' datemaj='" . $Action->getDatemaj()->format('Ymd') . "' datecrea='" . $Action->getDatecrea()->format('Ymd') . "'>
        <niveau-entree-obligatoire>" . $Action->getNiveauEntreeObligatoire() . "</niveau-entree-obligatoire>
        <modalites-enseignement>" . $Action->getModalitesEnseignement() . "</modalites-enseignement>
        <conditions-specifiques><![CDATA[" . $Action->getConditionsSpecifiques() . "]]></conditions-specifiques>
        <lieu-de-formation>
          <coordonnees numero='" . $IngoGlobal->getInfos()['numero'] . "'>
            <nom>" . $IngoGlobal->getInfos()['nom'] . "</nom>
            <prenom>" . $IngoGlobal->getInfos()['prenom'] . "</prenom>
            <adresse numero='" . $IngoGlobal->getInfos()['numero'] . "'>
              <ligne>" . $IngoGlobal->getInfos()['nomOrganisme'] . "</ligne>
              <codepostal>" . $IngoGlobal->getInfos()['cp'] . "</codepostal>
              <ville>" . $IngoGlobal->getInfos()['Ville'] . "</ville>
              <extras info='adresse'>
                <extra info='numero-voie'>" . $IngoGlobal->getInfos()['numeroVoie'] . "</extra>
                <extra info='code-nature-voie'>" . $IngoGlobal->getInfos()['natureVoie'] . "</extra>
                <extra info='libelle-voie'>" . $IngoGlobal->getInfos()['libelleVoie'] . "</extra>
                <extra info='conformite-reglementaire'>1</extra>
              </extras>
            </adresse>
            <telfixe>
              <numtel>" . $IngoGlobal->getInfos()['telfix'] . "</numtel>
            </telfixe>
            <courriel>" . $IngoGlobal->getInfos()['email'] . "</courriel>
          </coordonnees>
        </lieu-de-formation>
        <modalites-entrees-sorties>" . $Action->getModalitesEntreesSorties() . "</modalites-entrees-sorties>";

                foreach ($Sessions as $key => $Session) {
                    $xml_doc .= "
                    <session numero='" . $Session->getNumero() . "' datemaj='" . $Session->getDatemaj()->format('Ymd') . "' datecrea='" . $Session->getDatecrea()->format('Ymd') . "'>
                    <adresse-inscription>
                       <adresse numero='" . $IngoGlobal->getInfos()['numero'] . "'>
                        <ligne>" . $IngoGlobal->getInfos()['nomOrganisme'] . "</ligne>
                        <codepostal>" . $IngoGlobal->getInfos()['cp'] . "</codepostal>
                        <ville>" . $IngoGlobal->getInfos()['Ville'] . "</ville>
                        <extras info='adresse'>
                            <extra info='numero-voie'>" . $IngoGlobal->getInfos()['numeroVoie'] . "</extra>
                            <extra info='code-nature-voie'>" . $IngoGlobal->getInfos()['natureVoie'] . "</extra>
                            <extra info='libelle-voie'>" . $IngoGlobal->getInfos()['libelleVoie'] . "</extra>
                            <extra info='conformite-reglementaire'>1</extra>
                        </extras>
                        </adresse>
                    </adresse-inscription>
                    <etat-recrutement>" . $Session->getEtatRecrutement() . "</etat-recrutement>
                    <extras info='session'>
                        <extra info='contact-inscription'>
                        <coordonnees numero='" . $IngoGlobal->getInfos()['numero'] . "'>
                            <nom>" . $IngoGlobal->getInfos()['nom'] . "</nom>
                            <prenom>" . $IngoGlobal->getInfos()['prenom'] . "</prenom>
                            <telfixe>
                                <numtel>" . $IngoGlobal->getInfos()['telfix'] . "</numtel>
                            </telfixe>
                            <courriel>" . $IngoGlobal->getInfos()['email'] . "</courriel>
                        </coordonnees>
                        </extra>
                        <extra info='garantie'>" . $Session->getGarantie() . "</extra>
                        <extra info='modalites-particulieres'><![CDATA[" . $Session->getExtras()['modalitesParticulieres'] . "]]></extra>
                    </extras>
                    </session>
                    ";
                }

                $xml_doc .= "
        <adresse-information>
          <adresse numero='" . $IngoGlobal->getInfos()['numero'] . "'>
            <ligne>" . $IngoGlobal->getInfos()['nomOrganisme'] . "</ligne>
            <codepostal>" . $IngoGlobal->getInfos()['cp'] . "</codepostal>
            <ville>" . $IngoGlobal->getInfos()['Ville'] . "</ville>
            <extras info='adresse'>
               <extra info='numero-voie'>" . $IngoGlobal->getInfos()['numeroVoie'] . "</extra>
                <extra info='code-nature-voie'>" . $IngoGlobal->getInfos()['natureVoie'] . "</extra>
                <extra info='libelle-voie'>" . $IngoGlobal->getInfos()['libelleVoie'] . "</extra>
              <extra info='conformite-reglementaire'>1</extra>
            </extras>
          </adresse>
        </adresse-information>
        <restauration>" . $Action->getRestauration() . "</restauration>
        <hebergement>" . $Action->getHebergement() . "</hebergement>
        <transport>" . $Action->getTransport() . "</transport>
        <acces-handicapes><![CDATA[" . $IngoGlobal->getAccesHandicapes() . "]]></acces-handicapes>
        <langue-formation>" . $Action->getLangueFormation() . "</langue-formation>
        <modalites-pedagogiques><![CDATA[" . $Action->getModalitesPedagogiques() . "]]></modalites-pedagogiques>
        <extras info='action'>
          <extra info='contact-information'>
            <coordonnees numero='" . $IngoGlobal->getInfos()['numero'] . "'>
              <nom>" . $IngoGlobal->getInfos()['nom'] . "</nom>
            <prenom>" . $IngoGlobal->getInfos()['prenom'] . "</prenom>
              <telfixe>
                <numtel>" . $IngoGlobal->getInfos()['telfix'] . "</numtel>
              </telfixe>
              <courriel>" . $IngoGlobal->getInfos()['email'] . "</courriel>
            </coordonnees>
          </extra>
          <extra info='modalites-handicap'><![CDATA[" . $Action->getExtras()['modalitesHandicap'] . "]]></extra>
          <extra info='info-admission'><![CDATA[" . $Action->getExtras()['infoAdmission'] . "]]></extra>
          <extras info='codes-modalites-admission'>";

                foreach ($Action->getExtras()['codeModalitesAdmission'] as $key => $value) {
                    $xml_doc .= "<extra info='code-modalites-admission'>" . $value . "</extra>";
                }

                $xml_doc .= "
          </extras>
          <extra info='duree-apprentissage'></extra>
          <extras info='codes-rythme-formation'>
            ";
                foreach ($Action->getExtras()['codeRythmeFormation'] as $key => $value) {
                    $xml_doc .= "<extra info='code-rythme-formation'>" . $value . "</extra>";
                }

                $xml_doc .= "
          </extras>
          <extra info='code-type-horaires'>" . $Action->getExtras()['codeTypeHoraire'] . "</extra>
          <extra info='frais-certif-inclus-frais-anpec'>" . $Action->getExtras()['fraisCertifInclusFraisAnpec'] . "</extra>
          <extra info='code-modele-economique'>" . $Action->getExtras()['codeModeleEconomique'] . "</extra>
          <extras info='frais-pedagogiques'>
            <extra info='taux-tva'>" . $Action->getExtras()['tauxTva'] . "</extra>
            <extra info='frais-ht'>" . $Action->getExtras()['fraisHt'] . "</extra>
            <extra info='frais-ttc'>" . $Action->getExtras()['fraisTtc'] . "</extra>
          </extras>
          <extra info='existence-prerequis'>" . $Action->getExtras()['existencePrerequis'] . "</extra>
        </extras>
      </action>            
                ";
            }

            $xml_doc .= "<organisme-formation-responsable>
        <SIRET-organisme-formation>
          <SIRET>" . $IngoGlobal->getSiret() . "</SIRET>
        </SIRET-organisme-formation>
      </organisme-formation-responsable>
      <extras info='formation'>
        <extra info='resume-contenu'><![CDATA[" . $Formation->getExtraResumeContenu() . "]]></extra>
      </extras>
    </formation>
            ";
        };

        $xml_doc .= "";

        $xml_doc .= $rootElementEnd;
        $default_dir = "";
        $default_dir .= $xmlfileName . ".xml";
        $fp = fopen($default_dir, 'w');
        $write = fwrite($fp, $xml_doc);

        return $this->render('xml/xml.html.twig', [
            'controller_name' => 'Génération du XML',
            'headerType' => 'XML',
            'Formations' => $Formations
        ]);
    }
}
