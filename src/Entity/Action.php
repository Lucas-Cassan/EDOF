<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\All;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $numero;

    #[ORM\Column(type: 'date')]
    private $datemaj;

    #[ORM\Column(type: 'date')]
    private $datecrea;

    #[ORM\Column(type: 'integer')]
    private $niveauEntreeObligatoire;

    #[ORM\Column(type: 'integer')]
    private $modalitesEnseignement;

    #[ORM\Column(type: 'string', length: 3000, nullable: true)]
    private $conditionsSpecifiques;

    #[ORM\Column(type: 'integer')]
    private $modalitesEntreesSorties;

    #[ORM\Column(type: 'string', length: 400, nullable: true)]
    private $urlWeb;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateInformation;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $restauration;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $hebergement;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $transport;

    #[ORM\Column(type: 'string', length: 2)]
    private $langueFormation;

    #[ORM\Column(type: 'string', length: 3000, nullable: true)]
    private $modalitesRecrutement;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $modalitesPedagogiques;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $codePerimetreRecrutement;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $infosPerimetreRecrutement;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nombreHeuresCentre;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nombreHeuresEntreprise;

    #[ORM\ManyToOne(targetEntity: Formation::class, inversedBy: 'actions')]
    private $formation;

    #[ORM\Column(type: 'json')]
    private $extras = [];

    #[ORM\OneToMany(mappedBy: 'Action', targetEntity: Session::class, cascade: ['remove'])]
    private $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDatemaj(): ?\DateTimeInterface
    {
        return $this->datemaj;
    }

    public function setDatemaj(\DateTimeInterface $datemaj): self
    {
        $this->datemaj = $datemaj;

        return $this;
    }

    public function getDatecrea(): ?\DateTimeInterface
    {
        return $this->datecrea;
    }

    public function setDatecrea(\DateTimeInterface $datecrea): self
    {
        $this->datecrea = $datecrea;

        return $this;
    }

    public function getNiveauEntreeObligatoire(): ?int
    {
        return $this->niveauEntreeObligatoire;
    }

    public function setNiveauEntreeObligatoire(int $niveauEntreeObligatoire): self
    {
        $this->niveauEntreeObligatoire = $niveauEntreeObligatoire;

        return $this;
    }

    public function getModalitesEnseignement(): ?int
    {
        return $this->modalitesEnseignement;
    }

    public function setModalitesEnseignement(int $modalitesEnseignement): self
    {
        $this->modalitesEnseignement = $modalitesEnseignement;

        return $this;
    }

    public function getConditionsSpecifiques(): ?string
    {
        return $this->conditionsSpecifiques;
    }

    public function setConditionsSpecifiques(?string $conditionsSpecifiques): self
    {
        $this->conditionsSpecifiques = $conditionsSpecifiques;

        return $this;
    }

    public function getModalitesEntreesSorties(): ?int
    {
        return $this->modalitesEntreesSorties;
    }

    public function setModalitesEntreesSorties(int $modalitesEntreesSorties): self
    {
        $this->modalitesEntreesSorties = $modalitesEntreesSorties;

        return $this;
    }

    public function getUrlWeb(): ?string
    {
        return $this->urlWeb;
    }

    public function setUrlWeb(?string $urlWeb): self
    {
        $this->urlWeb = $urlWeb;

        return $this;
    }

    public function getDateInformation(): ?\DateTimeInterface
    {
        return $this->dateInformation;
    }

    public function setDateInformation(?\DateTimeInterface $dateInformation): self
    {
        $this->dateInformation = $dateInformation;

        return $this;
    }

    public function getRestauration(): ?string
    {
        return $this->restauration;
    }

    public function setRestauration(?string $restauration): self
    {
        $this->restauration = $restauration;

        return $this;
    }

    public function getHebergement(): ?string
    {
        return $this->hebergement;
    }

    public function setHebergement(?string $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }

    public function getTransport(): ?string
    {
        return $this->transport;
    }

    public function setTransport(?string $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getLangueFormation(): ?string
    {
        return $this->langueFormation;
    }

    public function setLangueFormation(string $langueFormation): self
    {
        $this->langueFormation = $langueFormation;

        return $this;
    }

    public function getModalitesRecrutement(): ?string
    {
        return $this->modalitesRecrutement;
    }

    public function setModalitesRecrutement(?string $modalitesRecrutement): self
    {
        $this->modalitesRecrutement = $modalitesRecrutement;

        return $this;
    }

    public function getModalitesPedagogiques(): ?string
    {
        return $this->modalitesPedagogiques;
    }

    public function setModalitesPedagogiques(?string $modalitesPedagogiques): self
    {
        $this->modalitesPedagogiques = $modalitesPedagogiques;

        return $this;
    }

    public function getCodePerimetreRecrutement(): ?int
    {
        return $this->codePerimetreRecrutement;
    }

    public function setCodePerimetreRecrutement(?int $codePerimetreRecrutement): self
    {
        $this->codePerimetreRecrutement = $codePerimetreRecrutement;

        return $this;
    }

    public function getInfosPerimetreRecrutement(): ?string
    {
        return $this->infosPerimetreRecrutement;
    }

    public function setInfosPerimetreRecrutement(?string $infosPerimetreRecrutement): self
    {
        $this->infosPerimetreRecrutement = $infosPerimetreRecrutement;

        return $this;
    }

    public function getNombreHeuresCentre(): ?int
    {
        return $this->nombreHeuresCentre;
    }

    public function setNombreHeuresCentre(?int $nombreHeuresCentre): self
    {
        $this->nombreHeuresCentre = $nombreHeuresCentre;

        return $this;
    }

    public function getNombreHeuresEntreprise(): ?int
    {
        return $this->nombreHeuresEntreprise;
    }

    public function setNombreHeuresEntreprise(?int $nombreHeuresEntreprise): self
    {
        $this->nombreHeuresEntreprise = $nombreHeuresEntreprise;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getExtras(): ?array
    {
        return $this->extras;
    }

    public function setExtras(array $extras): self
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setAction($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getAction() === $this) {
                $session->setAction(null);
            }
        }

        return $this;
    }
}
