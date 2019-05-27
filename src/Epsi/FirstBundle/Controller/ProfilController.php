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

class ProfilController extends Controller {
    
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
        return $this->render('EpsiFirstBundle:Profil:listProfil.html.twig', array('listeProfil' => $listeUtilisateur,'form'=>$form->createView()));
    }
    
    public function suppressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Utilisateur');
        $utilisateur = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($utilisateur);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:Profil:view');
        return $response;
    }

}
?>