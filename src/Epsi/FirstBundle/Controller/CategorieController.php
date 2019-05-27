<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class CategorieController extends Controller {

    public function categorieAction(Request $request) {
        $categorie = new categorie();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $categorie);
        $formBuilder
                ->add('Libelle', TextType::class)
                ->add('Ajouter', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $msg=""; 
        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){               
                $msg= 'Message bien envoyé'; 
                $em = $this->getDoctrine()->getManager();              
                $em->persist($categorie);               
                $em->flush();
                }else{     
                    $msg = 'Problème';             
            } 
        }


        return $this->render('EpsiFirstBundle:Categorie:categorie.html.twig', array('form' => $form->createView(),'message'=>$msg)
        );
    }
    
    public function viewAction() {
       $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:categorie'); 
       $listeCategories=$repository->findAll();
       
       return $this->render('EpsiFirstBundle:Categorie:listCategorie.html.twig',array('listeCategories'=>$listeCategories));
    }
    
    public function modifAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:categorie');
    $categorie = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $categorie);
        $formBuilder
                ->add('Libelle', TextType::class)
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Catégorie mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:categorie:view');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Categorie:modifCategorie.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:categorie');
        $categorie = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:categorie:view');
        return $response;
        

    }
    
    /**
     * @ApiDoc(
     * description="récupère la liste des catégories"
     * )
     * @Rest\View()
     * @Rest\Get("/wscategories")
     * 
     * 
     */
    
    public function getCategoriesAction()
    {
        $categories = $this->get('doctrine.orm.entity_manager')
                   ->getRepository('EpsiFirstBundle:categorie')
                   ->findAll();
    /* @var $categories categorie[] */
        return $categories;
    }
}


