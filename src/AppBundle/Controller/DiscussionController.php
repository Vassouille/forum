<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Discussion;
use AppBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DiscussionController extends Controller
{

    /**
     * @Route("/discussion/{id}/{page}", name="theme")
     */
    public function listAction(Request $request, $id, $page)
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

        if ($this->isGranted('ROLE_ADMIN')) {
            $discussion = new Discussion();
            $discussion->setDate(new \DateTime());
            $discussion->setTheme($theme);
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

                return $this->redirectToRoute('theme', array('id' => $id, 'page' => 1));
            }

            return $this->render('discussion.html.twig', array(
                'form' => $form->createView(),
                'discussions' => $discussions,
                'active' => $page,
                'pagination' => $pagination,
                'max' => $max,
                'theme' => $theme
            ));

        } else {
            return $this->render('discussion.html.twig', array(
                'discussions' => $discussions,
                'active' => $page,
                'pagination' => $pagination,
                'max' => $max,
                'theme' => $theme
            ));
        }
    }

    /**
     * @Route("/delete/discussion", name="delete_discussion")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function deleteAction(Request $request)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            if ($request->isXmlHttpRequest()) {

                $d = $em->getRepository(Discussion::class)->findOneBy(array('id' => $request->request->get('id')));
                $em->remove($d);
                $em->flush();

                return new JsonResponse(['validation' => true]);
            }

            return new JsonResponse(['validation' => false]);

        } else {

            return new JsonResponse(['validation' => false]);
        }

    }

    /**
     * @Route("/edit/discussion}", name="edit_discussion")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function editAction(Request $request)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            if ($request->isXmlHttpRequest()) {

                $d = $em->getRepository(Discussion::class)->findOneBy(array('id' => $request->request->get('id')));
                $d->setContent($request->request->get('content'));
                $em->flush();

                return new JsonResponse(['validation' => true]);
            }

            return new JsonResponse(['validation' => false]);

        } else {

            return new JsonResponse(['validation' => false]);
        }
    }
}