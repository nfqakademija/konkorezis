<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# TODO: will be used in a future
#use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
#use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        /* Added a comment */
        return $this->render('default/index.html.twig');
    }
    /**
     * @Route("/dashboard/{count}", name="dashboard")
     */
    public function dashAction($count)
    {
        return $this->render('default/dashboard.html.twig',array('count' => $count));
    }
    /**
     * @Route("/create", name="create")
     */
    public function createAction()
    {
        return $this->render('default/create_order.html.twig');
    }
    /**
     * @Route("/myorders", name="myorders")
     */
    public function myordersAction()
    {
        return $this->render('default/myorders.html.twig');
    }

}

