<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 200
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 100
     * )
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     * @Assert\NotBlank()
     */
    private $price = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="to_negotiate", type="boolean")
     */
    private $toNegotiate = false;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image;

    /**
     * @var array
     *
     * @ORM\Column(name="gallery", type="json_array")
     */
    private $gallery;

    /**
     * @var string
     *
     * @ORM\Column(name="access_hash", type="string", length=32)
     */
    private $accessHash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="datetime")
     */
    private $addDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="refresh_date", type="datetime")
     */
    private $refreshDate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", length=1)
     */
    private $status = 0;

    /**
     * @ORM\Column(name="views", type="integer")
     */
    private $views = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sold", type="boolean")
     */
    private $sold = false;

    /**
     * @ORM\Column(name="stan", type="string")
     * @Assert\Choice({"Nowe", "Używane"})
     */
    private $stan;

    /**
     * @var boolean
     *
     * @ORM\Column(name="warranty", type="boolean", nullable=true)
     */
    private $warranty;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="warranty_date", type="date", nullable=true)
     */
    private $warrantyDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="purchase_date", type="date", nullable=true)
     */
    private $purchaseDate;


    public function __construct()
    {
        $this->addDate = new \DateTime();
        $this->refreshDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Offer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Offer
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Offer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Offer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Offer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Offer
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Offer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set toNegotiate
     *
     * @param boolean $toNegotiate
     *
     * @return Offer
     */
    public function setToNegotiate($toNegotiate)
    {
        $this->toNegotiate = $toNegotiate;

        return $this;
    }

    /**
     * Get toNegotiate
     *
     * @return boolean
     */
    public function getToNegotiate()
    {
        return $this->toNegotiate;
    }

    /**
     * Set gallery
     *
     * @param array $gallery
     *
     * @return Offer
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return array
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set accessHash
     *
     * @param string $accessHash
     *
     * @return Offer
     */
    public function setAccessHash($accessHash)
    {
        $this->accessHash = $accessHash;

        return $this;
    }

    /**
     * Get accessHash
     *
     * @return string
     */
    public function getAccessHash()
    {
        return $this->accessHash;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Offer
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set addDate
     *
     * @param \DateTime $addDate
     *
     * @return Offer
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Get addDate
     *
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Offer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Offer
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Offer
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set sold
     *
     * @param boolean $sold
     *
     * @return Offer
     */
    public function setSold($sold)
    {
        $this->sold = $sold;

        return $this;
    }

    /**
     * Get sold
     *
     * @return boolean
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * Set refreshDate
     *
     * @param \DateTime $refreshDate
     *
     * @return Offer
     */
    public function setRefreshDate($refreshDate)
    {
        $this->refreshDate = $refreshDate;

        return $this;
    }

    /**
     * Get refreshDate
     *
     * @return \DateTime
     */
    public function getRefreshDate()
    {
        return $this->refreshDate;
    }

    /**
     * Set stan
     *
     * @param string $stan
     *
     * @return Offer
     */
    public function setStan($stan)
    {
        $this->stan = $stan;

        return $this;
    }

    /**
     * Get stan
     *
     * @return string
     */
    public function getStan()
    {
        return $this->stan;
    }

    /**
     * Set warranty
     *
     * @param boolean $warranty
     *
     * @return Offer
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return boolean
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set warrantyDate
     *
     * @param \DateTime $warrantyDate
     *
     * @return Offer
     */
    public function setWarrantyDate($warrantyDate)
    {
        $this->warrantyDate = $warrantyDate;

        return $this;
    }

    /**
     * Get warrantyDate
     *
     * @return \DateTime
     */
    public function getWarrantyDate()
    {
        return $this->warrantyDate;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     *
     * @return Offer
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }
}
