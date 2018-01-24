<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Theme;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ThemeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function helloAction(Request $request)
    {
        $theme = new Theme();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($theme)
            ->add('name', TextType::class, array('label' => 'theme.name'))
            ->add('description', TextType::class, array('label' => 'theme.description'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $theme = $form->getData();
                $em->persist($theme);
                $em->flush();
            }

            return $this->redirectToRoute('home');
        }

        $themes = $em->getRepository(Theme::class)->findBy(array(), array('id' => 'desc'), 5);
        $count = $em->getRepository(Theme::class)->countTheme();

        $authorinfo = [];
        $i = 0;
        foreach ($themes as $theme) {
            $discussions = $theme->getDiscussions();
            $authorinfo[$i]['number'] = count($discussions);
            foreach ($discussions as $discussion) {
                $author = $em->getRepository(User::class)->find(array('id' => $discussion->getAuthorId()));
                $authorinfo[$i]['n'] = $author->getUsername();
                $authorinfo[$i]['d'] = $discussion->getDate();
            }
            $i++;
        }

        $max = (int)ceil($count[0][1]/5);
        $pagination = [];
        for ($i = 1; $i <= 4; $i++) {
            if ($i <= $max) {
                array_push($pagination, $i);
            }
        }

        return $this->render('theme.html.twig', array(
            'form' => $form->createView(),
            'themes' => $themes,
            'active' => 1,
            'pagination' => $pagination,
            'max' => $max,
            'authorinfo' => $authorinfo
        ));
    }

    /**
     * @Route("/theme/{page}", name="list")
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
            if ($this->isGranted('ROLE_ADMIN')) {
                $theme = $form->getData();
                $em->persist($theme);
                $em->flush();
            }

            return $this->redirectToRoute('home');
        }

        $themes = $em->getRepository(Theme::class)->getList($page);
        $count = $em->getRepository(Theme::class)->countTheme();

        $authorinfo = [];
        $i = 0;
        foreach ($themes as $theme) {
            $discussions = $theme->getDiscussions();
            $authorinfo[$i]['number'] = count($discussions);
            foreach ($discussions as $discussion) {
                $author = $em->getRepository(User::class)->find(array('id' => $discussion->getAuthorId()));
                $authorinfo[$i]['n'] = $author->getUsername();
                $authorinfo[$i]['d'] = $discussion->getDate();
            }
            $i++;
        }

        $max = (int)ceil($count[0][1]/5);
        $pagination = [];
        for ($i = ($page - 3); $i <= ($page + 3); $i++) {
            if ($i > 0 && $i <= $max) {
                array_push($pagination, $i);
            }
        }

        return $this->render('theme.html.twig', array(
            'form' => $form->createView(),
            'themes' => $themes,
            'active' => $page,
            'pagination' => $pagination,
            'max' => $max,
            'authorinfo' => $authorinfo
        ));
    }
}