<?php

namespace Feedtags\ApplicationBundle\Controller;

use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Service\FeedService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View as RestView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class FeedController
 *
 * @package Feedtags\ApplicationBundle\Controller
 *
 * @Route("/feeds", service="feedtags_application.feed.controller")
 */
class FeedController
{
    /**
     * @var \Feedtags\ApplicationBundle\Service\FeedService
     */
    private $feedService;

    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    /**
     * Return a collection of Feeds
     *
     * @ApiDoc(
     *  statusCodes={200="OK"}
     * )
     *
     * @Route("/")
     * @Method("GET")
     * @Rest\View()
     */
    public function getCollectionAction()
    {
        return $this->feedService->fetchAll();
    }

    /**
     * Return a single Feed by the given id
     *
     * @ApiDoc(
     *  resource=true,
     *  output={
     *      "class"="Feedtags\ApplicationBundle\Entity\Feed"
     *  },
     *  statusCodes={
     *      200="OK",
     *      404="Feed not found"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("feed", class="FeedtagsApplicationBundle:Feed")
     * @Method("GET")
     * @Rest\View()
     */
    public function getAction(Feed $feed = null)
    {
        if (!$feed) {
            throw new NotFoundHttpException('Feed not found.');
        }

        return $feed;
    }

    /**
     * Create a new Feed
     *
     * @ApiDoc(
     *  input="Feedtags\ApplicationBundle\Entity\Feed",
     *  output="Feedtags\ApplicationBundle\Entity\Feed",
     *  statusCodes={
     *      201="Created",
     *      400="Validation errors"
     *  }
     * )
     *
     * @Route("/")
     * @ParamConverter("feed", converter="fos_rest.request_body")
     * @Method("POST")
     * @Rest\View(statusCode=201)
     */
    public function createAction(Feed $feed, ConstraintViolationListInterface $validationErrors)
    {
        // Handle validation errors
        if (count($validationErrors) > 0) {
            return RestView::create(
                ['errors' => $validationErrors],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->feedService->save($feed);
    }

    /**
     * Remove a Feed
     *
     * @ApiDoc(
     *  statusCodes={
     *      204="OK",
     *      404="Feed not found"
     *  }
     * )
     *
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @ParamConverter("feed", class="FeedtagsApplicationBundle:Feed")
     * @Method("DELETE")
     * @Rest\View(statusCode=204)
     */
    public function removeAction(Feed $feed = null)
    {
        if (!$feed) {
            throw new NotFoundHttpException('Feed not found.');
        }

        $this->feedService->remove($feed);

        return [];
    }
}
