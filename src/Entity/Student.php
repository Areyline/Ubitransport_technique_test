<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"post", "get"},
 *     itemOperations={"get", "patch", "delete"},
 *     denormalizationContext={"groups"={"student:write"}},
 *     normalizationContext={"groups"={"student:read"}}
 * )
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"student:read", "student:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"student:read", "student:write"})
     */
    private $surname;

    /**
     * @ORM\Column(type="date")
     *
     * @Groups({"student:read", "student:write"})
     */
    private $birthday;

    /**
     * @ORM\OneToMany(targetEntity=Score::class, mappedBy="student", orphanRemoval=true)
     *
     * @Groups({"student:read"})
     */
    private $scores;


    public function __construct()
    {
        $this->scores = new ArrayCollection();
    }

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection|Score[]
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(Score $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setStudent($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->scores->contains($score)) {
            $this->scores->removeElement($score);
            // set the owning side to null (unless already changed)
            if ($score->getStudent() === $this) {
                $score->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"student:read"})
     */
    public function getAverage() :float
    {
        $total=0.0;

        foreach ($this->scores as $score){
            $total= $total + $score->getValue();
        }

        if (count($this->scores)>0){
            $average= $total/count($this->scores);
        }else{
            $average=0.0;
        }

        return $average;
    }



}
