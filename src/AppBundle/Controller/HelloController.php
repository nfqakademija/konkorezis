<?php
/**
 * Created by PhpStorm.
 * User: mindaugas
 * Date: 15.11.7
 * Time: 21.43
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{
    /**
     * @Route ("/hello/{name}", name="hello")
     */
    public function indexAction($name)
    {
       $response = $this->forward('AppBundle:Hello:fancy', array(
           'name' => $name,
           'color' => 'green'
       ));
        return $response;
    }
    public function fancyAction($name, $color)
    {
        return $this->render(
            'lucky/number.html.twig',
            array('name' => $name,
                  'color' => $color,)
        );
    }
    /**
     * @Route ("/welcome/", name="welcome")
     */
    public function welcomeAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route ("/varle/{name}")
     */
    public function varleAction($name)
    {
        $response = new Response('Hello '.$name, Response::HTTP_OK);
        $response = new Response(json_encode(array('name' => $name)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }





    /*
    return examples reminder ^^
    public function indexAction($name)
    {
        return new Response('<html><body>Hello '.$name.'</body></html>');
        return $this->redirectToRoute('homepage');
        return $this->redirectToRoute('homepage', array(), 301);
        return $this->render('hello/index.html.twig', array('name' => $name));
    }

    session@@@@
     $session = $request->getSession();
        $session->set('foo','bar');
        $foobar = $session->get('foobar');
        $filters = $session->get('filters', array());


    public function updateAction(Request $request)
    {
        $form = $this->createForm();
        $form->handleRequest($request);
        if ($form->isValid()){
            $this->addFlash(
                'notice',
                'your changes were saved!'
            );
        }
        return $this->redirectToRoute('homepage');

    }
        $session = $request->getSession();
        $session->set('foo','bar');
        $foobar = $session->get('foobar');
        $filters = $session->get('filters', array());
        return $this->render('hello/index.html.twig', array('name' => $name));


    */
}