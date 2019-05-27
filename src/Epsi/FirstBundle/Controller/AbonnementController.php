<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\Abonnement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class AbonnementController extends Controller {

    public function AbonnementAction(Request $request) {
        $abonnement = new Abonnement ();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $abonnement);
        $formBuilder
                ->add('Prix', TextType::class)
                ->add('Type', TextType::class)
                ->add('MoyenPaiment', TextType::class)
                ->add('Ajouter', SubmitType::class)
        ;
        $msg='';
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Abonnement Ajouté !';
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnement);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Abonnement:abonnementview');
                return $response;
            } else {
                $msg = '';
            }
        }
       
        return $this->render('EpsiFirstBundle:Abonnement:abonnement.html.twig',['form' => $form->createView(), 'message' => $msg]
        );
    }
        
    public function modificationAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Abonnement');
    $abonnement = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $abonnement);
        $formBuilder
                ->add('Prix', TextType::class)
                ->add('Type', TextType::class)
                ->add('MoyenPaiment', TextType::class)
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Abonnement mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnement);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Abonnement:abonnementview');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Abonnement:modifAbonnement.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    
        public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Abonnement');
        $abonnement = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($abonnement);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:Abonnement:abonnementview');
        return $response;
       
    }
        
        
     public function abonnementviewAction() {

        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Abonnement');
        $listeAbonnement = $repository->findAll();
        return $this->render('EpsiFirstBundle:Abonnement:listAbonnement.html.twig', array('listeAbonnement' => $listeAbonnement));
    }

    /**
     * @ApiDoc(
     * description="récupère la liste des abonnements"
     * )
     * @Rest\View()
     * @Rest\Get("/wsabonnements")
     *
     *
     */
    public function getAbonnementsAction() {
        $abonnements = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('EpsiFirstBundle:Abonnement')->findAll();
        /* @var $abonnements Abonnement[] */
        return $abonnements;
    }

}

?>
