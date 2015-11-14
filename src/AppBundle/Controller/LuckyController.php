<?php
/**
 * Created by PhpStorm.
 * User: mindaugas
 * Date: 15.11.7
 * Time: 17.07
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberAction($count)
    {
        $numbers = array();
        for ($i = 0; $i<$count; $i++){
            $numbers[] = mt_rand(0,100);
        }
        $numbersList = implode(', ', $numbers);

        return $this->render(
            'lucky/number.html.twig',
            array('luckyNumberList' => $numbersList)
        );
    }



    /**
     * @Route ("/api/lucky/number")
     */
    public function apiNumberAction(){
        $data = array(
            'lucky_number' => mt_rand(0,100),
            'not_lucky_number' => 13,
        );
        return new JsonResponse($data);
    }
}