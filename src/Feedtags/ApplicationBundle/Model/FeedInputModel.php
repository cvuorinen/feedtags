<?php

namespace Feedtags\ApplicationBundle\Model;

use JMS\Serializer\Annotation as Serialize;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class FeedInputModel
 *
 * @package Feedtags\ApplicationBundle\Model
 */
class FeedInputModel
{
    /**
     * Feed URL
     *
     * @var string
     *
     * @Serialize\Type("string")
     * @Serialize\SerializedName("url")
     *
     * @Assert\Length(max = "255")
     * @Assert\Url
     * @Assert\NotNull
     */
    protected $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
