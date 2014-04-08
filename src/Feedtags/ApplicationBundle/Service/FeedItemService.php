<?php

namespace Feedtags\ApplicationBundle\Service;

use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Entity\FeedItem;
use Feedtags\ApplicationBundle\Repository\FeedItemRepository;

/**
 * Class FeedItemService
 *
 * @package Feedtags\ApplicationBundle\Service
 */
class FeedItemService
{
    /**
     * @var \Feedtags\ApplicationBundle\Repository\FeedItemRepository
     */
    private $feedItemRepository;

    /**
     * @var FeedLoader
     */
    private $feedLoader;

    /**
     * @param FeedItemRepository $feedItemRepository
     * @param FeedLoader         $feedLoader
     */
    public function __construct(FeedItemRepository $feedItemRepository, FeedLoader $feedLoader)
    {
        $this->feedItemRepository = $feedItemRepository;
        $this->feedLoader = $feedLoader;
    }

    /**
     * Return all FeedItem entities
     *
     * @return FeedItem[] Array of FeedItem entities
     */
    public function fetchAll()
    {
        return $this->feedItemRepository->findAll();
    }

    /**
     * @param FeedItem $feedItem
     *
     * @return FeedItem The saved FeedItem
     */
    public function save(FeedItem $feedItem)
    {
        $this->feedItemRepository->save($feedItem);

        return $feedItem;
    }

    /**
     * Update feed items for a single feed
     *
     * @param Feed $feed
     */
    public function updateFeedItems(Feed $feed)
    {
        $items = $this->feedLoader->loadFeedItems($feed);

        foreach ($items as $item) {
            # TODO check if already exists
            $feed->addItem($item);
            $item->setFeed($feed);

            #$this->save($item);
        }

        $this->feedItemRepository->saveMultiple($items);
    }
}
