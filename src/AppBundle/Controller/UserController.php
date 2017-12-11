<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    public function whoIsOnlineAction()
    {
        $connected = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->getActive();

        return $this->render('connected.html.twig', array(
            'users' => $connected[0][1]
        ));
    }
}