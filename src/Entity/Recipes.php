<?php

namespace App\Entity;

use App\Repository\RecipesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipesRepository::class)
 */
class Recipes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageLink;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $imageAuthor;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $imageLicense;

    /**
     * @ORM\Column(type="array")
     */
    private $ingredients = [];

    /**
     * @ORM\Column(type="array")
     */
    private $instructions = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $garnish;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function getImageAuthor(): ?string
    {
        return $this->imageAuthor;
    }

    public function setImageAuthor(?string $imageAuthor): self
    {
        $this->imageAuthor = $imageAuthor;

        return $this;
    }

    public function getImageLicense(): ?string
    {
        return $this->imageLicense;
    }

    public function setImageLicense(?string $imageLicense): self
    {
        $this->imageLicense = $imageLicense;

        return $this;
    }

    public function getIngredients(): ?array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getInstructions(): ?array
    {
        return $this->instructions;
    }

    public function setInstructions(array $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getGarnish(): ?string
    {
        return $this->garnish;
    }

    public function setGarnish(?string $garnish): self
    {
        $this->garnish = $garnish;

        return $this;
    }
}
