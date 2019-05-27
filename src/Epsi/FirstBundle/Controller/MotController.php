<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\mot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class MotController extends Controller {

    public function motAction(Request $request) {
        $mot = new mot();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $mot);
        $formBuilder
                ->add('Libelle', TextType::class)
                ->add('LibelleAnglais', TextType::class)
                ->add('categorie', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:categorie',
                    'choice_label'=>'Libelle',))
                ->add('Ajouter', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $msg=""; 
        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){               
                $msg= 'Message bien envoyé'; 
                $em = $this->getDoctrine()->getManager();              
                $em->persist($mot);               
                $em->flush();
                }else{               
                    $msg = 'Problème';             
            } 
        }


        return $this->render('EpsiFirstBundle:Mot:mot.html.twig', array('form' => $form->createView(),'message'=>$msg)
        );
    }
    
    public function modifAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:mot');
    $mot = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $mot);
        $formBuilder
                ->add('Libelle', TextType::class)
                ->add('LibelleAnglais', TextType::class)
                ->add('categorie', EntityType::class, array(
                    'class'=>'EpsiFirstBundle:categorie',
                    'choice_label'=>'Libelle',))
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Mot mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($mot);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:mot:view');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Mot:modifMot.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:mot');
        $mot = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($mot);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:mot:view');
        return $response;
        

    }
    
    public function viewAction() {
       $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:mot'); 
       $listeMots=$repository->findAll();
       
       return $this->render('EpsiFirstBundle:Mot:listMot.html.twig',array('listeMots'=>$listeMots));
    }
    
    /**
     * @ApiDoc(
     * description="récupère la liste des mots"
     * )
     * @Rest\View()
     * @Rest\Get("/wsmots")
     * 
     * 
     */
    
    public function getMotAction()
    {
        $mots = $this->get('doctrine.orm.entity_manager')
                   ->getRepository('EpsiFirstBundle:mot')
                   ->findAll();
    /* @var $mots mot[] */
        return $mots;
    }
}
