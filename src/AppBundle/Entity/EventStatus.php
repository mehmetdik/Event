<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventStatus
 *
 * @ORM\Table(name="event_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventStatusRepository")
 */
class EventStatus
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
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Event", inversedBy="eventstatus")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="eventstatus")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set status
     *
     * @param integer $status
     *
     * @return EventStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }



    /**
     * Set event
     *
     * @param \AppBundle\Entity\Event $event
     * @return EventStatus
     */
    public function setEvent(\AppBundle\Entity\Event $event= null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AppBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }





    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return EventStatus
     */
    public function setUser(\UserBundle\Entity\User $user= null)
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
        return $this->event;
    }

}

