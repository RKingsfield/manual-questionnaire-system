<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer extends BaseEntity
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\JoinTable(name: 'answer_product_recommendations')]
    #[ORM\JoinColumn(name: 'answer_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: 'Product')]
    private Collection $productRecommendations;

    #[ORM\JoinTable(name: 'answer_product_restrictions')]
    #[ORM\JoinColumn(name: 'answer_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: 'Product')]
    private Collection $productRestrictions;

    public function __construct()
    {
        $this->productRecommendations = new ArrayCollection();
        $this->productRestrictions = new ArrayCollection();
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getProductRecommendations(): Collection
    {
        return $this->productRecommendations;
    }

    public function setProductRecommendations(Collection $productRecommendations): static
    {
        $this->productRecommendations = $productRecommendations;

        return $this;
    }

    public function getProductRestrictions(): Collection
    {
        return $this->productRestrictions;
    }

    public function setProductRestrictions(Collection $productRestrictions): static
    {
        $this->productRestrictions = $productRestrictions;

        return $this;
    }
}
