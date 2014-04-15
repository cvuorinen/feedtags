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
     * @param int|null   $limit
     * @param int|null   $offset
     * @param array|null $sortBy
     *
     * @return FeedItem[] Array of FeedItem entities
     */
    public function fetchAll($limit = null, $offset = null, $sortBy = null)
    {
        return $this->feedItemRepository->fetch($limit, $offset, $sortBy);
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
        $newItems = [];
        $feedItems = $this->feedLoader->loadFeedItems($feed);

        foreach ($feedItems as $item) {
            // Skip if already exists (maybe should update?)
            if (!empty($this->feedItemRepository->getByUrl($item->getUrl()))) {
                continue;
            }

            $feed->addItem($item);
            $item->setFeed($feed);

            $newItems[] = $item;
        }

        $this->feedItemRepository->saveMultiple($newItems);
    }
}
