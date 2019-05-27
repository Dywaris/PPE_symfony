<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class InscriptionController extends Controller {

    public function inscriptionAction(Request $request) {
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
                $utilisateur->setRoles(array('ROLE_USER'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);
                $em->flush();
            }
        }
        return $this->render('EpsiFirstBundle:Default:inscription.html.twig',['form' => $form->createView(), 'message' => $msg]
        );
    }
}
?>
    