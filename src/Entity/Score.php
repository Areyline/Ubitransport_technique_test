<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     denormalizationContext={"groups"={"score:write"}},
 *     normalizationContext={"groups"={"score:read"}},
 *     collectionOperations={
 *          "post"={},
 *          "calculate-class-average"={
 *              "method"="GET",
 *              "path"="/scores/average",
 *              "controller"=App\Controller\CalculateClassAverage::class
 *          },
 *      },
 *     itemOperations={"patch", "delete", "get"}
 * )
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     *
     * @Groups({"score:write", "score:read"})
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"score:write", "score:read"})
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"score:write"})
     */
    private $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(string $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
