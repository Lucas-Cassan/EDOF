<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $intituleFormation;

    #[ORM\Column(type: 'string', length: 3000)]
    private $objectifFormation;

    #[ORM\Column(type: 'string', length: 3000)]
    private $resultatsAttendus;

    #[ORM\Column(type: 'string', length: 3000)]
    private $contenuFormation;

    #[ORM\Column(type: 'integer')]
    private $parcoursDeFormation;

    #[ORM\Column(type: 'integer')]
    private $objectifGeneralFormation;

    #[ORM\Column(type: 'string')]
    private $certifInfo;

    #[ORM\Column(type: 'string', length: 255)]
    private $extraResumeContenu;

    #[ORM\Column(type: 'date')]
    private $datemaj;

    #[ORM\Column(type: 'date')]
    private $datecrea;

    #[ORM\Column(type: 'string', length: 30)]
    private $numero;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: Action::class, cascade: ['remove'])]

    private $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleFormation(): ?string
    {
        return $this->intituleFormation;
    }

    public function setIntituleFormation(string $intituleFormation): self
    {
        $this->intituleFormation = $intituleFormation;

        return $this;
    }

    public function getObjectifFormation(): ?string
    {
        return $this->objectifFormation;
    }

    public function setObjectifFormation(string $objectifFormation): self
    {
        $this->objectifFormation = $objectifFormation;

        return $this;
    }

    public function getResultatsAttendus(): ?string
    {
        return $this->resultatsAttendus;
    }

    public function setResultatsAttendus(string $resultatsAttendus): self
    {
        $this->resultatsAttendus = $resultatsAttendus;
        return $this;
    }

    public function getContenuFormation(): ?string
    {
        return $this->contenuFormation;
    }

    public function setContenuFormation(string $contenuFormation): self
    {
        $this->contenuFormation = $contenuFormation;
        return $this;
    }

    public function getParcoursDeFormation(): ?int
    {
        return $this->parcoursDeFormation;
    }

    public function setParcoursDeFormation(int $parcoursDeFormation): self
    {
        $this->parcoursDeFormation = $parcoursDeFormation;
        return $this;
    }

    public function getObjectifGeneralFormation(): ?int
    {
        return $this->objectifGeneralFormation;
    }

    public function setObjectifGeneralFormation(int $objectifGeneralFormation): self
    {
        $this->objectifGeneralFormation = $objectifGeneralFormation;
        return $this;
    }

    public function getCertifInfo(): ?string
    {
        return $this->certifInfo;
    }

    public function setCertifInfo(string $certifInfo): self
    {
        $this->certifInfo = $certifInfo;
        return $this;
    }

    public function getExtraResumeContenu(): ?string
    {
        return $this->extraResumeContenu;
    }

    public function setExtraResumeContenu(string $extraResumeContenu): self
    {
        $this->extraResumeContenu = $extraResumeContenu;

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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setFormation($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getFormation() === $this) {
                $action->setFormation(null);
            }
        }

        return $this;
    }
}
