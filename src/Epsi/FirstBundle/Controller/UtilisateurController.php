<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UtilisateurController extends Controller {

    public function utilisateurAction(Request $request) {
        $utilisateur = new Utilisateur();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $utilisateur);
        $formBuilder
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('username', TextType::class)
                ->add('password', TextType::class)
                ->add('CodePostal', TextType::class)
                ->add('Ville', TextType::class)
                ->add('Adresse', TextType::class)
                ->add('Abonnement', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:Abonnement',
                    'choice_label'=>'Type',))
                ->add('Entreprise', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:Entreprise',
                    'choice_label'=>'Nom',))
                ->add('Ajouter', SubmitType::class)
        ;
        $msg='';
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()){
                $this->encoder = $this->container->get('security.password_encoder');
                $password = $this->encoder->encodePassword($utilisateur, $utilisateur->getPassword());
                $utilisateur->setPassword($password);
                $utilisateur->setSalt('');
                $utilisateur->setRoles(array('ROLE_SUPER_ADMIN'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Utilisateur:view');
                return $response;
            }
        }
       
        return $this->render('EpsiFirstBundle:Utilisateur:utilisateur.html.twig',['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    
    public function modifAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Utilisateur');
    $utilisateur = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $utilisateur);
        $formBuilder
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('username', TextType::class)
                ->add('password', TextType::class)
                ->add('CodePostal', TextType::class)
                ->add('Ville', TextType::class)
                ->add('Adresse', TextType::class)
                ->add('Abonnement', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:Abonnement',
                    'choice_label'=>'Type',))
                ->add('Entreprise', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:Entreprise',
                    'choice_label'=>'Nom',))
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Utilisateur mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Utilisateur:view');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Utilisateur:modifUtilisateur.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    
    public function viewAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Utilisateur');
        $formBuilder=$this->get('form.factory')->createBuilder(FormType::class);
        
        $formBuilder->add('save', SubmitType::class,
            array('attr'=>array('class'=>'save'),'label'=>'Supprimer'));
        
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')){
            $form -> handleRequest($request);
            if($form->isValid()){
                $cocher = $request->request->get('cocher');
                foreach($cocher as $id){                   
                    $listeUtilisateur = $repository->deleteUtilisateur($id);
                }
            }
        }
        $listeUtilisateur = $repository->findAll();
        return $this->render('EpsiFirstBundle:Utilisateur:listUtilisateur.html.twig', array('listeUtilisateur' => $listeUtilisateur,'form'=>$form->createView()));
    }
    
    public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Utilisateur');
        $utilisateur = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($utilisateur);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:Utilisateur:view');
        return $response;
    }
    
    public function loginAction(Request $request){
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
          return $this->redirectToRoute('epsi_first_homepage');
    }
    $authenticationUtils = $this->get('security.authentication_utils');
    return $this->render('EpsiFirstBundle:Default:login.html.twig',array('last_username'=>$authenticationUtils->getLastUserName(),'error'=>$authenticationUtils->getLastAuthenticationError(),));
    }
    
    /**
     * @ApiDoc(
     * description="récupère la liste des utilisateurs"
     * )
     * @Rest\View()
     * @Rest\Get("/wsutilisateurs")
     *
     *
     */
    public function getUtilisateursAction() {
        $utilisateurs = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('EpsiFirstBundle:Utilisateur')->findAll();
        /* @var $utilisateurs Utilisateur[] */
        return $utilisateurs;
    }

}

?>