<?php

namespace Feedtags\ApplicationBundle\Controller;

use Feedtags\ApplicationBundle\Entity\FeedItem;
use Feedtags\ApplicationBundle\Service\FeedItemService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View as RestView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class FeedItemController
 *
 * @package Feedtags\ApplicationBundle\Controller
 *
 * @Route("/feeds/items", service="feedtags_application.feed_item.controller")
 */
class FeedItemController
{
    /**
     * @var \Feedtags\ApplicationBundle\Service\FeedItemService
     */
    private $feedItemService;

    public function __construct(FeedItemService $feedItemService)
    {
        $this->feedItemService = $feedItemService;
    }

    /**
     * Return a collection of FeedItems
     *
     * @ApiDoc(
     *  statusCodes={200="OK"}
     * )
     *
     * @Rest\QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  default="1",
     *  description="Page of the collection."
     * )
     *
     *
     * @Route("/")
     * @Method("GET")
     * @Rest\View()
     */
    public function getCollectionAction(ParamFetcherInterface $paramFetcher)
    {
        $page = $paramFetcher->get('page');

        $limit = 5;
        $offset = ($page - 1) * $limit;

        return $this->feedItemService->fetchAll($limit, $offset);
    }



    /**
     * Return a single FeedItem by the given id
     *
     * @ApiDoc(
     *  resource=true,
     *  output={
     *      "class"="Feedtags\ApplicationBundle\Entity\FeedItem"
     *  },
     *  statusCodes={
     *      200="OK",
     *      404="FeedItem not found"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("feed", class="FeedtagsApplicationBundle:FeedItem")
     * @Method("GET")
     * @Rest\View()
     */
    public function getAction(FeedItem $feedItem = null)
    {
        if (!$feedItem) {
            throw new NotFoundHttpException('Feed item not found.');
        }

        return $feedItem;
    }
}
