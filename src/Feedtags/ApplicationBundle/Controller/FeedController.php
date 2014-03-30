<?php

namespace Feedtags\ApplicationBundle\Controller;

use Feedtags\ApplicationBundle\Entity\Feed;
use Feedtags\ApplicationBundle\Service\FeedService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
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
     * Return a collection with all Feeds
     *
     * @ApiDoc(
     *  statusCodes={200="OK"}
     * )
     *
     * @Route("/")
     * @Method("GET")
     * @RestView()
     */
    public function listAction()
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
     * @RestView(statusCode=201)
     */
    public function createAction(Feed $feed, ConstraintViolationListInterface $validationErrors)
    {
        // Handle validation errors
        if (count($validationErrors) > 0) {
            return View::create()->setStatusCode(Codes::HTTP_BAD_REQUEST)
                ->setData($validationErrors);

        }

        return $this->feedService->save($feed);
    }
}
