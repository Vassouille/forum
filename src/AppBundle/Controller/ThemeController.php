<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends Controller
{
    /**
     * @Route("/theme/{id}", name="theme")
     */
    public function themeAction($id)
    {
        return $this->render('theme.html.twig', array(

        ));
    }
}