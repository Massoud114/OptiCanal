<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FilmRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 * @ApiResource()
 */
class Film
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private string $title;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private string $picture;

	/**
	 * @ORM\Column(type="integer")
	 */
	private int $duration;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private string $synopsis;

	/**
	 * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="films")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private Seance $seance;

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

	public function getPicture(): ?string
	{
		return $this->picture;
	}

	public function setPicture(string $picture): self
	{
		$this->picture = $picture;

		return $this;
	}

	public function getDuration(): int
	{
		return $this->duration;
	}

	public function setDuration(int $duration): self
	{
		$this->duration = $duration;

		return $this;
	}

	public function getSynopsis(): ?string
	{
		return $this->synopsis;
	}

	public function setSynopsis(?string $synopsis): self
	{
		$this->synopsis = $synopsis;

		return $this;
	}

	public function getSeance(): ?Seance
	{
		return $this->seance;
	}

	public function setSeance(?Seance $seance): self
	{
		$this->seance = $seance;

		return $this;
	}
}
