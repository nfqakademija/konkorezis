<?php

namespace AppBundle\Controller;

use AppBundle\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        // Retrieve orders for a specific page
        $orders = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->getOpenOrdersForPage($per_page, $page_number);

        return $this->render('default/open_orders.html.twig', array(
            'orders'        => $orders,
            'per_page'      => $per_page,
            'page_number'   => $page_number
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
     *     "/orders/create_product",
     *     name="orders_create_product"
     * )
     */
    public function createProductAction()
    {
        return $this->render('default/create_product.html.twig');
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
        // Retrieve orders' details information for a details page
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->find($order_id);

        if (!$order) {
            // Create flash message for no order found
            $this->addFlash(
                'error',
                'No order found for id: ' . $order_id . '!'
            );

            // Redirect to orders_open screen
            return new RedirectResponse($this->generateUrl('orders_open'));
        }

        // Get time remaining to join order
        $closing_after = Utilities::countTimeRemaining(
            date_timestamp_get($order->getJoiningDeadline()));

        $products = $order->getProducts();

        return $this->render('default/details.html.twig', array(
            'products'          => $products,
            'closing_after'     => $closing_after,
            'order'             => $order,
            'order_id'          => $order_id
        ));
    }

    /**
     * Shown for host only
     *
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
        // TODO: check whether user can view summary (is it users' order)

        // TODO: render summary view
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route(
     *     "/orders/delete/{order_id}",
     *     name="order_delete",
     *     requirements={
     *          "order_id": "\d+",
     *     }
     * )
     */
    public function deleteAction($order_id)
    {
        // TODO: check whether user can delete order (is it users' order)

        // TODO: remove users' order

        // Create flash message for successful removal
        $this->addFlash(
            'notice',
            'Order successfully deleted!'
        );

        // Redirect to users_orders screen to refresh list
        return new RedirectResponse($this->generateUrl('orders_open'));
    }
}

