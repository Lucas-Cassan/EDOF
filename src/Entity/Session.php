<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
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

    #[ORM\Column(type: 'date', nullable: true)]
    private $debut;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fin;

    #[ORM\Column(type: 'integer')]
    private $etatRecrutement;

    #[ORM\Column(type: 'json')]
    private $extras = [];

    #[ORM\ManyToOne(targetEntity: Action::class, inversedBy: 'sessions')]
    private $Action;

    #[ORM\Column(type: 'integer')]
    private $Garantie;

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

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(?\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getEtatRecrutement(): ?int
    {
        return $this->etatRecrutement;
    }

    public function setEtatRecrutement(int $etatRecrutement): self
    {
        $this->etatRecrutement = $etatRecrutement;

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

    public function getAction(): ?Action
    {
        return $this->Action;
    }

    public function setAction(?Action $Action): self
    {
        $this->Action = $Action;

        return $this;
    }

    public function getGarantie(): ?int
    {
        return $this->Garantie;
    }

    public function setGarantie(int $Garantie): self
    {
        $this->Garantie = $Garantie;

        return $this;
    }
}
