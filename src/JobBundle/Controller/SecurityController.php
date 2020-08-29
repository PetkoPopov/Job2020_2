<?php

namespace JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login",name="security_login")
     * @var Request $request
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function login(Request $request)
    {
        if($request->getUser()!=null){
        dump($request->getUser());die;}

        return $this->render('security/login.html.twig');
    }
}
