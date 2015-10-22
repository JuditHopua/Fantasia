<?php

namespace Acme\FantasiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeFantasiaBundle:Default:index.html.twig', array('name' => $name));
    }
}
