<?php

namespace Feedtags\ApplicationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Feedtags\ApplicationBundle\Entity\Feed;

/**
 * FeedRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FeedRepository extends EntityRepository
{
    /**
     * @param string $url
     *
     * @return null|Feed
     */
    public function getByUrl($url)
    {
        return $this->findOneBy(['url' => $url]);
    }

    /**
     * Persist a Feed entity to database
     *
     * @param Feed $feed
     */
    public function save(Feed $feed)
    {
        $this->_em->persist($feed);
        $this->_em->flush($feed);
    }

    /**
     * Remove a Feed entity from database
     *
     * @param Feed $feed
     */
    public function remove(Feed $feed)
    {
        $this->_em->remove($feed);
        $this->_em->flush($feed);
    }
}
