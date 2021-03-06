<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 */
class Place
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="place", cascade={"all"} )
     */
    protected $events;

    /**
     * @ORM\OneToMany(targetEntity="Mark_Place", mappedBy="place", cascade={"all"})
     */
    protected $marks;


    /**
     * @ORM\OneToMany(targetEntity="Comment_Place", mappedBy="place", cascade={"all"})
     */
    protected $place_comments;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product picture as a JPG file.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $picture;

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
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
     * Set name
     *
     * @param string $name
     *
     * @return Place
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Place
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Place
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
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Place
     */
    public function addEvent(\AppBundle\Entity\Event $eventt)
    {
        $this->events[] = $eventt;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $eventt
     */
    public function removeEvent(\AppBundle\Entity\Event $eventt)
    {
        $this->events->removeElement($eventt);
    }

    /**
     * Get Event
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }


    /**
     * Add mark
     *
     * @param \AppBundle\Entity\Mark_Place $mark
     *
     * @return Place
     */
    public function addMark(\AppBundle\Entity\Mark_Place $mark)
    {
        $this->marks[] = $mark;

        return $this;
    }

    /**
     * Remove mark
     *
     * @param \AppBundle\Entity\Mark $mark
     */
    public function removeMark(\AppBundle\Entity\Mark_Place $mark)
    {
        $this->marks->removeElement($mark);
    }

    /**
     * Get marks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarks()
    {
        return $this->marks;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->marks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->place_comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function __toString()
    {
        return $this->name;
    }



    /**
     * Add placeComment
     *
     * @param \AppBundle\Entity\Comment_Place $placeComment
     *
     * @return Place
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
}
