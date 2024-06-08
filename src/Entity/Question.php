<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question extends BaseEntity
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\JoinTable(name: 'question_answers')]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'answer_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: 'Answer')]
    private Collection $answers;

    #[ORM\JoinTable(name: 'question_answers_required')]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'answer_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: 'Answer')]
    private Collection $answersRequiredToDisplay;

    #[ORM\Column]
    private ?int $position = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->answersRequiredToDisplay = new ArrayCollection();
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function setAnswers(Collection $answers): static
    {
        $this->answers = $answers;

        return $this;
    }

    public function getAnswersRequiredToDisplay(): Collection
    {
        return $this->answersRequiredToDisplay;
    }

    public function setAnswersRequiredToDisplay(Collection $answersRequiredToDisplay): static
    {
        $this->answersRequiredToDisplay = $answersRequiredToDisplay;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
