<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    // TODO: to be implemented after reading additional information about FOSUserBundle
    /**
     * @Route(
     *     "/user/login/",
     *     name="user_login"
     * )
     */
    public function loginAction()
    {
        return new RedirectResponse($this->generateUrl('orders_open'));
    }

    // TODO: to be implemented after reading additional information about FOSUserBundle
    /**
     * @Route(
     *     "/user/logout",
     *     name="user_logout"
     * )
     */
    public function logoutAction()
    {
        return new RedirectResponse($this->generateUrl('homepage'));
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
        // TODO: retrieve and pass data from DB

        return $this->render('default/my_orders.html.twig', array(
            'per_page' => $per_page,
            'page_number' => $page_number
        ));
    }

    // TODO: to be implemented after reading additional information about FOSUserBundle
    /**
     * @Route(
     *     "/user/forgot-password",
     *     name="user_forgot_password"
     * )
     */
    public function forgotPasswordAction()
    {
        // TODO: render forgot password view
        return $this->render('default/index.html.twig');
    }

    // TODO: to be implemented after reading additional information about FOSUserBundle
    /**
     * @Route(
     *     "/user/change-password",
     *     name="user_change_password"
     * )
     */
    public function changePasswordAction()
    {
        // Create flash message for successful password change
        $this->addFlash(
            'notice',
            'Your password has been successfully changed. Check your email for more information!'
        );

        // Redirect to homepage screen
        return new RedirectResponse($this->generateUrl('homepage'));
    }
}

