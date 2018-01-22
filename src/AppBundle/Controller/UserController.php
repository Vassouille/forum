<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    public function whoIsOnlineAction()
    {
        $connected = $this->getDoctrine()->getManager()->getRepository(User::class)->getActive();

        return $this->render('connected.html.twig', array(
            'users' => $connected[0][1]
        ));
    }

    public function listUser()
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

        return $this->render('listusers.html.twig', array(
            'users' => $users
        ));
    }

	/**
	 * @param Request $request
	 * @Route("/imconnected")
	 * @return JsonResponse|Response
	 */
    public function imConnectedAction(Request $request)
    {
	    $user = $this->getUser();

	    if ($request->isXmlHttpRequest()) {

		    $em = $this->getDoctrine()->getManager();
		    if ($user) {
			    $me = $em->getRepository( User::class )->findOneBy( [ 'id' => $user->getId() ] );
			    $me->setLastActivityAt( new \DateTime() );
			    $em->refresh( $me );
			    $em->flush();
		    }

		    $users = $em->getRepository(User::class)->getActive();
		    return new JsonResponse(['users' => $users[0][1]]);
	    } else {
		    return new Response('404');
	    }
    }
}