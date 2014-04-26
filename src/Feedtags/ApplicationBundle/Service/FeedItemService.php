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
     * @var int
     */
    private $itemsPerPage;

    /**
     * @param FeedItemRepository $feedItemRepository
     * @param FeedLoader         $feedLoader
     * @param int                $itemsPerPage
     */
    public function __construct(FeedItemRepository $feedItemRepository, FeedLoader $feedLoader, $itemsPerPage)
    {
        $this->feedItemRepository = $feedItemRepository;
        $this->feedLoader = $feedLoader;
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * Fetch paginated FeedItem entity collection
     *
     * @param int $page
     *
     * @return FeedItem[] Array of FeedItem entities
     */
    public function getFeedItems($page = 1)
    {
        if ($page < 1) {
            $page = 1;
        }

        $offset = ($page - 1) * $this->itemsPerPage;

        return $this->feedItemRepository->fetch($this->itemsPerPage, $offset);
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
