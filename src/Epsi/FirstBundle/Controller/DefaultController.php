<?php

namespace Epsi\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('EpsiFirstBundle:Default:index.html.twig');
    }

    public function themeAction() {
        return $this->render('EpsiFirstBundle:Default:theme.html.twig');
    }
    
    public function categorieAction() {
        return $this->render('EpsiFirstBundle:Default:categorie.html.twig');
    }

}
