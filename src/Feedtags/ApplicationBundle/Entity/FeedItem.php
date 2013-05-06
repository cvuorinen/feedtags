<?php

namespace Feedtags\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedItem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FeedItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $identifier;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $published;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="Feed", inversedBy="items")
     * @ORM\JoinColumn(name="feed_id", referencedColumnName="id")
     */
    protected $feed;


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
     * Set title
     *
     * @param string $title
     * @return FeedItem
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
     * Set content
     *
     * @param string $content
     * @return FeedItem
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return FeedItem
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
     * Set identifier
     *
     * @param string $identifier
     * @return FeedItem
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    
        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     * @return FeedItem
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set feed
     *
     * @param \Feedtags\ApplicationBundle\Entity\Feed $feed
     * @return FeedItem
     */
    public function setFeed(\Feedtags\ApplicationBundle\Entity\Feed $feed = null)
    {
        $this->feed = $feed;
    
        return $this;
    }

    /**
     * Get feed
     *
     * @return \Feedtags\ApplicationBundle\Entity\Feed 
     */
    public function getFeed()
    {
        return $this->feed;
    }
}