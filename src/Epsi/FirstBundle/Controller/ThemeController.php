<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ThemeController extends Controller {

    public function themeAction(Request $request) {
        $theme = new Theme();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $theme);
        $formBuilder
                ->add('libelle', TextType::class)
                ->add('Envoyer', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Envoyé';
                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Theme:view');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Theme:theme.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    public function modificationAction(Request $request, $id) {
    $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Theme');
    $theme = $repository->find($id);  
    
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $theme);
        $formBuilder
                ->add('libelle', TextType::class)
                ->add('Envoyer', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
                if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Thème mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();
                $response = $this ->forward('EpsiFirstBundle:Theme:view');
                return $response;
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Theme:modifTheme.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }
    
    public function supressionAction(Request $request, $id){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Theme');
        $theme = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($theme);
        $em->flush();
        $response = $this ->forward('EpsiFirstBundle:Theme:view');
        return $response;
        

    }

    public function viewAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Theme');
        $formBuilder=$this->get('form.factory')->createBuilder(FormType::class);
        
        $formBuilder->add('save', SubmitType::class,
            array('attr'=>array('class'=>'save'),'label'=>'Supprimer'));
        
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')){
            $form -> handleRequest($request);
            if($form->isValid()){
                $cocher = $request->request->get('cocher');
                foreach($cocher as $id){                   
                    $listeThemes = $repository->deleteTheme($id);
                }
            }
        }
        $listeThemes = $repository->findAll();
        return $this->render('EpsiFirstBundle:Theme:listTheme.html.twig', array('listeThemes' => $listeThemes,'form'=>$form->createView()));
    }
    
    public function viewTestbyThemeAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Theme');
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class);

        $formBuilder->add('save', SubmitType::class, array('attr' => array('class' => 'save'), 'label' => 'Supprimer'));

        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $cocher = $request->request->get('cocher');
                foreach ($cocher as $id) {
                    $listeTest = $repository->deleteTest($id);
                }
            }
        }
        $listeTest = $repository-> selectTestByTheme($id);
        $verif = true;
        return $this->render('EpsiFirstBundle:Test:listTest.html.twig', array('listeTest' => $listeTest,'verif'=>$verif ,'form' => $form->createView()));
    }

    /**
     * @ApiDoc(
     * description="récupère la liste des thémes"
     *)
    * @Rest\View()
    * @Rest\Get("/wsthemes")
    *
    *
    */
    public function getThemesAction()
    {
    $themes = $this->get('doctrine.orm.entity_manager')
            ->getRepository('EpsiFirstBundle:Theme')->findAll();
    /* @var $themes Theme[] */
    return $themes;
}

}
