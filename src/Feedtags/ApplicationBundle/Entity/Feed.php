<?php

namespace Feedtags\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Feed
 *
 * @package Feedtags\ApplicationBundle\Entity
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "feedtags_application_feed_get",
 *          parameters = {
 *              "id" = "expr(object.getId())"
 *          }
 *      )
 * )
 *
 * @ORM\Table(name="feeds")
 * @ORM\Entity(repositoryClass="Feedtags\ApplicationBundle\Repository\FeedRepository")
 */
class Feed
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Name of the feed
     *
     * @var string
     *
     * @Assert\Length(min = "2", max = "255")
     * @Assert\NotNull
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * Description of the feed
     *
     * @var string
     *
     * @Assert\Length(max = "255")
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $description;

    /**
     * Feed URL
     *
     * @var string
     *
     * @Assert\Length(max = "255")
     * @Assert\Url
     * @Assert\NotNull
     *
     * @ORM\Column(type="string", unique=true, length=255)
     */
    protected $url;

    /**
     * Timestamp when last updated
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @Serializer\Exclude
     *
     * @ORM\OneToMany(targetEntity="FeedItem", mappedBy="feed")
     */
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Feed
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
     * Set url
     *
     * @param string $url
     * @return Feed
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Set description
     *
     * @param string $description
     * @return Feed
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Feed
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add items
     *
     * @param \Feedtags\ApplicationBundle\Entity\FeedItem $items
     * @return Feed
     */
    public function addItem(\Feedtags\ApplicationBundle\Entity\FeedItem $items)
    {
        $this->items[] = $items;
    
        return $this;
    }

    /**
     * Remove items
     *
     * @param \Feedtags\ApplicationBundle\Entity\FeedItem $items
     */
    public function removeItem(\Feedtags\ApplicationBundle\Entity\FeedItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
