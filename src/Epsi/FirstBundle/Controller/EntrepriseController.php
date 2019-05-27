<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\Entreprise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class EntrepriseController extends Controller {

    public function entrepriseAction(Request $request) {
        $entreprise = new Entreprise ();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $entreprise);
        $formBuilder
                ->add('nom', TextType::class)
                ->add('CodePostal', TextType::class)
                ->add('Ville', TextType::class)
                ->add('Adresse', TextType::class)
                ->add('NumTel', TextType::class)
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Entreprise Ajouté !';
                $em = $this->getDoctrine()->getManager();
                $em->persist($entreprise);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Entreprise:entrepriseview');
                return $response;
            } else {
                $msg = 'Problème, votre entreprise n\' a pas pu être ajouter';
            }
        }

        return $this->render('EpsiFirstBundle:Entreprise:entreprise.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    public function modificationAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Entreprise');
    $entreprise = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $entreprise);
        $formBuilder
                ->add('nom', TextType::class)
                ->add('CodePostal', TextType::class)
                ->add('Ville', TextType::class)
                ->add('Adresse', TextType::class)
                ->add('NumTel', TextType::class)
                ->add('Ajouter', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Entreprise mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($entreprise);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Entreprise:entrepriseview');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Entreprise:modifEntreprise.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Entreprise');
        $entreprise = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($entreprise);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:Entreprise:entrepriseview');
        return $response;
        

    }
    
    public function entrepriseviewAction() {

        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Entreprise');
        $listeEntreprises = $repository->findAll();
        return $this->render('EpsiFirstBundle:Entreprise:listEntreprise.html.twig', array('listeEntreprises' => $listeEntreprises));
    }

    /**
     * @ApiDoc(
     * description="récupère la liste des entreprises"
     * )
     * @Rest\View()
     * @Rest\Get("/wsentreprises")
     *
     *
     */
    public function getEntreprisesAction() {
        $entreprises = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('EpsiFirstBundle:Entreprise')->findAll();
        /* @var $entreprises Entreprise[] */
        return $entreprises;
    }

}
?>

