<?php

namespace Feedtags\ApplicationBundle\Service;

use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Repository\FeedRepository;
use Feedtags\ApplicationBundle\Model\FeedInputModel;

/**
 * Class FeedService
 *
 * @package Feedtags\ApplicationBundle\Service
 */
class FeedService
{
    /**
     * @var \Feedtags\ApplicationBundle\Repository\FeedRepository
     */
    private $feedRepository;

    /**
     * @var FeedLoader
     */
    private $feedLoader;

    /**
     * @param FeedRepository $feedRepository
     */
    public function __construct(FeedRepository $feedRepository, FeedLoader $feedLoader)
    {
        $this->feedRepository = $feedRepository;
        $this->feedLoader = $feedLoader;
    }

    /**
     * Return all Feed entities
     *
     * @return array Array of Feed entities
     */
    public function fetchAll()
    {
        return $this->feedRepository->findAll();
    }

    /**
     * @param Feed $feed
     *
     * @return Feed The saved Feed
     */
    public function save(Feed $feed)
    {
        $this->feedRepository->save($feed);

        return $feed;
    }

    /**
     * Create a new feed entity from input model
     *
     * @param FeedInputModel $feedInput
     *
     * @return Feed
     */
    public function create(FeedInputModel $feedInput)
    {
        $feed = new Feed();
        $feed->setUrl($feedInput->getUrl());

        $this->feedLoader->loadFeed($feed);

        # TODO validate feed
        return $this->save($feed);
    }

    /**
     * @param Feed $feed
     */
    public function remove(Feed $feed)
    {
        $this->feedRepository->remove($feed);
    }
}
