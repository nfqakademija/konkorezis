<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
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
        $user = $this->getUser();

        // Retrieve orders that user has created before
        $created_orders = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->getUsersCreatedOrdersForPage($per_page, $page_number, $user);

        // Retrieve orders that user has took in part as a guest
        $joined_orders = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->getUsersJoinedOrdersForPage($per_page, $page_number, $user);

        return $this->render('default/my_orders.html.twig', array(
            'created_orders'      => $created_orders,
            'joined_orders'      => $joined_orders,
            'per_page'      => $per_page,
            'page_number'   => $page_number
        ));
    }
}

