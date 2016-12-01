<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
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
 * @ORM\OneToMany(targetEntity="Mark_Place", mappedBy="user")
 */
    protected $place_marks;




    /**
     * @ORM\OneToMany(targetEntity="Comment_Event", mappedBy="user")
     */
    protected $event_comments;

    /**
     * @ORM\OneToMany(targetEntity="Comment_Place", mappedBy="user")
     */
    protected $place_comments;

    public function __construct()
    {
        parent::__construct();
        $this->event_comments=new ArrayCollection();
        $this->place_comments=new ArrayCollection();
        $this->event_marks=new ArrayCollection();
        $this->place_marks=new ArrayCollection();
    }
    function __toString()
    {
        return (string)$this->username;
    }


    /**
     * Add placeMark
     *
     * @param \AppBundle\Entity\Mark_Place $placeMark
     *
     * @return User
     */
    public function addPlaceMark(\AppBundle\Entity\Mark_Place $placeMark)
    {
        $this->place_marks[] = $placeMark;

        return $this;
    }

    /**
     * Remove placeMark
     *
     * @param \AppBundle\Entity\Mark_Place $placeMark
     */
    public function removePlaceMark(\AppBundle\Entity\Mark_Place $placeMark)
    {
        $this->place_marks->removeElement($placeMark);
    }

    /**
     * Get placeMarks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaceMarks()
    {
        return $this->place_marks;
    }

    /**
     * Add eventMark
     *
     * @param \AppBundle\Entity\MarkEvent $eventMark
     *
     * @return User
     */
    public function addEventMark(\AppBundle\Entity\MarkEvent $eventMark)
    {
        $this->event_marks[] = $eventMark;

        return $this;
    }

    /**
     * Remove eventMark
     *
     * @param \AppBundle\Entity\MarkEvent $eventMark
     */
    public function removeEventMark(\AppBundle\Entity\MarkEvent $eventMark)
    {
        $this->event_marks->removeElement($eventMark);
    }

    /**
     * Get eventMarks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventMarks()
    {
        return $this->event_marks;
    }

    /**
     * Add placeComment
     *
     * @param \AppBundle\Entity\Comment_Place $placeComment
     *
     * @return User
     */
    public function addPlaceComment(\AppBundle\Entity\Comment_Place $placeComment)
    {
        $this->place_comments[] = $placeComment;

        return $this;
    }

    /**
     * Remove placeComment
     *
     * @param \AppBundle\Entity\Comment_Place $placeComment
     */
    public function removePlaceComment(\AppBundle\Entity\Comment_Place $placeComment)
    {
        $this->place_comments->removeElement($placeComment);
    }

    /**
     * Get placeComments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaceComments()
    {
        return $this->place_comments;
    }

    /**
     * Add eventComment
     *
     * @param \AppBundle\Entity\Comment_Event $eventComment
     *
     * @return User
     */
    public function addEventComment(\AppBundle\Entity\Comment_Event $eventComment)
    {
        $this->event_comments[] = $eventComment;

        return $this;
    }

    /**
     * Remove eventComment
     *
     * @param \AppBundle\Entity\Comment_Event $eventComment
     */
    public function removeEventComment(\AppBundle\Entity\Comment_Event $eventComment)
    {
        $this->event_comments->removeElement($eventComment);
    }

    /**
     * Get eventComments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventComments()
    {
        return $this->event_comments;
    }
}
