<?php

namespace Feedtags\ApplicationBundle\Service;

use Feedtags\ApplicationBundle\Service\Exception\InvalidFeedException;
use Zend\Feed\Reader\Reader as FeedReader;

/**
 * Class FeedFactory
 *
 * Just a wrapper for Zend\Feed\Reader\Reader::import
 *
 * @package Feedtags\ApplicationBundle\Service
 */
class FeedFactory
{
    /**
     * @param $feedUrl
     *
     * @return \Zend\Feed\Reader\Feed\FeedInterface
     * @throws InvalidFeedException When feed import failed
     */
    public function importFeed($feedUrl)
    {
        try {
            $feed = FeedReader::import($feedUrl);
        } catch (\Exception $e) {
            # TODO log exception
            throw new InvalidFeedException("Error loading feed. Check feed URL");
        }

        return $feed;
    }
}
