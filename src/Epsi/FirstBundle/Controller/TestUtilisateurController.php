<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\TestUtilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Description of TestUtilisateurController
 *
 * @author julien
 */
class TestUtilisateurController extends Controller {

    public function viewAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:TestUtilisateur');
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class);

        $formBuilder->add('save', SubmitType::class, array('attr' => array('class' => 'save'), 'label' => 'Supprimer'));

        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $cocher = $request->request->get('cocher');
                foreach ($cocher as $id) {
                    $listeTestUtilisateur = $repository->deleteTestUtilisateur($id);
                }
            }
        }
        $listeTestUtilisateur = $repository->findAll();
        return $this->render('EpsiFirstBundle:TestUtilisateur:listTestUtilisateur.html.twig', array('listeTestUtilisateur' => $listeTestUtilisateur, 'form' => $form->createView()));
    }

    public function AjoutTestUtilisateurAction(Request $request) {
        $TestUtilisateur = new TestUtilisateur();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $TestUtilisateur);
        $formBuilder
                ->add('date', DateType::class)
                ->add('test', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:test',
                    'choice_label' => 'niveau',
                ))
                ->add('utilisateur', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:Utilisateur',
                    'choice_label' => 'username',
                ))
                ->add('Envoyer', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $msg = 'Envoyé';
                $em = $this->getDoctrine()->getManager();
                $em->persist($TestUtilisateur);
                $em->flush();
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:TestUtilisateur:AjoutTestUtilisateur.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    public function suppressionAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:TestUtilisateur');
        $test = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();
        $response = $this->forward('EpsiFirstBundle:TestUtilisateur:view');
        return $response;
    }

    public function modificationAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:TestUtilisateur');
        $TestUtilisateur = $repository->find($id);

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $TestUtilisateur);
        $formBuilder
                ->add('date', DateType::class)
                ->add('test', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:test',
                    'choice_label' => 'niveau',
                ))
                ->add('utilisateur', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:Utilisateur',
                    'choice_label' => 'username',
                ))
                ->add('Envoyer', SubmitType::class)
        ;
        $msg = '';
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $msg = 'Test mise à jour';
                $em = $this->getDoctrine()->getManager();
                $em->persist($TestUtilisateur);
                $em->flush();
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:TestUtilisateur:ModifTestUtilisateur.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    /**
     * @ApiDoc(
     * description="récupère la liste des Test et Utilisateur"
     * )
     * @Rest\View()
     * @Rest\Get("/wstestutilisateur")
     *
     *
     */
    public function getTestutilisateurAction() {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:TestUtilisateur');
        $TestUtilisateur = $repository->findAllModif();

        /* @var $TestUtilisateur TestUtilisateur[] */
        return $TestUtilisateur;
    }

}
