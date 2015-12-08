<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use AppBundle\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class OrdersController extends Controller
{
    /**
     * @Route(
     *     "/orders/open-orders/{per_page}/{page_number}",
     *     name="orders_open",
     *     defaults={
     *          "per_page":     12,
     *          "page_number":  1
     *     },
     *     requirements={
     *          "per_page":     "\d+",
     *          "page_number":  "\d+"
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
        $request = Request::createFromGlobals();

        if($request->isMethod('POST')){
            // TODO: validate form data
            $order = new Orders();
            $user = $this->getUser();
            $order_name = $request->request->get('order_name');
            $supplier_name = $request->request->get('supplier_name');
            $supplier_link = $request->request->get('supplier_link');
            $description = $request->request->get('description');
            $order_date_time = $request->request->get('order_date_time');
            $joining_date_time = $request->request->get('joining_date_time');
            $event_address = $request->request->get('event_address');

            $order->setUser($user);

            $order->setName($order_name);
            $order->setSupplierName($supplier_name);
            $order->setSupplierMenuLink($supplier_link);
            $order->setDescription($description);
            $order->setAddress($event_address);
            $order->setEventDate(date_create($order_date_time));
            $order->setJoiningDeadline(date_create($joining_date_time));

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $this->addFlash(
                'notice',
                'Order successfully created!'
            );

            return new RedirectResponse($this->generateUrl('orders_details',array('order_id' => $order->getId())));

        }

        return $this->render('default/create_order.html.twig');
    }

    /**
     * @Route(
     *     "/orders/details/{order_id}",
     *     name="orders_details",
     *     requirements={
     *          "order_id":     "\d+",
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

        $user = $this->getUser();

        $products = $order->getProducts();

        $user_product_qty = array();

        foreach($products as $pkey => $product){
            $userProduct = $this->getDoctrine()
                ->getRepository('AppBundle:UserProduct')
                ->findOneBy(array(
                    'user'      => $user,
                    'product'   => $product
                ));

            if (!$userProduct) {
                $user_product_qty[$pkey] = 0;
            } else {
                $user_product_qty[$pkey] = $userProduct->getQuantity();
            }
        }

        return $this->render('default/details.html.twig', array(
            'products'          => $products,
            'closing_after'     => $closing_after,
            'order'             => $order,
            'order_id'          => $order_id,
            'user_product_qty'  => $user_product_qty
        ));
    }

    /**
     * Shown for host only
     *
     * @Route(
     *     "/orders/summary/{order_id}",
     *     name="orders_summary",
     *     requirements={
     *          "order_id":     "\d+",
     *     }
     * )
     */
    public function summaryAction($order_id)
    {
        $user = $this->getUser();

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
            return new RedirectResponse($this->generateUrl('user_history'));
        }

        if($order->getUserId() !== $user->getId()){
            //throw $this->createAccessDeniedException();
            // Create flash message if user not order creator
            $this->addFlash(
                'error',
                'You are not creator of order: ' . $order->getName() . '!'
            );

            // Redirect to user_history screen
            return new RedirectResponse($this->generateUrl('user_history'));
        }

        // Get time remaining to join order
        $closing_after = Utilities::countTimeRemaining(
            date_timestamp_get($order->getJoiningDeadline()));

        $products = $order->getProducts();

        $user_product_qty = array();

        $order_sum = 0;

        foreach($products as $pkey => $product){
            $userProducts = $product->getUserProducts();

            $qty_sum = 0;
            foreach($userProducts as $up){
                $qty_sum += $up->getQuantity();
            }
            $user_product_qty[$pkey] = array('qty' => $qty_sum, 'overall' => $qty_sum * $product->getPrice());
            $order_sum += $user_product_qty[$pkey]['overall'];
        }

        $user_product_qty['order_sum'] = $order_sum;

        return $this->render('default/summary.html.twig', array(
            'products'          => $products,
            'closing_after'     => $closing_after,
            'order'             => $order,
            'order_id'          => $order_id,
            'user_product_qty'  => $user_product_qty
        ));
    }

    /**
     * Shown for host only
     *
     * @Route(
     *     "/orders/account/{order_id}",
     *     name="orders_account",
     *     requirements={
     *          "order_id":     "\d+",
     *     }
     * )
     */
    public function accountAction($order_id)
    {
        $user = $this->getUser();

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
            return new RedirectResponse($this->generateUrl('user_history'));
        }

        if($order->getUserId() !== $user->getId()){
            //throw $this->createAccessDeniedException();
            // Create flash message if user not order creator
            $this->addFlash(
                'error',
                'You are not creator of order: ' . $order->getName() . '!'
            );

            // Redirect to user_history screen
            return new RedirectResponse($this->generateUrl('user_history'));
        }

        $products = $order->getProducts();

        $participants = array();
        $participants['order_sum'] = 0;

        foreach($products as $pkey => $product){
            $userProducts = $product->getUserProducts();

            foreach($userProducts as $up){
                $participant = $up->getUser();
                if(isset($participants[$participant->getId()])){
                    $participants[$participant->getId()][] = array(
                        'product' => $product->getTitle(),
                        'price' => $product->getPrice(),
                        'qty' => $up->getQuantity(),
                        'overall' => $product->getPrice()*$up->getQuantity()
                    );
                    $participants[$participant->getId()]['overall_sum'] += $product->getPrice()*$up->getQuantity();
                    $participants['order_sum'] += $product->getPrice()*$up->getQuantity();
                } else {
                    $participants[$participant->getId()] =
                        array(array(
                            'product' => $product->getTitle(),
                            'price' => $product->getPrice(),
                            'qty' => $up->getQuantity(),
                            'overall' => $product->getPrice()*$up->getQuantity()
                        ));
                    $participants[$participant->getId()]['email'] = $participant->getEmail();
                    $participants[$participant->getId()]['overall_sum'] = $participants[$participant->getId()][0]['overall'];
                    $participants['order_sum'] += $participants[$participant->getId()][0]['overall'];
                }
            }
        }

        return $this->render('default/account.html.twig', array(
            'products'          => $products,
            'order'             => $order,
            'order_id'          => $order_id,
            'participants'      => $participants
        ));

    }

    /**
     * @Route(
     *     "/orders/delete/{order_id}",
     *     name="order_delete",
     *     requirements={
     *          "order_id":     "\d+",
     *     }
     * )
     */
    public function deleteAction($order_id)
    {
        $user = $this->getUser();

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
            return new RedirectResponse($this->generateUrl('user_history'));
        }

        if($order->getUserId() !== $user->getId()){
            //throw $this->createAccessDeniedException();
            // Create flash message if user not order creator
            $this->addFlash(
                'error',
                'You are not creator of order: ' . $order->getName() . '!'
            );

            // Redirect to user_history screen
            return new RedirectResponse($this->generateUrl('user_history'));
        }

        // Get time remaining to join order
        $closing_after = Utilities::countTimeRemaining(
            date_timestamp_get($order->getJoiningDeadline()));

        if ($closing_after == Utilities::$STATUS_JOINING_TIME_IS_OVER) {
            $this->addFlash(
                'error',
                'You cannot remove orders from the past. Remove is allowed for open orders!'
            );

            // Redirect to user_history screen
            return new RedirectResponse($this->generateUrl('user_history'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($order);

//        $order = new Orders();
//        $products = new Product();
        $products = $order->getProducts();

        if ($products) {
            foreach ($products as $product) {
                $em->remove($product);

                $userProducts = $product->getUserProducts();
                foreach ($userProducts as $userProduct) {
                    $em->remove($userProduct);
                }
            }


        }

        $em->flush();

        // Create flash message for successful removal
        $this->addFlash(
            'notice',
            'Order successfully deleted!'
        );

        // Redirect to users_orders screen to refresh list
        return new RedirectResponse($this->generateUrl('user_history'));
    }


}

