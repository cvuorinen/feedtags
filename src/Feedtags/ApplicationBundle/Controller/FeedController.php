<?php

namespace Feedtags\ApplicationBundle\Controller;

use Feedtags\ApplicationBundle\Entity\Feed;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class FeedController
 *
 * @package Feedtags\ApplicationBundle\Controller
 *
 * @Route("/feed", service="feedtags_application.feed.controller")
 */
class FeedController
{
    /**
     * Return representation of a Feed by the given id
     *
     * @ApiDoc(
     *  resource=true,
     *  output={
     *      "class"="Feedtags\ApplicationBundle\Entity\Feed"
     *  },
     *  statusCodes={
     *      200="OK",
     *      404="Feed not found for the given id"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("feed", class="FeedtagsApplicationBundle:Feed")
     * @Method("GET")
     * @RestView()
     */
    public function getAction(Feed $feed = null)
    {
        if (!$feed) {
            throw new NotFoundHttpException('Feed not found for the given id.');
        }

        return $feed;
    }
}
