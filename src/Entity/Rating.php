<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
//contrainte unicité sur la notation :un astuce doit etre noté par un user une seul fois
#[UniqueEntity(
    fields: ['user', 'trick'], // une note par astuce et par un seul.
    errorPath: 'user', //le champs qui aura l'erreur
    message: 'Cet utilisateur à déja noté cet astuce'
)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\Range(
        min: 0,
        max: 5,
        notInRangeMessage: 'La note doit etre comprise entre  {{ min }}cm et  {{ max }} '
    )]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


        /**
     * Return only the security relevant data
     *
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'note' => $this->note,
            'trick' => $this->trick
          
        ];
    }



    //On sérialize les attributs id, username, password puis on les unserialize pour éviter que l'attribut imageFile soit pris en compte
    //voir ce lien pour comprendre : https://webcoast.dk/en/blog/serializing-symfony-security-user-object
    /**
     * Restore security relevant data
     *
     * @param array $data
     */
    public function __unserialize(array $data): void
    {
    
        $this->id = $data['id'];
        $this->note = $data['note'];
        $this->trick = $data['trick'];

      
    }


    public function __construct()
    {
        //donner une date avant le persist
        $this->createdAt = new \DateTimeImmutable();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


}
