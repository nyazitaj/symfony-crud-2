<?php

namespace App\Entity;

use App\Repository\FilmsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FilmsRepository::class)
 */
class Films
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *    message = "Ce champ est requis.",
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *    message = "Ce champ est requis.",
     * )
     */
    private $realisateur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *    message = "Ce champ est requis.",
     * )
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *    message = "Ce champ est requis.",
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *    message = "L'url n'est pas valie.",
     * )\
     * @Assert\NotBlank(
     *    message = "Ce champ est requis.",
     * )
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRealisateur(): ?string
    {
        return $this->realisateur;
    }

    public function setRealisateur(string $realisateur): self
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
