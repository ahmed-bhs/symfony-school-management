<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ORM\Table(name: 'note')]
#[UniqueEntity(fields: ['evaluation', 'etudiant'], message: 'Une note existe déjà pour cet étudiant et cette évaluation.')]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    private ?float $valeur = null;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(targetEntity: Evaluation::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Evaluation $evaluation = null;

    #[ORM\ManyToOne(targetEntity: Etudiant::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Etudiant $etudiant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(?float $valeur): static
    {
        $this->valeur = $valeur;
        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;
        return $this;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): static
    {
        $this->evaluation = $evaluation;
        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;
        return $this;
    }

    public function __toString(): string
    {
        return 'Note: ' . ($this->valeur ?? 'N/A');
    }
}
