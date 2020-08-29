<?php

namespace JobBundle\Controller;

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
//        $user=$this->getUser();

        // replace this example code with whatever you need
        return $this->redirectToRoute('user_all');
    }

//    /**
//     * @Route("/{first}/{seccond}/{third}",methods={"GET"})
//     *
//     */
//    public function alabala($fisrt=null,$seccond=null,$third=null){
//        if($third!=null){
//            return $this->render("default/index.html.twig");
//        }
//
//    }
}
