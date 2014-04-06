<?php
/**
 * Load some temp data to ease development and testing.
 */

namespace Feedtags\ApplicationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Entity\FeedItem;

class LoadTempData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $feed = new Feed();
        $feed->setName('Test feed');
        $feed->setDescription('Just testing feeds.');
        $feed->setUrl('http://feed.example.com/test');

        $item = new FeedItem();
        $item->setUrl('http://feed.example.com/test/item/1');
        $item->setIdentifier('item1');
        $item->setTitle('Test item 1');
        $item->setContent('Lorem ipsum, dolor sit amet...');
        $item->setPublished(new \DateTime());
        $item->setFeed($feed);

        $manager->persist($feed);
        $manager->persist($item);
        $manager->flush();


    }
}