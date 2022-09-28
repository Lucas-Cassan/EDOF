<?php

namespace App\Controller;

use App\Entity\InfoGlobal;
use App\Repository\ActionRepository;
use App\Repository\FormationRepository;
use App\Repository\InfoGlobalRepository;
use App\Repository\SessionRepository;
use Doctrine\Migrations\Configuration\Migration\FormattedFile;
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
    $FormationsFails = [];
    $ActionsFails = [];

    //Vérifie que chaque Formations possèdent au moins 1 Action.
    foreach ($Formations as $key => $Formation) {
      $Actions = $actionRepository->findBy(
        ['formation' => $Formation->getId()],
      );
      if ($Actions == null) {
        array_push($FormationsFails, $Formation);
      }

      //Vérifie que chaque Actions possèdent au moins 1 Session.
      foreach ($Actions as $key => $Action) {
        $Sessions = $sessionRepository->findBy(
          ['Action' => $Action->getId()],
        );
        if ($Sessions == null) {
          array_push($ActionsFails, $Action);
        }
      }
    }

    if ($FormationsFails != null || $ActionsFails != null) {
      return $this->render('xml/xml-fail.html.twig', [
        'controller_name' => 'Erreur lors de la génération du XML',
        'headerType' => 'XML',
        'FormationsFails' => $FormationsFails,
        'ActionsFails' => $ActionsFails,
      ]);
    } else {

      //Création du fichier XMl
      $xmlfileName = "87818694900029_godiveau_wordpress_obligatoire";
      $xml_dec = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
      $rootELementStart = "<lheo xmlns=\"https://www.of.moncompteformation.gouv.fr\"><offres>";
      $rootElementEnd = "</offres></lheo>";
      $xml_doc = $xml_dec;
      $xml_doc .= $rootELementStart;

      foreach ($Formations as $key => $Formation) {
        $Actions = $actionRepository->findBy(
          ['formation' => $Formation->getId()],
        );

        $xml_doc .= "<formation numero=\"" . $Formation->getNumero() . "\" datemaj=\"" . $Formation->getDatemaj()->format('Ymd') . "\" datecrea=\"" . $Formation->getDatecrea()->format('Ymd') . "\">
      <intitule-formation>" . $Formation->getIntituleFormation() . "</intitule-formation>
      <objectif-formation><![CDATA[" . $Formation->getObjectifFormation() . "]]></objectif-formation>
      <resultats-attendus><![CDATA[" . $Formation->getResultatsAttendus() . "]]></resultats-attendus>
      <contenu-formation><![CDATA[" . $Formation->getContenuFormation() . "]]></contenu-formation>
      <parcours-de-formation>" . $Formation->getParcoursDeFormation() . "</parcours-de-formation>
      <objectif-general-formation>" . $Formation->getObjectifGeneralFormation() . "</objectif-general-formation>
     ";

        $xml_doc .= "<certification>";

        if (substr($Formation->getCertifInfo(), 0, 4) == "RNCP") {
          $xml_doc .= " <code-RNCP>" . $Formation->getCertifInfo() . "</code-RNCP>";
        } else if (substr($Formation->getCertifInfo(), 0, 2) == "RS") {
          $xml_doc .= " <code-RS>" . $Formation->getCertifInfo() . "</code-RS>";
        } else if (substr($Formation->getCertifInfo(), 0, 3) == "CPF") {
          $xml_doc .= " <code-CPF>" . $Formation->getCertifInfo() . "</code-CPF>";
        } else {
          dd("ERROR CERTIF INFO");
        }


        $xml_doc .= "</certification>";

        foreach ($Actions as $key => $Action) {
          $Sessions = $sessionRepository->findBy(
            ['Action' => $Action->getId()],
          );

          $xml_doc .= "
      <action numero=\"" . $Action->getNumero() . "\" datemaj=\"" . $Action->getDatemaj()->format('Ymd') . "\" datecrea=\"" . $Action->getDatecrea()->format('Ymd') . "\">
        <niveau-entree-obligatoire>" . $Action->getNiveauEntreeObligatoire() . "</niveau-entree-obligatoire>
        <modalites-enseignement>" . $Action->getModalitesEnseignement() . "</modalites-enseignement>
        <conditions-specifiques><![CDATA[" . $Action->getConditionsSpecifiques() . "]]></conditions-specifiques>
        <lieu-de-formation>
          <coordonnees numero=\"" . $IngoGlobal->getInfos()['numero'] . "\">
            <nom>" . $IngoGlobal->getInfos()['nom'] . "</nom>
            <prenom>" . $IngoGlobal->getInfos()['prenom'] . "</prenom>
            <adresse numero=\"" . $IngoGlobal->getInfos()['numero'] . "\">
              <ligne>" . $IngoGlobal->getInfos()['nomOrganisme'] . "</ligne>
              <codepostal>" . $IngoGlobal->getInfos()['cp'] . "</codepostal>
              <ville>" . $IngoGlobal->getInfos()['Ville'] . "</ville>
              <extras info=\"adresse\">
                <extra info=\"numero-voie\">" . $IngoGlobal->getInfos()['numeroVoie'] . "</extra>
                <extra info=\"code-nature-voie\">" . $IngoGlobal->getInfos()['natureVoie'] . "</extra>
                <extra info=\"libelle-voie\">" . $IngoGlobal->getInfos()['libelleVoie'] . "</extra>
                <extra info=\"conformite-reglementaire\">1</extra>
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
                    <session numero=\"" . $Session->getNumero() . "\" datemaj=\"" . $Session->getDatemaj()->format('Ymd') . "\" datecrea=\"" . $Session->getDatecrea()->format('Ymd') . "\">
                    <adresse-inscription>
                       <adresse numero=\"" . $IngoGlobal->getInfos()['numero'] . "\">
                        <ligne>" . $IngoGlobal->getInfos()['nomOrganisme'] . "</ligne>
                        <codepostal>" . $IngoGlobal->getInfos()['cp'] . "</codepostal>
                        <ville>" . $IngoGlobal->getInfos()['Ville'] . "</ville>
                        <extras info=\"adresse\">
                            <extra info=\"numero-voie\">" . $IngoGlobal->getInfos()['numeroVoie'] . "</extra>
                            <extra info=\"code-nature-voie\">" . $IngoGlobal->getInfos()['natureVoie'] . "</extra>
                            <extra info=\"libelle-voie\">" . $IngoGlobal->getInfos()['libelleVoie'] . "</extra>
                            <extra info=\"conformite-reglementaire\">1</extra>
                        </extras>
                        </adresse>
                    </adresse-inscription>
                    <etat-recrutement>" . $Session->getEtatRecrutement() . "</etat-recrutement>
                    <extras info=\"session\">
                        <extra info=\"contact-inscription\">
                        <coordonnees numero=\"" . $IngoGlobal->getInfos()['numero'] . "\">
                            <nom>" . $IngoGlobal->getInfos()['nom'] . "</nom>
                            <prenom>" . $IngoGlobal->getInfos()['prenom'] . "</prenom>
                            <telfixe>
                                <numtel>" . $IngoGlobal->getInfos()['telfix'] . "</numtel>
                            </telfixe>
                            <courriel>" . $IngoGlobal->getInfos()['email'] . "</courriel>
                        </coordonnees>
                        </extra>
                        <extra info=\"garantie\">" . $Session->getGarantie() . "</extra>
                        <extra info=\"modalites-particulieres\"><![CDATA[" . $Session->getExtras()['modalitesParticulieres'] . "]]></extra>
                    </extras>
                    </session>
                    ";
          }

          $xml_doc .= "
        <adresse-information>
          <adresse numero=\"" . $IngoGlobal->getInfos()['numero'] . "\">
            <ligne>" . $IngoGlobal->getInfos()['nomOrganisme'] . "</ligne>
            <codepostal>" . $IngoGlobal->getInfos()['cp'] . "</codepostal>
            <ville>" . $IngoGlobal->getInfos()['Ville'] . "</ville>
            <extras info=\"adresse\">
               <extra info=\"numero-voie\">" . $IngoGlobal->getInfos()['numeroVoie'] . "</extra>
                <extra info=\"code-nature-voie\">" . $IngoGlobal->getInfos()['natureVoie'] . "</extra>
                <extra info=\"libelle-voie\">" . $IngoGlobal->getInfos()['libelleVoie'] . "</extra>
              <extra info=\"conformite-reglementaire\">1</extra>
            </extras>
          </adresse>
        </adresse-information>";

          if ($Action->getRestauration() != null) {
            $xml_doc .= "<restauration>" . $Action->getRestauration() . "</restauration>";
          }
          if ($Action->getHebergement() != null) {
            $xml_doc .= "<hebergement>" . $Action->getHebergement() . "</hebergement>";
          }
          if ($Action->getTransport() != null) {
            $xml_doc .= "<transport>" . $Action->getTransport() . "</transport>";
          }

          $xml_doc .= "
        <acces-handicapes><![CDATA[" . $IngoGlobal->getAccesHandicapes() . "]]></acces-handicapes>
        <langue-formation>" . $Action->getLangueFormation() . "</langue-formation>
        <modalites-pedagogiques><![CDATA[" . $Action->getModalitesPedagogiques() . "]]></modalites-pedagogiques>
        <extras info=\"action\">
          <extra info=\"contact-information\">
            <coordonnees numero=\"" . $IngoGlobal->getInfos()['numero'] . "\">
              <nom>" . $IngoGlobal->getInfos()['nom'] . "</nom>
            <prenom>" . $IngoGlobal->getInfos()['prenom'] . "</prenom>
              <telfixe>
                <numtel>" . $IngoGlobal->getInfos()['telfix'] . "</numtel>
              </telfixe>
              <courriel>" . $IngoGlobal->getInfos()['email'] . "</courriel>
            </coordonnees>
          </extra>
          <extra info=\"modalites-handicap\"><![CDATA[" . $Action->getExtras()['modalitesHandicap'] . "]]></extra>
          <extra info=\"info-admission\"><![CDATA[" . $Action->getExtras()['infoAdmission'] . "]]></extra>
          <extras info=\"codes-modalites-admission\">";

          foreach ($Action->getExtras()['codeModalitesAdmission'] as $key => $value) {
            $xml_doc .= "<extra info=\"code-modalites-admission\">" . $value . "</extra>";
          }

          $xml_doc .= "
          </extras>
          <extras info=\"codes-rythme-formation\">
            ";

          /* <extra info=\"duree-apprentissage\"></extra> */

          foreach ($Action->getExtras()['codeRythmeFormation'] as $key => $value) {
            $xml_doc .= "<extra info=\"code-rythme-formation\">" . $value . "</extra>";
          }

          $xml_doc .= "
          </extras>
          <extra info=\"code-type-horaires\">" . $Action->getExtras()['codeTypeHoraire'] . "</extra>
          <extra info=\"frais-certif-inclus-frais-anpec\">" . $Action->getExtras()['fraisCertifInclusFraisAnpec'] . "</extra>
          <extra info=\"code-modele-economique\">" . $Action->getExtras()['codeModeleEconomique'] . "</extra>
          <extras info=\"frais-pedagogiques\">
            <extra info=\"taux-tva\">" . $Action->getExtras()['tauxTva'] . "</extra>
            <extra info=\"frais-ht\">" . $Action->getExtras()['fraisHt'] . "</extra>
            <extra info=\"frais-ttc\">" . $Action->getExtras()['fraisTtc'] . "</extra>
          </extras>
          <extra info=\"existence-prerequis\">" . $Action->getExtras()['existencePrerequis'] . "</extra>
        </extras>
      </action>            
                ";
        }

        $xml_doc .= "<organisme-formation-responsable>
        <SIRET-organisme-formation>
          <SIRET>" . $IngoGlobal->getSiret() . "</SIRET>
        </SIRET-organisme-formation>
      </organisme-formation-responsable>
      <extras info=\"formation\">
        <extra info=\"resume-contenu\"><![CDATA[" . $Formation->getExtraResumeContenu() . "]]></extra>
      </extras>
    </formation>
            ";
      };

      $xml_doc .= "";
      $xml_doc .= $rootElementEnd;

      /* 
    é = &eacute
	  ' = &#39
	  î = &icirc
	  à = &agrave
	  è = &egrave 
    â = &acirc
    œ = &oelig
    */

      $xml_doc = str_replace('é', '&eacute', $xml_doc);
      $xml_doc = str_replace('è', '&egrave', $xml_doc);
      $xml_doc = str_replace('à', '&agrave', $xml_doc);
      $xml_doc = str_replace('À', '&Agrave', $xml_doc);
      $xml_doc = str_replace('ï', '&iuml', $xml_doc);
      $xml_doc = str_replace('î', '&icirc', $xml_doc);

      $xml_doc = str_replace('ô', '&ocirc', $xml_doc);
      $xml_doc = str_replace('ç', '&ccedil', $xml_doc);
      $xml_doc = str_replace('ê', '&ecirc', $xml_doc);
      $xml_doc = str_replace('â', '&acirc', $xml_doc);
      $xml_doc = str_replace('Â', '&Acirc', $xml_doc);
      $xml_doc = str_replace('ù', '&ugrave', $xml_doc);
      $xml_doc = str_replace('œ', '&oelig', $xml_doc);

      $xml_doc = str_replace("’", "'", $xml_doc);
      $xml_doc = str_replace("'", "&acute", $xml_doc);

      $default_dir = "";
      $default_dir .= $xmlfileName . ".xml";
      $fp = fopen($default_dir, 'w');
      $write = fwrite($fp, $xml_doc);
    }

    return $this->render('xml/xml.html.twig', [
      'controller_name' => 'Génération du XML réussis avec Succès ✅',
      'headerType' => 'add',
      'Formations' => $Formations,
      'SIRET' => $IngoGlobal->getSiret()
    ]);
  }
}
