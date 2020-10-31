<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\DataFixtures\ORM\LoadUserData;
#use Symfony\Component\HttpFoundation\Session\Session;


class SessController extends Controller
{
	/**
     * @Route("/sess", name="sess")
     */
    public function SeesAction(Request $request )
    {
    	#$session = new Session();
        #$session->start();

    
        #return $this->render('pages/sessAdmin.html.twig');
        
    }
}
