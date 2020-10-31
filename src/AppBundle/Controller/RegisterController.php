<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{
    /**
     * @Route("/register")
     * @param Request $request
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder )
    {
    	$user = new User();
    	$em = $this -> getDoctrine() -> getManager();
    	$form = $this->createFormBuilder($user)
    ->add('username',TextType::class)
           ->add('email',EmailType::class)
           ->add('password',RepeatedType::class , ['type'=>PasswordType::class
       ])
           ->add('Sauvegarder ',SubmitType::class, array('label' =>'creer un nouveau utilisateur' ,'attr' => array('class' => 'btn btn-outline-dark','style'=> 'margin-top:10px')))
        ->getForm();
    	$form -> handleRequest($request);
    	if($form -> isSubmitted() && $form-> isValid()){
    		$username=$form['username']->getData();
        	$email=$form['email']->getData();
        	$password=$form['password']->getData();
        	$user-> setUsername($username);
        	$user-> setEmail($email);
        	$user-> setPassword($encoder->encodePassword($user,$password));


        	$em -> persist($user);
        	$em -> flush();
        	return $this->redirectToRoute('login');

    	}

        return $this->render('AppBundle:Register:register.html.twig', ['form'=>$form ->createView()]);
    }
     /**
     * @Route("/user", name="View_users_route")
     */
    public function ViewPostAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
  
        return $this->render('pages/indexUser.html.twig',['users'=>$users]);
    }
        /**
     * @Route("/deleteUser/{id}", name="delete_post_route")
     */
        public function deletePostsAction( $id)
    {
        
        $em = $this -> getDoctrine() -> getManager();
        $user = $em -> getRepository('AppBundle:User')->find($id);
        $em-> remove($user);
        $em -> flush();
        $this ->addFlash('message', 'Utilisateur a été suprimé avec succès');
            return $this->redirectToRoute('View_users_route');


        #return $this->render('pages/delete.html.twig');
    } 

}
