<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\listeMot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ListeMotController extends Controller {

    public function listeMotAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:listeMot'); 
        $ListeMots=$repository->findAll();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $ListeMots);
        $formBuilder
                ->add('Libelle', TextType::class)
                ->add('theme', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:Theme',
                    'choice_label' => 'libelle', ))
                ->add('Ajouter', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $msg=""; 
        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){               
                $msg= 'Message bien envoyé'; 
                $em = $this->getDoctrine()->getManager();              
                $em->persist($ListeMots);               
                $em->flush();
                }else{               
                    $msg = 'Problème';             
            } 
        }
        return $this->render('EpsiFirstBundle:ListeMot:listeMot.html.twig', array('form' => $form->createView(),'listeMot'=>$ListeMots,'message'=>$msg)
        );
    }
    
    public function modifAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:listeMot');
    $ListeMots = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $ListeMots);
        $formBuilder
                ->add('Libelle', TextType::class)
                ->add('theme', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:Theme',
                    'choice_label' => 'libelle', ))
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Liste mot mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($ListeMots);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:listeMot:listeMot');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:ListeMot:modifListeMot.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:listeMot');
        $listeMot = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($listeMot);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:listeMot:view');
        return $response;
        

    }
    
    public function viewAction() {
       $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:listeMot'); 
       $ListeMots=$repository->findAll();
       
       return $this->render('EpsiFirstBundle:ListeMot:listeMot.html.twig',array('ListeMots'=>$ListeMots));
    }
    
    /**
     * @ApiDoc(
     * description="récupère la liste des mots"
     * )
     * @Rest\View()
     * @Rest\Get("/wslistemots")
     * 
     * 
     */
    
    public function getListeMotAction()
    {
        $ListeMots = $this->get('doctrine.orm.entity_manager')
                   ->getRepository('EpsiFirstBundle:listeMot')
                   ->findAll();
    /* @var $mots mot[] */
        return $ListeMots;
    }
}