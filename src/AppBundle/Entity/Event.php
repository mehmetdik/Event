<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
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
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="eventDescription", type="string", length=255)
     */
    private $eventDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="orgName", type="string", length=255)
     */
    private $orgName;

    /**
     * @var string
     *
     * @ORM\Column(name="orgDiscription", type="string", length=255)
     */
    private $orgDiscription;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=255)
     */
    private $topic;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="integer")
     */
    private $capacity;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User", inversedBy="event")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;



    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\City", inversedBy="event")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Category", inversedBy="event")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EventStatus", mappedBy="event")
     */
    private $eventstatus;




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
     * @return Event
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
     * Set address
     *
     * @param string $address
     *
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }


    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Event
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
     * Set image
     *
     * @param string $image
     *
     * @return Event
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
     * Set eventDescription
     *
     * @param string $eventDescription
     *
     * @return Event
     */
    public function setEventDescription($eventDescription)
    {
        $this->eventDescription = $eventDescription;

        return $this;
    }

    /**
     * Get eventDescription
     *
     * @return string
     */
    public function getEventDescription()
    {
        return $this->eventDescription;
    }

    /**
     * Set orgName
     *
     * @param string $orgName
     *
     * @return Event
     */
    public function setOrgName($orgName)
    {
        $this->orgName = $orgName;

        return $this;
    }

    /**
     * Get orgName
     *
     * @return string
     */
    public function getOrgName()
    {
        return $this->orgName;
    }

    /**
     * Set orgDiscription
     *
     * @param string $orgDiscription
     *
     * @return Event
     */
    public function setOrgDiscription($orgDiscription)
    {
        $this->orgDiscription = $orgDiscription;

        return $this;
    }

    /**
     * Get orgDiscription
     *
     * @return string
     */
    public function getOrgDiscription()
    {
        return $this->orgDiscription;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set topic
     *
     * @param string $topic
     *
     * @return Event
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return Event
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }


    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return Event
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
















    /**
     * Set city
     *
     * @param \AppBundle\Entity\City $city
     * @return Event
     */
    public function setCity(\AppBundle\Entity\City $city= null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }






    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Event
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
     * Add eventstatus
     *
     * @param \AppBundle\Entity\EventStatus $eventstatus
     * @return Event
     */
    public function addEventstatus(\AppBundle\Entity\EventStatus $eventstatus)
    {
        $this->eventstatus[] = $eventstatus;

        return $this;
    }

    /**
     * Remove eventstatus
     *
     * @param \AppBundle\Entity\EventStatus $eventstatus
     */
    public function removeEventstatus(\AppBundle\Entity\EventStatus $eventstatus)
    {
        $this->eventstatus->removeElement($eventstatus);
    }

    /**
     * Get eventstatus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventstatus()
    {
        return $this->eventstatus;
    }
}

