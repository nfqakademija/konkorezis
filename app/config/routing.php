<?php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();
$collection->add('hello', new Route('/hello/{name}', array(
    // uses a special syntax to point to the controller - see note below
    '_controller' => 'AppBundle:Hello:index',
)));

return $collection;