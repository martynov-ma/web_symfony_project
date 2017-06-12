<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository("AppBundle:Event")->findAll();
        $places = $this->getDoctrine()->getRepository("AppBundle:Place")->findAll();

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'events' => $events,
            'places' => $places
        ]);
    }

    /**
     * @Route("/feedback", name="feedback")
     */
    public function Action(Request $request)
    {
        return $this->render('default/feedback.html.twig', array());
    }
}
