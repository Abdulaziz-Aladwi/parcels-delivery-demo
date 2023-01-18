<?php

namespace App\Entity;

use App\Constant\ParcelStatus;
use App\Repository\ParcelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParcelRepository")
 * @ORM\Table(name="`parcel`", indexes={
 *     @ORM\Index(columns={"status"})}) 
 */
class Parcel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pickUpAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pickOffAddress;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="parcels")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="parcels")
     */
    private $biker;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $pickUpDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deliveryDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = ParcelStatus::TYPE_PENDING;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     * 
     * @ORM\Column(name="updated_at", type="datetime", nullable = true)
     */
    protected $updatedAt;


    /**
     * Parcel Status String
     *
     * @var string
     */
    protected $statusString;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPickUpAddress(): ?string
    {
        return $this->pickUpAddress;
    }

    public function setPickUpAddress(string $pickUpAddress): self
    {
        $this->pickUpAddress = $pickUpAddress;

        return $this;
    }

    public function getPickOffAddress(): ?string
    {
        return $this->pickOffAddress;
    }

    public function setPickOffAddress(string $pickOffAddress): self
    {
        $this->pickOffAddress = $pickOffAddress;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getBiker(): ?User
    {
        return $this->biker;
    }

    public function setBiker(?User $biker): self
    {
        $this->biker = $biker;

        return $this;
    }

    public function getPickUpDate(): ?\DateTimeInterface
    {
        return $this->pickUpDate;
    }

    public function setPickUpDate(?\DateTimeInterface $pickUpDate): self
    {
        $this->pickUpDate = $pickUpDate;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime("now");

        return $this;

    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt()
    {
        $this->updatedAt =  new \DateTime("now");;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
  
    public function getStatusString(): String
    {
        return ParcelStatus::getLabel($this->status);
    }

    public function isPendingStatus(): bool
    {
        return $this->status == ParcelStatus::TYPE_PENDING;
    }

    public function isPickedUpStatus(): bool
    {
        return $this->status == ParcelStatus::TYPE_PICKED_UP;
    }    

    
}
