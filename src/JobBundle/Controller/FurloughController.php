<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Furlough;
use JobBundle\Entity\User;
use JobBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Furlough controller.
 *
 * @Route("furlough")
 */
class FurloughController extends Controller
{
    /**
     * Lists all furlough entities.
     *
     * @Route("/", name="furlough_index",methods={"GET"})
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $furloughs = $em->getRepository('JobBundle:Furlough')->findAll();

        return $this->render('furlough/index.html.twig', array(
            'furloughs' => $furloughs,
        ));
    }

    /**
     * Creates a new furlough entity.
     *
     * @Route("/new/{id}", name="furlough_new",methods={"GET","POST"})
     * @param integer $id
     */
    public function newAction(Request $request,$id)
    {


        $furlough = new Furlough();
          $user =$this->getDoctrine()->getRepository(User::class)
              ->findOneBy(['id'=>$id]);
          $furlough->setUser($user);
$furlough->setName($user->getUserName());
        $form = $this->createForm('JobBundle\Form\FurloughType', $furlough);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $furlough->setIsPermited(false);
            $furlough->setUser($this->getUser());
//            $furlough->setName("");
            $em = $this->getDoctrine()->getManager();
            $em->persist($furlough);
            $em->flush();

            return $this->redirectToRoute('furlough_show', array('id' => $furlough->getId()));
        }

        return $this->render('furlough/new.html.twig', array(
            'furlough' => $furlough,
            'user'=>$user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a furlough entity.
     *
     * @Route("/{id}", name="furlough_show",methods={"GET"})
     *
     */
    public function showAction(Furlough $furlough)
    {
        $deleteForm = $this->createDeleteForm($furlough);

        return $this->render('furlough/show.html.twig', array(
            'furlough' => $furlough,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing furlough entity.
     *
     * @Route("/{id}/edit", name="furlough_edit",methods={"GET","POST"})
     *
     */
    public function editAction(Request $request, Furlough $furlough)
    {
        $deleteForm = $this->createDeleteForm($furlough);
        $editForm = $this->createForm('JobBundle\Form\FurloughType', $furlough);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('furlough_edit', array('id' => $furlough->getId()));
        }

        return $this->render('furlough/edit.html.twig', array(
            'furlough' => $furlough,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a furlough entity.
     *
     * @Route("/{id}", name="furlough_delete",methods={"DELETE"})
     *
     */
    public function deleteAction(Request $request, Furlough $furlough)
    {
        $form = $this->createDeleteForm($furlough);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($furlough);
            $em->flush();
        }

        return $this->redirectToRoute('furlough_index');
    }

    /**
     * Creates a form to delete a furlough entity.
     *
     * @param Furlough $furlough The furlough entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Furlough $furlough)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('furlough_delete', array('id' => $furlough->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/allowed/{id}",name="furlough_allowed", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
public function allowed(Request $request,Furlough $furlough){

$user=$this->getDoctrine()->getRepository(User::class)
    ->findOneBy(['userName'=>$furlough->getName()]);
if($user->getFurlough()-$furlough->getDays()<0){
 return $this->render('furlough/denied.html.twig',['user'=>$user]);
}else {
    $user->setFurlough($user->getFurlough() - $furlough->getDays());
    $userForm = $this->createForm(UserType::class, $user);
    $userForm->handleRequest($request);
    $this->getDoctrine()->getManager()->flush();
    $form = $this->createForm('JobBundle\Form\FurloughType', $furlough);
    $form->handleRequest($request);
    $furlough->setIsPermited(true);
    $this->getDoctrine()->getManager()->flush();

    return $this->redirectToRoute('furlough_index');

}
}

}
