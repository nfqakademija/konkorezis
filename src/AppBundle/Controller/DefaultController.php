<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        /* Added a comment jurij */
        return $this->render('default/index.html.twig');
    }
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashAction()
    {
        return $this->render('default/dashboard.html.twig');
    }
}

