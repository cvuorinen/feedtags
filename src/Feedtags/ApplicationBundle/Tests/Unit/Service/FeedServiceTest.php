<?php

namespace Feedtags\ApplicationBundle\Tests\Unit\Service;

use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Model\FeedInputModel;
use Feedtags\ApplicationBundle\Repository\FeedRepository;
use Feedtags\ApplicationBundle\Service\FeedItemService;
use Feedtags\ApplicationBundle\Service\FeedLoader;
use Feedtags\ApplicationBundle\Service\FeedService;
use Feedtags\ApplicationBundle\Tests\ProphecyTestTrait;
use Prophecy\Argument;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator;

/**
 * Class FeedServiceTest
 * @package Feedtags\ApplicationBundle\Tests\Unit\Service
 */
class FeedServiceTest extends \PHPUnit_Framework_TestCase
{
    use ProphecyTestTrait;

    /**
     * @var FeedService
     */
    private $service;

    /**
     * @var ObjectProphecy
     */
    private $feedRepository;

    /**
     * @var ObjectProphecy
     */
    private $feedLoader;

    /**
     * @var ObjectProphecy
     */
    private $feedItemService;

    /**
     * @var ObjectProphecy
     */
    private $validator;

    /**
     * @var string
     */
    private $feedUrl = 'foo';

    public function up()
    {
        $this->feedRepository = $this->prophesize(FeedRepository::class);
        $this->feedLoader = $this->prophesize(FeedLoader::class);
        $this->feedItemService = $this->prophesize(FeedItemService::class);
        $this->validator = $this->prophesize(Validator::class);

        $this->service = new FeedService(
            $this->feedRepository->reveal(),
            $this->feedLoader->reveal(),
            $this->feedItemService->reveal(),
            $this->validator->reveal()
        );
    }

    public function testFetchAll()
    {
        $feeds = [
            new Feed(),
            new Feed(),
        ];

        $this->feedRepository->findAll()->willReturn($feeds);

        $this->assertEquals(
            $feeds,
            $this->service->fetchAll()
        );
    }

    public function testCreateSavesNewFeed()
    {
        $feedInput = $this->aFeedInputModel();
        $feed = $this->aFeed();

        $this->service->create($feedInput);

        $this->feedRepository->save($feed)->shouldHaveBeenCalled();
    }

    public function testCreateDoesNotSaveExistingFeed()
    {
        $feedInput = $this->aFeedInputModel();
        $feed = $this->aFeed();

        $this->feedRepository->getByUrl($this->feedUrl)->willReturn($feed);

        $this->feedRepository->save()->shouldNotBeCalled();

        $this->service->create($feedInput);
    }

    public function testCreateValidatesNewFeed()
    {
        $feedInput = $this->aFeedInputModel();
        $feed = $this->aFeed();

        $this->service->create($feedInput);

        $this->validator->validate($feed)->shouldHaveBeenCalled();
    }

    /**
     * @expectedException \Feedtags\ApplicationBundle\Service\Exception\FeedValidationException
     */
    public function testCreateThrowsExceptionOnInvalidFeed()
    {
        $feedInput = $this->aFeedInputModel();
        $feed = $this->aFeed();

        $violation = new ConstraintViolation('foo', 'bar', [], $this->feedUrl, 'baz', $this->feedUrl);
        $violations = new ConstraintViolationList([$violation]);

        $this->validator->validate($feed)->willReturn($violations);

        $this->service->create($feedInput);
    }

    public function testCreateLoadsFeed()
    {
        $feedInput = $this->aFeedInputModel();
        $feed = $this->aFeed();

        $this->service->create($feedInput);

        $this->feedLoader->loadFeed($feed)->shouldHaveBeenCalled();
    }

    public function testCreateUpdatesFeedItems()
    {
        $feedInput = $this->aFeedInputModel();
        $feed = $this->aFeed();

        $this->service->create($feedInput);

        $this->feedItemService->updateFeedItems($feed)->shouldHaveBeenCalled();
    }

    public function testRemoveCallsRepositoryRemove()
    {
        $feed = $this->aFeed();

        $this->feedRepository->remove($feed)->shouldBeCalled();

        $this->service->remove($feed);
    }

    public function testUpdateFeedLoadsFeed()
    {
        $feed = $this->aFeed();

        $this->service->updateFeed($feed);

        $this->feedLoader->loadFeed($feed)->shouldHaveBeenCalled();
    }

    public function testUpdateFeedUpdatesFeedItems()
    {
        $feed = $this->aFeed();

        $this->service->updateFeed($feed);

        $this->feedItemService->updateFeedItems($feed)->shouldHaveBeenCalled();
    }

    public function testUpdateAllFeedsFetchesAllFeeds()
    {
        $this->feedRepository->findAll()->willReturn([])->shouldBeCalled();

        $this->service->updateAllFeeds();
    }

    public function testUpdateAllFeedsSavesEachFeed()
    {
        $feeds = $this->aFewFeeds();

        $this->feedRepository->findAll()->willReturn($feeds);

        foreach ($feeds as $feed) {
            $this->feedRepository->save($feed)->shouldBeCalled();
        }

        $this->service->updateAllFeeds();
    }

    public function testUpdateAllFeedsLoadsEachFeed()
    {
        $feeds = $this->aFewFeeds();

        $this->feedRepository->findAll()->willReturn($feeds);
        $this->feedRepository->save(Argument::any())->shouldBeCalled();

        $this->feedLoader->loadFeed(Argument::any())->shouldBeCalledTimes(count($feeds));

        $this->service->updateAllFeeds();
    }

    public function testUpdateAllFeedsUpdatesItemsOnEachFeed()
    {
        $feeds = $this->aFewFeeds();

        $this->feedRepository->findAll()->willReturn($feeds);
        $this->feedRepository->save(Argument::any())->shouldBeCalled();

        $this->feedItemService->updateFeedItems(Argument::any())->shouldBeCalledTimes(count($feeds));

        $this->service->updateAllFeeds();
    }

    /**
     * @return FeedInputModel
     */
    private function aFeedInputModel()
    {
        return new FeedInputModel($this->feedUrl);
    }

    /**
     * @return Feed
     */
    private function aFeed()
    {
        $feed = new Feed();
        $feed->setUrl($this->feedUrl);

        return $feed;
    }

    /**
     * @return array
     */
    private function aFewFeeds()
    {
        $feeds = [
            $this->aFeed(),
            $this->aFeed(),
        ];

        return $feeds;
    }
}
