<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\DataFixtures\ORM\LoadUserData;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginController extends Controller

{   
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request , AuthenticationUtils  $authenticationUtils)
    {
    	$errors = $authenticationUtils->getLastAuthenticationError();
    	$lastUsername = $authenticationUtils->getLastUsername();
        $user = new LoadUserData();
        

        return $this->render('AppBundle:Login:login.html.twig', array('errors'=>$errors ,
        	'username'=>$lastUsername
            // ...
        ));
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {}
    /**
     * @Route("/login_success", name="login_success")
     */
    public function postLoginRedirectAction(Request $request,UserInterface $user)
        {       
         #$user = $this->get('security.token_storage')->getToken()->getUser();

        #$username = $this->get('doctrine')
            #->getEntityManager()
            #->getRepository('AppBundle:User')
            #->findSomethingByUser($user);
         #$user = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
                #->findOneBy(array('username' => $_username));

         $username= $user->getUsername();
       
        if ($username=='admin') {
            return $this->render('pages/sessAdmin.html.twig');
        }
        return $this->render('pages/sessUser.html.twig');
} }

        

