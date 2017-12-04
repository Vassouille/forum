<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function helloAction(Request $request)
    {
        $theme = new Theme();

        $form = $this->createFormBuilder($theme)
            ->add('name', TextType::class, array('label' => 'Nom du thème'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $theme = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($theme);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('theme.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}