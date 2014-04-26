<?php

namespace Feedtags\ApplicationBundle\Tests\Unit\Service;

use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Entity\FeedItem;
use Feedtags\ApplicationBundle\Repository\FeedItemRepository;
use Feedtags\ApplicationBundle\Service\FeedItemService;
use Feedtags\ApplicationBundle\Service\FeedLoader;
use Feedtags\ApplicationBundle\Tests\ProphecyTestTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class FeedItemServiceTest
 *
 * @package Feedtags\ApplicationBundle\Tests\Unit\Service
 */
class FeedItemServiceTest extends \PHPUnit_Framework_TestCase
{
    use ProphecyTestTrait;

    /**
     * @var FeedItemService
     */
    private $service;

    /**
     * @var ObjectProphecy
     */
    private $feedItemRepository;

    /**
     * @var ObjectProphecy
     */
    private $feedLoader;

    /**
     * @var int
     */
    private $itemsPerPage = 5;

    public function up()
    {
        $this->feedItemRepository = $this->prophesize(FeedItemRepository::class);
        $this->feedLoader = $this->prophesize(FeedLoader::class);

        $this->service = new FeedItemService(
            $this->feedItemRepository->reveal(),
            $this->feedLoader->reveal(),
            $this->itemsPerPage
        );
    }

    public function testGetFeedItemsLimitsFetchByItemsPerPage()
    {
        $this->feedItemRepository->fetch($this->itemsPerPage, 0)->shouldBeCalled();

        $this->service->getFeedItems(1);
    }

    public function testGetFeedItemsSetsCorrectOffset()
    {
        $page = 2;
        $expectedOffset = $this->itemsPerPage;

        $this->feedItemRepository->fetch($this->itemsPerPage, $expectedOffset)->shouldBeCalled();

        $this->service->getFeedItems($page);
    }

    public function testGetFeedItemsSetsPageOneOnInvalidPageNum()
    {
        $this->feedItemRepository->fetch($this->itemsPerPage, 0)->shouldBeCalled();

        $this->service->getFeedItems(-1);
    }

    public function testSaveCallsRepositorySave()
    {
        $feedItem = new FeedItem();

        $this->feedItemRepository->save($feedItem)->shouldBeCalled();

        $this->service->save($feedItem);
    }

    public function testUpdateFeedItemsSavesNewItems()
    {
        $feed = new Feed();

        $newItems = [
            new FeedItem(),
            new FeedItem(),
        ];

        $this->feedLoader->loadFeedItems($feed)->willReturn($newItems);

        $this->service->updateFeedItems($feed);

        $this->feedItemRepository->saveMultiple($newItems)->shouldHaveBeenCalled();
    }

    public function testUpdateFeedItemsSkipsExistingItems()
    {
        $feed = new Feed();

        $newItems = [
            (new FeedItem())->setUrl('foo'),
            (new FeedItem())->setUrl('bar'),
        ];

        $this->feedLoader->loadFeedItems($feed)->willReturn($newItems);

        $this->feedItemRepository->getByUrl('foo')->willReturn($newItems[0]);
        $this->feedItemRepository->getByUrl('bar')->willReturn(null);

        $this->feedItemRepository->saveMultiple([$newItems[1]])->shouldBeCalled();

        $this->service->updateFeedItems($feed);
    }

    public function testUpdateFeedItemsAddsNewItemsToFeed()
    {
        $feed = $this->prophesize(Feed::class);

        $newItems = [
            new FeedItem(),
            new FeedItem(),
        ];

        $this->feedLoader->loadFeedItems($feed->reveal())->willReturn($newItems);

        $this->service->updateFeedItems($feed->reveal());

        $feed->addItem($newItems[0])->shouldHaveBeenCalled();
        $feed->addItem($newItems[1])->shouldHaveBeenCalled();
    }
}
