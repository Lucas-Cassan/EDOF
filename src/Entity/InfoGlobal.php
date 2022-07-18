<?php

namespace App\Entity;

use App\Repository\InfoGlobalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoGlobalRepository::class)]
class InfoGlobal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'json')]
    private $infos = [];

    #[ORM\Column(type: 'string', length: 250)]
    private $accesHandicapes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfos(): ?array
    {
        return $this->infos;
    }

    public function setInfos(array $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    public function getAccesHandicapes(): ?string
    {
        return $this->accesHandicapes;
    }

    public function setAccesHandicapes(string $accesHandicapes): self
    {
        $this->accesHandicapes = $accesHandicapes;

        return $this;
    }
}
