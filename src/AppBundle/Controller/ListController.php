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

        $themes = $em->getRepository(Theme::class)->getList($page);
        $count = $em->getRepository(Theme::class)->countTheme();

        $max = (int)ceil($count[0][1]/5);
        $pagination = [];
        for ($i = ($page - 3); $i <= ($page + 3); $i++) {
            if ($i > 0 && $i <= $max) {
                array_push($pagination, $i);
            }
        }

        return $this->render('list.html.twig', array(
            'form' => $form->createView(),
            'themes' => $themes,
            'active' => $page,
            'pagination' => $pagination,
            'max' => $max
        ));
    }
}