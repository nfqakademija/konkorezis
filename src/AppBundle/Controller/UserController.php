<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# TODO: will be used in a future
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
#use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    // TODO: add requirements
    /**
     * @Route(
     *     "/user/login/{email}/{password}",
     *     name="user_login",
     *     defaults={
     *          "per_page" : 12,
     *          "page_number" : 1
     *     }
     * )
     */
    public function loginAction($email, $password)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route(
     *     "/user/logout",
     *     name="user_logout"
     * )
     */
    public function logoutAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route(
     *     "/user/history/{per_page}/{page_number}",
     *     name="user_history",
     *     defaults={
     *          "per_page" : 12,
     *          "page_number" : 1
     *     },
     *     requirements={
     *          "per_page": "\d+",
     *          "page_number": "\d+"
     *     }
     * )
     */
    public function historyAction($per_page, $page_number)
    {
        return $this->render('default/my_orders.html.twig', array('count' => $per_page));
    }

}

