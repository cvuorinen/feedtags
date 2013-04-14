<?php

namespace Feedtags\ApplicationBundle\Controller;

use Feedtags\ApplicationBundle\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FeedtagsApplicationBundle:Default:index.html.twig', array('name' => $name));
    }

    public function createAction()
    {
        $feed = new Feed();
        $feed->setName('Test feed');
        $feed->setDescription('Just testing new feed creation.');
        $feed->setUpdated(new \DateTime());
        $feed->setUrl('http://feed.example.com/test');

        $em = $this->getDoctrine()->getManager();
        $em->persist($feed);
        $em->flush();

        return new Response('Created feed id '.$feed->getId());
    }
}
