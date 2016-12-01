<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="events")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    private $place;

    /**
     * @ORM\OneToMany(targetEntity="MarkEvent", mappedBy="event")
     *
     */
    protected $marks;


    /**
     * @ORM\OneToMany(targetEntity="Comment_Event", mappedBy="event")
     */
    protected $event_comments;

    public function __construct()
    {
        $this->comments=new ArrayCollection();
        $this->marks=new ArrayCollection();
        $this->date = new \DateTime();
    }
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product picture as a PNG file.")
     * @Assert\File(mimeTypes={ "image/png" })
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
    public function getAbsolutePath()
    {
        return null === $this->picture
            ? null
            : $this->getUploadRootDir().'/'.$this->picture;
    }

    public function getWebPath()
    {
        return null === $this->picture
            ? null
            : $this->getUploadDir().'/'.$this->picture;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads';
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
     * @return Event
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
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Set place
     *
     * @param \AppBundle\Entity\Place $place
     *
     * @return Event
     */
    public function setPlace(\AppBundle\Entity\Place $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \AppBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }



    /**
     * Add mark
     *
     * @param \AppBundle\Entity\Mark $mark
     *
     * @return Event
     */
    public function addMark(\AppBundle\Entity\MarkEvent $mark)
    {
        $this->marks[] = $mark;

        return $this;
    }

    /**
     * Remove mark
     *
     * @param \AppBundle\Entity\Mark $mark
     */
    public function removeMark(\AppBundle\Entity\MarkEvent $mark)
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
    function __toString()
    {
        return $this->name;
    }

    /**
     * Add eventComment
     *
     * @param \AppBundle\Entity\Comment_Event $eventComment
     *
     * @return Event
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
