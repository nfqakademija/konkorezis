<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# TODO: will be used in a future
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
#use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

}

