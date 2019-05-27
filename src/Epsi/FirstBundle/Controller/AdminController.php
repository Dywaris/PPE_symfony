<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

namespace Epsi\FirstBundle\Controller;


/**
 * Description of AdminController
 *
 * @author Simon
 */
class AdminController {
    public function adminAction(Request $request){
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:Utilisateur');
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class);
        $formBuilder->add('save', SubmitType::class,array('attr'=>array('class'=>'save'),'label'=>'Supprimer'));
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
        return $this->render('EpsiFirstBundle:Admin:admin.html.twig',array('listeUtilisateur' => $listeUtilisateur,'form'=>$form->createView()));
    }
}
