<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Plan;
use JobBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Plan controller.
 *
 * @Route("plan")
 */
class PlanController extends Controller
{
    /**
     * Lists all plan entities.
     *
     * @Route("/", name="plan_index",methods={"GET"})
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('JobBundle:Plan')->findAll();

        return $this->render('plan/index.html.twig', array(
            'plans' => $plans,

        ));
    }

//    /**
//     * Creates a new plan entity.
//     *
//     * @Route("/new", name="plan_new",methods={"GET","POST"})
//     * //Require ROLE_ADMIN for only this controller method.
//     *
//     * @var Request $request
//     * //@Security "IsGranted('IS_AUTHENTICATED_FULLY')"
//     * @return Response
//     */
//    public function newAction(Request $request)
//    {
//
//        $plan = new Plan();
////        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY',$this->getUser());
//
//
//        $form = $this->createForm('JobBundle\Form\PlanType', $plan);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($plan);
//            $em->flush();
//
//            return $this->redirectToRoute('plan_show', array('id' => $plan->getId()));
//        }
//
//        return $this->render('plan/new.html.twig', array(
//            'plan' => $plan,
//                        'form' => $form->createView()
//        ));
//    }

    /**
     * Creates a new plan entity.
     *
     * @Route("/new/{id}", name="plan_new_for_someone",methods={"GET","POST"})
     * Require ROLE_ADMIN for only this controller method.
     *
     * @var $id
     * @Security "is_granted('IS_AUTHENTICATED_FULLY')"
     *
     */
    public function newActionForSomeOne(Request $request, $id)
    {

        $plan = new Plan();
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY',$this->getUser());
        $user=$this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id'=>$id]);

//       $plan->setName($user);
        $form = $this->createForm('JobBundle\Form\PlanType', $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plan->setUsers($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('plan_show', array('id' => $plan->getJob(),'user'=>$user));
        }

        return $this->render('plan/new_for_someone.html.twig', array(
            'plan' => $plan,
            'name'=>$user,
            'id'=>$id,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/test",methods={"GET"})
     */
public function test(){
        $plan=new Plan();

        return $this->redirectToRoute("user_all");
}
    /**
     * Finds and displays a plan entity.
     *
     * @Route("/{id}", name="plan_show",methods={"GET","POST"})
     *
     */
    public function showAction(Plan $plan)
    {
        $deleteForm = $this->createDeleteForm($plan);

        return $this->render('plan/show.html.twig', array(
            'plan' => $plan,
            'user'=>$plan->getUsers(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plan entity.
     *
     * @Route("/{id}/edit", name="plan_edit",methods={"GET","POST"})
     *
     */
    public function editAction(Request $request, Plan $plan)
    {
        $deleteForm = $this->createDeleteForm($plan);
        $editForm = $this->createForm('JobBundle\Form\PlanType', $plan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plan_edit', array('id' => $plan->getId()));
        }

        return $this->render('plan/edit.html.twig', array(
            'plan' => $plan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a plan entity.
     *
     * @Route("/{id}", name="plan_delete",methods={"DELETE"})
     *
     */
    public function deleteAction(Request $request, Plan $plan)
    {
        $form = $this->createDeleteForm($plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plan);
            $em->flush();
        }

        return $this->redirectToRoute('plan_index');
    }

    /**
     * Creates a form to delete a plan entity.
     *
     * @param Plan $plan The plan entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Plan $plan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plan_delete', array('id' => $plan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
