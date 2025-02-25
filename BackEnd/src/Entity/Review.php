<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $author;

    #[ORM\Column(type: "integer", nullable: false)]
    private int $score;

    #[ORM\Column(type: "text")]
    private string $content;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
    // Retour avec echappement des entrées html en gardant les quotes
    public function setAuthor(string $author): self
    {
        $this->author = htmlspecialchars($author, ENT_NOQUOTES, 'UTF-8');
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }
    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    // Retour avec echappement des entrées html
    public function setContent(string $content): self
    {
        $this->content = htmlspecialchars($content, ENT_NOQUOTES, 'UTF-8');
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
