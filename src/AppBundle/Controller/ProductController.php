<?php

namespace AppBundle\Controller;

use AppBundle\AjaxResponses;
use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use AppBundle\Entity\UserProduct;
use AppBundle\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProductController extends Controller
{
    /**
     * @Route(
     *     "/product/create",
     *     name="create_product"
     * )
     * @Method("POST")
     */
    public function createProductAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $request = Request::createFromGlobals();

            $order_id = intval($request->request->get('order_id', 0));
            $title = strval($request->request->get('title'));
            $price = floatval($request->request->get('price'));
            $link = strval($request->request->get('link'));
            $quantity = intval($request->request->get('quantity'));

            if ($order_id > 0 && $price > 0 && $quantity > 0 && $title != '') {
                // Check whether order with such ID exist
                $order = $this->getDoctrine()
                    ->getRepository('AppBundle:Orders')
                    ->find($order_id);

                if ($order) {
                    // Check whether order is still open to join / change quantities
                    $closing_after = Utilities::countTimeRemaining(
                        date_timestamp_get($order->getJoiningDeadline()));

                    if ($closing_after != Utilities::$STATUS_JOINING_TIME_IS_OVER) {
                        $user = $this->getUser();

                        $product = new Product();
                        $product->setTitle($title);
                        $product->setPrice($price);
                        $product->setLink($link);
                        $product->setOrders($order);

                        $userProduct = new UserProduct();
                        $userProduct->setProduct($product);
                        $userProduct->setQuantity($quantity);
                        $userProduct->setUser($user);
                        $product->addUserProduct($userProduct);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($userProduct);
                        $em->persist($product);
                        $em->flush();

                        return $this->render('default/product.html.twig', array(
                            'order'         => $order,
                            'product'       => $product,
                            'quantity'      => $quantity
                        ));
                    } else {
                        return new Response(AjaxResponses::$ORDER_JOINING_TIME_IS_OVER, Response::HTTP_NOT_FOUND);
                    }
                } else {
                    return new Response(AjaxResponses::$ORDER_NOT_FOUND, Response::HTTP_NOT_FOUND);
                }
            } else {
                return new Response(AjaxResponses::$WRONG_REQUEST_PARAMETERS, Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new Response(AjaxResponses::$UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @Route(
     *     "/product/increase_quantity",
     *     name="increase_product_quantity"
     * )
     * @Method("POST")
     */
    public function increaseQuantityAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $request = Request::createFromGlobals();
            $order_id = intval($request->request->get('order_id', 0));
            $product_id = intval($request->request->get('product_id', 0));

            if ($order_id > 0 && $product_id > 0) {
                // Retrieve orders' details information for a details page
                $order = $this->getDoctrine()
                    ->getRepository('AppBundle:Orders')
                    ->find($order_id);

                if ($order) {
                    // Check whether order is still open to join / change quantities
                    $closing_after = Utilities::countTimeRemaining(
                        date_timestamp_get($order->getJoiningDeadline()));

                    if ($closing_after != Utilities::$STATUS_JOINING_TIME_IS_OVER) {
                        $product = $this->getDoctrine()
                            ->getRepository('AppBundle:Product')
                            ->find($product_id);

                        if ($product && $order->getProducts()->contains($product)) {
                            $user = $this->getUser();
                            $userProduct = $this->getDoctrine()
                                ->getRepository('AppBundle:UserProduct')
                                ->findOneBy(array(
                                    'user'      => $user,
                                    'product'   => $product
                                ));

                            // Create new UserProduct record in DB, if such doesn't exist
                            $quantity = 1;
                            $em = $this->getDoctrine()->getManager();

                            if (!$userProduct) {
                                $userProduct = new UserProduct();
                                $userProduct->setUser($user);
                                $userProduct->setProduct($product);
                                $userProduct->setQuantity($quantity);

                                $em->persist($userProduct);
                            } else {
                                $quantity = $userProduct->getQuantity();
                                $quantity++;
                                $userProduct->setQuantity($quantity);
                            }
                            $em->flush();

                            return new Response($quantity, Response::HTTP_OK);
                        } else {
                            return new Response(AjaxResponses::$PRODUCT_NOT_FOUND, Response::HTTP_NOT_FOUND);
                        }
                    } else {
                        return new Response(AjaxResponses::$ORDER_JOINING_TIME_IS_OVER, Response::HTTP_NOT_FOUND);
                    }
                } else {
                    return new Response(AjaxResponses::$ORDER_NOT_FOUND, Response::HTTP_NOT_FOUND);
                }
            } else {
                return new Response(AjaxResponses::$WRONG_REQUEST_PARAMETERS, Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new Response(AjaxResponses::$UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @Route(
     *     "/product/decrease_quantity",
     *     name="decrease_product_quantity"
     * )
     * @Method("POST")
     */
    public function decreaseQuantityAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $request = Request::createFromGlobals();
            $order_id = intval($request->request->get('order_id', 0));
            $product_id = intval($request->request->get('product_id', 0));

            if ($order_id > 0 && $product_id > 0) {
                // Retrieve orders' details information for a details page
                $order = $this->getDoctrine()
                    ->getRepository('AppBundle:Orders')
                    ->find($order_id);

                if ($order) {
                    // Check whether order is still open to join / change quantities
                    $closing_after = Utilities::countTimeRemaining(
                        date_timestamp_get($order->getJoiningDeadline()));

                    if ($closing_after != Utilities::$STATUS_JOINING_TIME_IS_OVER) {
                        $product = $this->getDoctrine()
                            ->getRepository('AppBundle:Product')
                            ->find($product_id);

                        if ($product && $order->getProducts()->contains($product)) {
                            $user = $this->getUser();
                            $userProduct = $this->getDoctrine()
                                ->getRepository('AppBundle:UserProduct')
                                ->findOneBy(array(
                                    'user'      => $user,
                                    'product'   => $product
                                ));

                            // Create new UserProduct record in DB, if such doesn't exist
                            $quantity = 0;
                            $em = $this->getDoctrine()->getManager();

                            if ($userProduct) {
                                $quantity = $userProduct->getQuantity();
                                if ($quantity >= 1) {
                                    $quantity--;
                                    $userProduct->setQuantity($quantity);
                                }

                                if ($quantity == 0) {
                                    $em->remove($userProduct);
                                }
                            }

                            $em->flush();

                            return new Response($quantity, Response::HTTP_OK);
                        } else {
                            return new Response(AjaxResponses::$PRODUCT_NOT_FOUND, Response::HTTP_NOT_FOUND);
                        }
                    } else {
                        return new Response(AjaxResponses::$ORDER_JOINING_TIME_IS_OVER, Response::HTTP_NOT_FOUND);
                    }
                } else {
                    return new Response(AjaxResponses::$ORDER_NOT_FOUND, Response::HTTP_NOT_FOUND);
                }
            } else {
                return new Response(AjaxResponses::$WRONG_REQUEST_PARAMETERS, Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new Response(AjaxResponses::$UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @Route(
     *     "/product/change_quantity",
     *     name="change_product_quantity"
     * )
     * @Method("POST")
     */
    public function changeQuantityAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $request = Request::createFromGlobals();
            $order_id = intval($request->request->get('order_id', 0));
            $product_id = intval($request->request->get('product_id', 0));
            $quantity = abs(intval($request->request->get('quantity', 0)));

            if ($order_id > 0 && $product_id > 0 && $quantity >= 0) {
                // Retrieve orders' details information for a details page
                $order = $this->getDoctrine()
                    ->getRepository('AppBundle:Orders')
                    ->find($order_id);

                if ($order) {
                    // Check whether order is still open to join / change quantities
                    $closing_after = Utilities::countTimeRemaining(
                        date_timestamp_get($order->getJoiningDeadline()));

                    if ($closing_after != Utilities::$STATUS_JOINING_TIME_IS_OVER) {
                        $product = $this->getDoctrine()
                            ->getRepository('AppBundle:Product')
                            ->find($product_id);

                        if ($product && $order->getProducts()->contains($product)) {
                            $user = $this->getUser();
                            $userProduct = $this->getDoctrine()
                                ->getRepository('AppBundle:UserProduct')
                                ->findOneBy(array(
                                    'user'      => $user,
                                    'product'   => $product
                                ));

                            // Create new UserProduct record in DB, if such doesn't exist
                            $em = $this->getDoctrine()->getManager();

                            if (!$userProduct) {
                                $userProduct = new UserProduct();
                                $userProduct->setUser($user);
                                $userProduct->setProduct($product);
                                $userProduct->setQuantity($quantity);

                                $em->persist($userProduct);
                            } else {
                                $userProduct->setQuantity($quantity);
                            }
                            $em->flush();

                            return new Response($quantity, Response::HTTP_OK);
                        } else {
                            return new Response(AjaxResponses::$PRODUCT_NOT_FOUND, Response::HTTP_NOT_FOUND);
                        }
                    } else {
                        return new Response(AjaxResponses::$ORDER_JOINING_TIME_IS_OVER, Response::HTTP_NOT_FOUND);
                    }
                } else {
                    return new Response(AjaxResponses::$ORDER_NOT_FOUND, Response::HTTP_NOT_FOUND);
                }
            } else {
                return new Response(AjaxResponses::$WRONG_REQUEST_PARAMETERS, Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new Response(AjaxResponses::$UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
        }
    }
}

