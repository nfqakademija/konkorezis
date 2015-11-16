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
     * @Route(
     *     "/orders/open-orders/{per_page}/{page_number}",
     *     name="orders_open",
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
    public function openOrdersAction($per_page, $page_number)
    {
        return $this->render('default/open_orders.html.twig', array(
            'per_page' => $per_page,
            'page_number' => $page_number
            ));
    }

    /**
     * @Route(
     *     "/orders/create",
     *     name="orders_create"
     * )
     */
    public function createAction()
    {
        return $this->render('default/create_order.html.twig');
    }

    /**
     * @Route(
     *     "/orders/details/{order_id}",
     *     name="orders_details",
     *     requirements={
     *          "order_id": "\d+",
     *     }
     * )
     */
    public function detailsAction($order_id)
    {
        return $this->render('default/details.html.twig', array(
            'order_id' => $order_id
        ));
    }

    /** Shown for host
     * @Route(
     *     "/orders/summary/{order_id}",
     *     name="orders_summary",
     *     requirements={
     *          "order_id": "\d+",
     *     }
     * )
     */
    public function summaryAction($order_id)
    {
        return $this->render('default/index.html.twig');
    }
}

