<?php

namespace Feedtags\ApplicationBundle\Controller;

use Feedtags\ApplicationBundle\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends Controller
{
    /**
     *
     * @ApiDoc(
     *  description="This is a description of your API method"
     * )
     *
     * @Route("/test")
     * @View()
     */
    public function testAction()
    {
        return ['foo' => 'bar'];
    }

    /**
     * @Route("/create")
     */
    public function createAction()
    {
        $feed = new Feed();
        $feed->setName('Test feed');
        $feed->setDescription('Just testing new feed creation.');
        $feed->setUpdated(new \DateTime());
        $feed->setUrl('http://feed.example.com/test2');

        $em = $this->getDoctrine()->getManager();
        $em->persist($feed);
        $em->flush();

        return new Response('Created feed id '.$feed->getId());
    }
}
