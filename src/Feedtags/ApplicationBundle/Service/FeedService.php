<?php

namespace Feedtags\ApplicationBundle\Service;

use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Repository\FeedRepository;
use Feedtags\ApplicationBundle\Model\FeedInputModel;
use Symfony\Component\Validator\Validator;

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
     * @var FeedItemService
     */
    private $feedItemService;

    /**
     * @var \Symfony\Component\Validator\Validator
     */
    private $validator;

    /**
     * @param FeedRepository  $feedRepository
     * @param FeedLoader      $feedLoader
     * @param FeedItemService $feedItemService
     */
    public function __construct(
        FeedRepository $feedRepository,
        FeedLoader $feedLoader,
        FeedItemService $feedItemService,
        Validator $validator
    ) {
        $this->feedRepository = $feedRepository;
        $this->feedLoader = $feedLoader;
        $this->feedItemService = $feedItemService;
        $this->validator = $validator;
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
    private function save(Feed $feed)
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
        # TODO check if already exists in database
        $feed = new Feed();
        $feed->setUrl($feedInput->getUrl());

        // Load feed info from the provided URL into the entity
        $this->feedLoader->loadFeed($feed);

        // Feed entity must be saved before updating items
        $this->validateFeed($feed);
        $this->save($feed);

        // Load and save feed items
        $this->feedItemService->updateFeedItems($feed);

        return $feed;
    }

    /**
     * @param Feed $feed
     */
    public function remove(Feed $feed)
    {
        $this->feedRepository->remove($feed);
    }

    /**
     * Update a single feed by fetching info and items
     *
     * @param Feed $feed Feed to update
     */
    public function updateFeed(Feed $feed)
    {
        $this->feedLoader->loadFeed($feed);

        $this->feedItemService->updateFeedItems($feed);

        $this->save($feed);
    }

    /**
     * @param Feed $feed
     *
     * @return Feed
     * @throws Exception\FeedValidationException
     */
    private function validateFeed(Feed $feed)
    {
        $violations = $this->validator->validate($feed);

        // Throw FeedValidationException with violations list
        if (count($violations)) {
            throw new Exception\FeedValidationException($violations);
        }

        return $feed;
    }
}
