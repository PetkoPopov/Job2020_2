<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Plan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

class SecurityController extends Controller
{

    /**
     * @Route("/login",name="security_login")
     * @var Request $request
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function login(Request $request)
    {

        return $this->render('security/login.html.twig');
    }
    /**
     * @Route("/logout",name="security_logout")
     */
    public function logout(){
        throw new \Exception("logout failed");
    }

}
