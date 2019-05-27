<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\Possede;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class PossedeController extends Controller {

    public function possedeAction(Request $request) {
        $possede = new Possede();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $possede);
        $formBuilder
                ->add('Utilisateur', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:Utilisateur',
                    'choice_label'=>'Nom',))
                ->add('Listemot', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:listeMot',
                    'choice_label'=>'Libelle',))
                ->add('Ajouter', SubmitType::class)
        ;
        $msg='';
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'La liste de utilisateur à été Ajouté !';
                $em = $this->getDoctrine()->getManager();
                $em->persist($possede);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Possede:view');
                return $response;
            } else {
                $msg = '';
            }
        }
       
        return $this->render('EpsiFirstBundle:Possede:possede.html.twig',['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    public function modifAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Possede');
    $possede = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $possede);
        $formBuilder
                ->add('Utilisateur', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:Utilisateur',
                    'choice_label'=>'Nom',))
                ->add('Listemot', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:Listemot',
                    'choice_label'=>'Libelle',))
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Utilisateur mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($possede);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Possede:view');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Possede:modifPossede.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    public function viewAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Possede');
        $formBuilder=$this->get('form.factory')->createBuilder(FormType::class);
        
        $formBuilder->add('save', SubmitType::class,
            array('attr'=>array('class'=>'save'),'label'=>'Supprimer'));
        
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')){
            $form -> handleRequest($request);
            if($form->isValid()){
                $cocher = $request->request->get('cocher');
                foreach($cocher as $id){                   
                    $listePossede = $repository->deleteTheme($id);
                }
            }
        }
        $listePossede = $repository->findAll();
        return $this->render('EpsiFirstBundle:Possede:listPossede.html.twig', array('listePossede' => $listePossede,'form'=>$form->createView()));
    }
    
    public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Possede');
        $possede = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($possede);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:possede:view');
        return $response;
    }

}

?>