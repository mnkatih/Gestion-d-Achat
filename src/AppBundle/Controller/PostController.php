<?php

namespace AppBundle\Controller;
use AppBundle\Entity\fournisseur;
use AppBundle\Entity\Achat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class PostController extends Controller
{
	  /**
     * @Route("/post", name="View_posts_route")
     */
    public function ViewPostAction(Request $request)
    {
        // replace this example code with whatever you need
		$em = $this->getDoctrine()->getManager();
        $achats = $em->getRepository('AppBundle:Achat')->findAll();
  
        return $this->render('pages/index.html.twig',['achats'=>$achats]);
    }
 	  /**
     * @Route("/create", name="create_post_route")
     */
    public function createPostsAction(Request $request)
    {
        // replace this example code with whatever you need
        $achat = new Achat ;
        $form = $this->createFormBuilder($achat)
        #->add('description',TextareaType::class, array('attr' => array('class' => 'form_control')))
        ->add('produit',TextType::class,['label' => 'Nom du produit'], array('attr' => array('class' => 'form_control')))
        ->add('description',TextareaType::class,['label' => 'Description d achat'], array('attr' => array('class' => 'form_control')))
        ->add('quantite',IntegerType::class,['label' => 'Quantitée'],array('attr' => array('class' => 'form_control')))
        ->add('pU',IntegerType::class,['label' => 'prix unitaire'],array('attr' => array('class' => 'form_control')))
        
        
        ->add('fournisseur',EntityType::class,array ('class' => 'AppBundle:fournisseur','choice_label' => 'entreprise', 'choice_value' =>'id') )
        ->add('data',DateType::class,['label' => 'Date d achat'], array('attr' => array('class' => 'form_control')))
        ->add('Sauvegarder ',SubmitType::class, array('label' =>'creer un achat' ,'attr' => array('class' => 'btn btn-outline-dark','style'=> 'margin-top:10px')))
        ->getForm();
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form-> isValid()){
        	$description=$form['description']->getData();
        	$produit=$form['produit']->getData();
        	$quantite=$form['quantite']->getData();
        	$prix=$form['pU']->getData();
        	$date=$form['data']->getData();
            $fournisseur=$form['fournisseur']->getData();

        	$achat-> setDescription($description);
        	$achat-> setProduit($produit);
        	$achat-> setQuantite($quantite);
        	$achat-> setPU($prix);
        	$achat-> setData($date);
            $achat-> setFournisseur($fournisseur);

        	$em = $this -> getDoctrine() -> getManager();
        	$em -> persist($achat);
        	$em -> flush();
        	$this ->addFlash('message', 'Achat a été créée avec succès');
        	return $this->redirectToRoute('View_posts_route');
        	 }
        return $this->render('pages/create.html.twig',['form'=>$form ->createView()]);
    }
      /**
     * @Route("/view/{id}", name="view_post_route")
     */
    public function viewPostsAction( $id)
    {
        $achats = $this->getDoctrine()->getRepository('AppBundle:Achat')->find($id);

        return $this->render('pages/view.html.twig',['achats'=>$achats]);
    }
      /**
     * @Route("/edit/{id}", name="edit_post_route")
     */
    public function editPostsAction( Request $request , $id)
    {
        $achat = $this->getDoctrine()->getRepository('AppBundle:Achat')->find($id);
        $achat->setDescription($achat->getDescription());
        $achat->setProduit($achat->getProduit());
        $achat->setQuantite($achat->getQuantite());
        $achat->setData($achat->getData());
        $achat->setPU($achat->getPU());
        $form = $this->createFormBuilder($achat)
        ->add('produit',TextType::class,['label' => 'Nom du produit'], array('attr' => array('class' => 'form_control')))
        ->add('description',TextareaType::class,['label' => 'Description  d achat'], array('attr' => array('class' => 'form_control')))
        ->add('quantite',IntegerType::class,['label' => 'Quantitée'],array('attr' => array('class' => 'form_control')))
        ->add('pU',IntegerType::class,['label' => 'prix unitaire'],array('attr' => array('class' => 'form_control')))
        ->add('data',DateType::class,['label' => 'Date d achat'], array('attr' => array('class' => 'form_control')))
       
        

        ->add('Sauvegarder ',SubmitType::class, array('label' =>'modifier un achat' ,'attr' => array('class' => 'btn btn-outline-dark','style'=> 'margin-top:10px')))
        ->getForm();
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form-> isValid()){
        	$description=$form['description']->getData();
        	$produit=$form['produit']->getData();
        	$quantite=$form['quantite']->getData();
        	$prix=$form['pU']->getData();
        	$date=$form['data']->getData();

        	$em = $this -> getDoctrine() -> getManager();
        	$achat = $em -> getRepository('AppBundle:Achat')->find($id);

        	$achat-> setDescription($description);
        	$achat-> setProduit($produit);
        	$achat-> setQuantite($quantite);
        	$achat-> setPU($prix);
        	$achat-> setData($date);

        	$em -> flush();
        	$this ->addFlash('message', 'Achat a été modifiée avec succès');
        	return $this->redirectToRoute('View_posts_route');

        }
        return $this->render('pages/edit.html.twig',['form'=>$form ->createView()]);
    }
      /**
     * @Route("/delete/{id}", name="delete_post_route")
     */
    public function deletePostsAction( $id)
    {
        
        $em = $this -> getDoctrine() -> getManager();
        $achat = $em -> getRepository('AppBundle:Achat')->find($id);
        $em-> remove($achat);
        $em -> flush();
        $this ->addFlash('message', 'Achat a été suprimé avec succès');
        	return $this->redirectToRoute('View_posts_route');


        #return $this->render('pages/delete.html.twig');
    } 
       
       /**
     * @Route("/fournisseur", name="view_all_fournisseurs")
     */
    public function ViewFrsAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $fournisseurs = $em->getRepository('AppBundle:fournisseur')->findAll();
  
        return $this->render('pages/indexFrs.html.twig',['fournisseurs'=>$fournisseurs]);
    } 
     /**
     * @Route("/createFournisseur", name="add_frs_route")
     */
    public function addFournisseurAction(Request $request)
    {


                 // replace this example code with whatever you need
        $fournisseur= new fournisseur();
        $form = $this->createFormBuilder($fournisseur)
        #->add('description',TextareaType::class, array('attr' => array('class' => 'form_control')))
        ->add('entreprise',TextType::class ,['label' => 'Nom d entreprise'], array('attr' => array('class' => 'form_control')))
        ->add('mail',TextType::class,['label' => 'mail '],array('attr' => array('class' => 'form_control')))
        ->add('telephone',IntegerType::class,['label' => 'Numéro de téléphone'],array('attr' => array('class' => 'form_control')))
        ->add('fAX',IntegerType::class,['label' => 'FAX'], array('attr' => array('class' => 'form_control')))
        ->add('Sauvegarder ',SubmitType::class, array('label' =>'creer un fournisseur' ,'attr' => array('class' => 'btn btn-outline-dark','style'=> 'margin-top:10px')))
        ->getForm();
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form-> isValid()){
            $entreprise=$form['entreprise']->getData();
            $mail=$form['mail']->getData();
            $telephone=$form['telephone']->getData();
            $fAX=$form['fAX']->getData();
         

            $fournisseur-> setEntreprise($entreprise);
            $fournisseur-> setMail($mail);
            $fournisseur-> setTelephone($telephone);
            $fournisseur-> setFAX($fAX);
           

            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($fournisseur);
            $em -> flush();
            $this ->addFlash('message', 'fournisseur a été ajouté avec succès');
            return $this->redirectToRoute('view_all_fournisseurs');
             }
        return $this->render('pages/addFournisseur.html.twig',['form'=>$form ->createView()]);
}
      /**
     * @Route("/viewFrs/{id}", name="view_frs_route")
     */
    public function viewOneFrsAction( $id)
    {
        $fournisseurs = $this->getDoctrine()->getRepository('AppBundle:fournisseur')->find($id);

        return $this->render('pages/viewFrs.html.twig',['fournisseurs'=>$fournisseurs]);
    }
        /**
     * @Route("/editFrs/{id}", name="edit_frs_route")
     */
    public function editFrsAction( Request $request , $id)
    {
        $fournisseur = $this->getDoctrine()->getRepository('AppBundle:fournisseur')->find($id);
        $fournisseur->setEntreprise($fournisseur->getEntreprise());
        $fournisseur->setMail($fournisseur->getMail());
        $fournisseur->setTelephone($fournisseur->getTelephone());
        $fournisseur->setFAX($fournisseur->getFAX());
        $form = $this->createFormBuilder($fournisseur)
        ->add('entreprise',TextType::class ,['label' => 'Nom d entreprise'], array('attr' => array('class' => 'form_control')))
        ->add('mail',TextType::class,['label' => 'mail '],array('attr' => array('class' => 'form_control')))
        ->add('telephone',IntegerType::class,['label' => 'Numéro de téléphone'],array('attr' => array('class' => 'form_control')))
        ->add('fAX',IntegerType::class,['label' => 'FAX'], array('attr' => array('class' => 'form_control')))
        ->add('Sauvegarder ',SubmitType::class, array('label' =>'modifier le fournisseur' ,'attr' => array('class' => 'btn btn-outline-dark','style'=> 'margin-top:10px')))
        ->getForm();
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form-> isValid()){
            $entreprise=$form['entreprise']->getData();
            $mail=$form['mail']->getData();
            $telephone=$form['telephone']->getData();
            $fAX=$form['fAX']->getData();


            $em = $this -> getDoctrine() -> getManager();
            $fournisseur = $em -> getRepository('AppBundle:fournisseur')->find($id);

            $fournisseur-> setEntreprise($entreprise);
            $fournisseur-> setMail($mail);
            $fournisseur-> setTelephone($telephone);
            $fournisseur-> setFAX($fAX);
           

            $em -> flush();
            $this ->addFlash('message', 'Fournisseur a été modifiée avec succès');
            return $this->redirectToRoute('view_all_fournisseurs');

        }
        return $this->render('pages/editFrs.html.twig',['form'=>$form ->createView()]);
    } 
          /**
     * @Route("/deleteFrs/{id}", name="delete_frs_route")
     */
    public function deleteFrsAction( $id)
    {
        
        $em = $this -> getDoctrine() -> getManager();
        $achat = $em -> getRepository('AppBundle:fournisseur')->find($id);
        $em-> remove($achat);
        $em -> flush();
        $this ->addFlash('message', 'fournisseur a été suprimé avec succès');
            return $this->redirectToRoute('view_all_fournisseurs');


    }                                              
}
