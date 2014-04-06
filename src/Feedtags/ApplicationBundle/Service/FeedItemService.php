<?php

namespace Feedtags\ApplicationBundle\Service;


use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Repository\FeedItemRepository;

/**
 * Class FeedItemService
 *
 * @package Feedtags\ApplicationBundle\Service
 */
class FeedItemService
{
    /**
     * @var \Feedtags\ApplicationBundle\Repository\FeedRepository
     */
    private $feedItemRepository;

    /**
     * @param FeedItemRepository $feedItemRepository
     */
    public function __construct(FeedItemRepository $feedItemRepository)
    {
        $this->feedItemRepository = $feedItemRepository;
    }

    /**
     * Return all FeedItem entities
     *
     * @return array Array of Feed entities
     */
    public function fetchAll()
    {
        return $this->feedItemRepository->findAll();
    }

    /**
     * Return one FeedItem entity by the given id
     *
     * @param int $feedItemId
     *
     * @return null|Feed
     */
    private function fetchById($feedItemId)
    {
        return $this->feedItemRepository->find($feedItemId);
    }
}
