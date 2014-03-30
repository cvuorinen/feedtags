<?php

namespace Feedtags\ApplicationBundle\Service;


use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Repository\FeedRepository;

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
     * @param FeedRepository $feedRepository
     */
    public function __construct(FeedRepository $feedRepository)
    {
        $this->feedRepository = $feedRepository;
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
     * Return one Feed entity by the given id
     *
     * @param int $feedId
     *
     * @return null|Feed
     */
    private function fetchById($feedId)
    {
        return $this->feedRepository->find($feedId);
    }

    /**
     * @param Feed $feed
     *
     * @return Feed The saved Feed
     */
    public function save(Feed $feed)
    {
        $feedId = $this->feedRepository->save($feed);

        return $this->fetchById($feedId);
    }


}
