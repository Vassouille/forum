<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller
{
    /**
     * @Route("/list/{page}", name="list")
     */
    public function listAction(Request $request, $page)
    {
        $theme = new Theme();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($theme)
            ->add('name', TextType::class, array('label' => 'theme.name'))
            ->add('description', TextType::class, array('label' => 'theme.description'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $theme = $form->getData();
            $em->persist($theme);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        $themes = $em->getRepository(Theme::class)->findBy(array(), array('id' => 'desc'), 5);

        return $this->render('list.html.twig', array(
            'form' => $form->createView(),
            'themes' => $themes
        ));
    }
}