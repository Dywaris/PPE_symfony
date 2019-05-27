<?php

namespace Epsi\FirstBundle\Controller;

use Epsi\FirstBundle\Entity\test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Epsi\FirstBundle\Repository\testRepository;

class TestController extends Controller {

    public function AjoutTestAction(Request $request) {
        $test = new test();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $test);
        $formBuilder
                ->add('niveau', TextType::class)
                ->add('libelle', TextType::class)
                ->add('theme', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:Theme',
                    'choice_label' => 'libelle',
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
                $em->persist($test);
                $em->flush();
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Test:AjoutTest.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    public function viewAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:test');
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
        $listeTest = $repository->findAll();
        $verif = false;
        return $this->render('EpsiFirstBundle:Test:listTest.html.twig', array('listeTest' => $listeTest, 'verif' => $verif, 'form' => $form->createView()));
    }

    public function supressionAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:test');
        $test = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();
        $response = $this->forward('EpsiFirstBundle:test:view');
        return $response;
    }

    public function modificationAction(Request $request, $id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:test');
        $test = $repository->find($id);

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $test);
        $formBuilder
                ->add('niveau', TextType::class)
                ->add('libelle', TextType::class)
                ->add('theme', EntityType::class, array(
                    'class' => 'EpsiFirstBundle:Theme',
                    'choice_label' => 'libelle',
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
                $em->persist($test);
                $em->flush();
            } else {
                $msg = 'Problème';
            }
        }
        return $this->render('EpsiFirstBundle:Test:ModifTest.html.twig', ['form' => $form->createView(), 'message' => $msg]
        );
    }

    public function startTestAction(Request $request, $id) {
        $cpt = 0;
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:test');
        $test = $repository->findMotByTest($id);
        $testReponse = $repository->findMotAnglaisByTest($id);
        $size = count($test);
        $reponse = array();
        if ($request->isMethod('POST')) {
            for ($i = 0; $i < $size; $i++) {
                $temp = $request->get('' . $i . '');
                array_push($reponse, $temp);
            }
            $plop = $testReponse[0];
            //var_dump($testReponse[0]);
            foreach ($reponse as $uneReponse ) {
                foreach ($testReponse as $key => $laReponse) {
                    //var_dump($laReponse);
                    
                    if ($uneReponse == $laReponse) {
                        $cpt++;
                        
                    }
                }
            }
        }
        //var_dump($cpt);
        return $this->render('EpsiFirstBundle:Test:RealiserTest.html.twig', ['MotTest' => $test]);
    }

    /**
     * @ApiDoc(
     * description="récupère la liste des tests"
     * )
     * @Rest\View()
     * @Rest\Get("/wstest")
     *
     *
     */
    public function getTestsAction() {
        $repository = $this->getDoctrine()->getManager()->getRepository('EpsiFirstBundle:test');

        $test = $repository->findAllModif();

        /* @var $test test[] */
        return $test;
    }

}
