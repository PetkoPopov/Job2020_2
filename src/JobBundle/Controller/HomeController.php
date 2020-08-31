<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Plan;
use JobBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Validator\Constraints as Assert;
class  HomeController extends Controller
{
    /**
     *
     * @Route("/",name="blog_index")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     *
     */
    public function indexAction(Request $request)
    {

//dump($this->getUser()->getId());die;
        return $this->render('user/profile.html.twig',['user'=>$this->getUser()]);
    }

}
