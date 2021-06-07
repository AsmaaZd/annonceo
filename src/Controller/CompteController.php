<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/profil")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/afficher", name="profil")
     * @Security("is_granted('ROLE_USER')")
     */
    public function profil(){
        

        return $this->render('compte/profil.html.twig');
    }
}
