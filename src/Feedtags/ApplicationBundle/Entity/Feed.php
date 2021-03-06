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
 * @Serializer\ExclusionPolicy("all")
 *
 * @ORM\Table(name="feeds")
 * @ORM\Entity(repositoryClass="Feedtags\ApplicationBundle\Repository\FeedRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Feed
{
    /**
     * @var integer
     *
     * @Serializer\Expose
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
     * @Serializer\Expose
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
     * @Serializer\Expose
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
     * @Serializer\Expose
     *
     * @Assert\Length(max = "255")
     * @Assert\Url
     * @Assert\NotNull
     *
     * @ORM\Column(type="string", unique=true, length=255)
     */
    protected $url;

    /**
     * Site URL
     *
     * @var string
     *
     * @Serializer\Expose
     *
     * @Assert\Length(max = "255")
     * @Assert\Url
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $siteUrl;

    /**
     * Timestamp when last modified
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $modified;

    /**
     * @var \Doctrine\Common\Collections\Collection
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
     * Set siteUrl
     *
     * @param string $siteUrl
     * @return Feed
     */
    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;

        return $this;
    }

    /**
     * Get siteUrl
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return Feed
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    
        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
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

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->modified = new \DateTime("now");
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->modified = new \DateTime("now");
    }
}
