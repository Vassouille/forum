<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Discussion;
use AppBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DiscussionController extends Controller
{
    /**
     * @Route("/theme/{id}", name="theme")
     */
    public function themeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $discussions = $em->getRepository(Discussion::class)->findBy(array('themeid' => $id), array('id' => 'desc'), 10);
        $theme = $em->getRepository(Theme::class)->findOneBy(array('id' => $id));
        $count = $em->getRepository(Discussion::class)->countDiscussion($id);
        $max = (int)ceil($count[0][1]/10);
        $pagination = [];
        for ($i = 1; $i <= 4; $i++) {
            if ($i <= $max) {
                array_push($pagination, $i);
            }
        }

        if ($user) {
            $discussion = new Discussion();
            $discussion->setDate(new \DateTime());
            $discussion->setThemeId($id);
            $discussion->setAuthorId($this->getUser()->getId());
            $discussion->setUsername($this->getUser()->getUsername());

            $form = $this->createFormBuilder($discussion)
                ->add('content', TextareaType::class, array('label' => 'discussion.content'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $discussion = $form->getData();
                $em->persist($discussion);
                $em->flush();

                $em->getRepository(Discussion::class)->updateTheme(
                    $id,
                    $user->getUsername,
                    $em->getRepository(Discussion::class)->findOneBy(array(), array('date' => 'DESC'))
                );

                return $this->redirectToRoute('theme', array('id' => $id));
            }

            return $this->render('theme.html.twig', array(
                'form' => $form->createView(),
                'discussions' => $discussions,
                'active' => 1,
                'pagination' => $pagination,
                'max' => $max,
                'theme' => $theme
            ));

        } else {
            return $this->render('theme.html.twig', array(
                'discussions' => $discussions,
                'active' => 1,
                'pagination' => $pagination,
                'max' => $max,
                'theme' => $theme
            ));
        }
    }

    /**
     * @Route("/theme/{id}/{page}", name="theme_list")
     */
    public function themeListAction(Request $request, $id, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $discussions = $em->getRepository(Discussion::class)->getList($id, $page);
        $theme = $em->getRepository(Theme::class)->findOneBy(array('id' => $id));
        $count = $em->getRepository(Discussion::class)->countDiscussion($id);
        $max = (int)ceil($count[0][1]/10);
        $pagination = [];
        for ($i = ($page - 3); $i <= ($page + 3); $i++) {
            if ($i > 0 && $i <= $max) {
                array_push($pagination, $i);
            }
        }

        if ($user) {
            $discussion = new Discussion();
            $discussion->setDate(new \DateTime());
            $discussion->setThemeId($id);
            $discussion->setAuthorId($this->getUser()->getId());
            $discussion->setUsername($this->getUser()->getUsername());

            $form = $this->createFormBuilder($discussion)
                ->add('content', TextareaType::class, array('label' => 'discussion.content'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $discussion = $form->getData();
                $em->persist($discussion);
                $em->flush();

                return $this->redirectToRoute('theme', array('id' => $id));
            }

            return $this->render('theme.html.twig', array(
                'form' => $form->createView(),
                'discussions' => $discussions,
                'active' => $page,
                'pagination' => $pagination,
                'max' => $max,
                'theme' => $theme
            ));

        } else {
            return $this->render('theme.html.twig', array(
                'discussions' => $discussions,
                'active' => $page,
                'pagination' => $pagination,
                'max' => $max,
                'theme' => $theme
            ));
        }
    }
}