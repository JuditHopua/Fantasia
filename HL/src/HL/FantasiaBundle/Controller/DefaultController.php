<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FantasiaBundle:Default:index.html.twig', array('name' => $name));
    }
}