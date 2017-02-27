<?php
// src/AppBundle/Entity/User.php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="surName", type="string", length=255)
     */
    private $surName;

    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer")
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="webSite", type="string", length=255)
     */
    private $webSite;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="jobTitle", type="string", length=255)
     */
    private $jobTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event", mappedBy="user")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserCategory", mappedBy="user")
     */
    private $userCategory;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EventStatus", mappedBy="user")
     */
    private $eventstatus;




    public function __construct()
    {
        parent::__construct();
        // your own logic

    }



    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }




    /**
     * Set surName
     *
     * @param string $surName
     *
     * @return User
     */
    public function setSurName($surName)
    {
        $this->surName = $surName;

        return $this;
    }

    /**
     * Get surName
     *
     * @return string
     */
    public function getSurName()
    {
        return $this->surName;
    }




    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }





    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }






    /**
     * Set webSite
     *
     * @param string $webSite
     *
     * @return User
     */
    public function setWebSite($webSite)
    {
        $this->webSite = $webSite;

        return $this;
    }

    /**
     * Get webSite
     *
     * @return string
     */
    public function getWebSite()
    {
        return $this->webSite;
    }




    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }





    /**
     * Set jobTitle
     *
     * @param string $jobTitle
     *
     * @return User
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }






    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }







    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     * @return User
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->event[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->event->removeElement($event);
    }

    /**
     * Get event
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvent()
    {
        return $this->event;
    }









    /**
     * Add userCategory
     *
     * @param \AppBundle\Entity\UserCategory $userCategory
     * @return User
     */
    public function addUserCategory(\AppBundle\Entity\UserCategory $userCategory)
    {
        $this->userCategory[] = $userCategory;

        return $this;
    }

    /**
     * Remove userCategory
     *
     * @param \AppBundle\Entity\UserCategory $userCategory
     */
    public function removeUserCategory(\AppBundle\Entity\UserCategory $userCategory)
    {
        $this->event->removeElement($userCategory);
    }

    /**
     * Get userCategory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserCategory()
    {
        return $this->userCategory;
    }




    /**
     * Add eventstatus
     *
     * @param \AppBundle\Entity\EventStatus $eventstatus
     * @return User
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