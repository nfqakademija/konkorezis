<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

# TODO: will be used in a future
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
#use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    /**
     * @Route("/orders/open-orders/{per_page}/{page_number}", name="orders_open")
     */
    public function openOrdersAction($per_page, $page_number)
    {
        return $this->render('default/dashboard.html.twig',array('count' => $per_page));
    }

    /**
     * @Route("/orders/create", name="orders_create")
     */
    public function createAction()
    {
        return $this->render('default/create_order.html.twig');
    }

    /**
     * @Route("/orders/history", name="orders_history")
     */
    public function historyAction()
    {
        return $this->render('default/my_orders.html.twig');
    }
}

