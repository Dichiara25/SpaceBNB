<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 * @Vich\Uploadable
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $superficy;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="room")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    public function __toString()
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getSummary() .' ';
        return $s;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getSuperficy(): ?int
    {
        return $this->superficy;
    }

    public function setSuperficy(int $superficy): self
    {
        $this->superficy = $superficy;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): self
    {
      $this->region = $region;   
      
      return $this;
    }

    public function removeRegion(Region $region): self
    {
        $this->region->removeElement($region);

        return $this;
    }

        /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="rooms", fileNameProperty="imageName")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $imageUpdatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="room")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    //...
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
        // It is required that at least one field changes if you are using doctrine
        // otherwise the event listeners won't be called and the file is lost
        $this->imageUpdatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRoom($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRoom() === $this) {
                $comment->setRoom(null);
            }
        }

        return $this;
    }
}
