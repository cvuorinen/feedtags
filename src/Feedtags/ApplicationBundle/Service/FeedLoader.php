<?php

namespace Feedtags\ApplicationBundle\Service;

use Feedtags\ApplicationBundle\Entity;
use Feedtags\ApplicationBundle\Service\Exception\InvalidFeedException;

/**
 * Class FeedLoaderService
 *
 * @package Feedtags\ApplicationBundle\Service
 */
class FeedLoader
{
    /**
     * @var FeedFactory
     */
    private $feedFactory;

    /**
     * @param FeedFactory $feedFactory
     */
    public function __construct(FeedFactory $feedFactory)
    {
        $this->feedFactory = $feedFactory;
    }

    /**
     * Load feed channel information for a single Feed entity
     *
     * @param Entity\Feed $feed Feed to load
     *
     * @return Entity\Feed Feed entity with updated data
     * @throws InvalidFeedException When feed import failed
     */
    public function loadFeed(Entity\Feed $feed)
    {
        $feedData = $this->importFeed($feed->getUrl());

        $feed->setName($feedData->getTitle());
        $feed->setDescription($feedData->getDescription());
        $feed->setSiteUrl($feedData->getLink());

        return $feed;
    }

    /**
     * Load feed items for the provided feed entity
     *
     * @param Entity\Feed $feed
     *
     * @return Entity\FeedItem[] Array of FeedItem entities
     * @throws InvalidFeedException When feed import failed
     */
    public function loadFeedItems(Entity\Feed $feed)
    {
        $feedData = $this->importFeed($feed->getUrl());
        $items = [];

        /** @var \Zend\Feed\Reader\Entry\EntryInterface $item */
        foreach ($feedData as $item) {
            $feedItem = new Entity\FeedItem();
            $feedItem->setTitle($item->getTitle());
            $feedItem->setContent($item->getContent());
            $feedItem->setUrl($item->getPermalink());
            $feedItem->setIdentifier($item->getId());
            $feedItem->setPublished($item->getDateCreated());

            $items[] = $feedItem;
        }

        return $items;
    }

    /**
     * @param string $feedUrl
     *
     * @return \Zend\Feed\Reader\Feed\FeedInterface
     * @throws InvalidFeedException When feed import failed
     */
    protected function importFeed($feedUrl)
    {
        return $this->feedFactory->importFeed($feedUrl);
    }
}
