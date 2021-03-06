<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Job;
use JobBundle\Entity\Plan;
use JobBundle\Entity\Report;
use JobBundle\Entity\User;
use JobBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

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

        $plans = $em->getRepository(Plan::class)->findAll();
        $plansUndone=$em->getRepository(Plan::class)->findBy(['isDone'=>false]);
        return $this->render('plan/index.html.twig', array(
            'plans' => $plans,
            'plans_undone'=>$plansUndone

        ));
    }

    /**
     * Creates a new plan entity.
     *
     * @Route("/new/{id}", name="plan_new_for_someone",methods={"GET","POST"})
     * @var Request $request
     * @var User $user
     * //@Security "is_granted('IS_AUTHENTICATED_FULLY')"
     * @return Response
     */
    public function newActionForSomeOne(Request $request,User $user)
    {
        $plan = new Plan();
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY',$this->getUser());
//        var_dump($user);die;
         $plan->setUsers($user);
         $plan->setName($user->getUserName());
        $form = $this->createForm('JobBundle\Form\PlanType',$plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
         //   $name=($request->request->getIterator()->current()['name']);//от регистер формата
            //иметио на човека за когото е плана
//            $user=$this
//                ->getDoctrine()
//                ->getRepository(User::class)
//                ->findOneBy(['userName'=>$name]);
//            $plan->setUsers($user);
            $allJobs=
                $this->getDoctrine()->getRepository(Job::class)->findAll();
//            var_dump($request->request->getIterator()->current());die;
            $workName=$request->request->getIterator()->current()['job'];
             $job=new Job();
             $job->setNameWork($workName);
            $plan->setWork($job);
//            $report=new Report();

//            $report->setNotice("still nothing");
//            $plan->setReport($report);
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($job);
            $em->flush();

            $plan->setIsDone(false);

            $em->persist($plan);
            $em->flush();

            if(!in_array($workName,$allJobs)){
             return $this->redirectToRoute('job_unpayed',['id'=>$job->getId(),'job'=>$job]);
            }else{ return $this->redirectToRoute("plan_all");}
        }
        return $this->render('plan/new_for_someone.html.twig', array(
            'plan' => $plan,
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a plan entity.
     *
     * @Route("/show", name="plan_show" , methods={"GET","POST"})
     *
     */
    public function showAction(Plan $plan)
    {

        $deleteForm = $this->createDeleteForm($plan);

        return $this->render('plan/show.html.twig', array(
            'plan' => $plan,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing plan entity.
     *
     * @Route("/{id}/edit", name="plan_edit",methods={"GET","POST"})
     * @var Request $request
     * @var Plan $plan
     * @return Response
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
    /**
     * Displays a form to edit an existing plan entity.
     *
     * @Route("/done/{id}" , name="plan_done" , methods={"GET","POST"})
     * @var Request $request
     * @var User $user
     * @return Response
     */
    public function done(Request $request, Plan $plan)
    {
        $user=$this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['userName'=>$plan->getName()]);
        /**
         * @var User $user
         */
//        var_dump($user);die;
        $user->setIntern($user->getIntern()+1);
        $form=
            $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        $this->getDoctrine()->getManager()->flush();
        $editForm = $this->createForm('JobBundle\Form\PlanType', $plan);
        $plan->setIsDone(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('plan_all');
    }
    /**
     * @Route("/all",name="plan_all",methods={"GET"})
     *
     * @return Response
     */
    public function planAll(){
        $plans=
            $this->getDoctrine()
                ->getRepository(Plan::class)
                ->findBy(['isDone'=>false]);
        return $this->render('plan/all.html.twig',['plans'=>$plans]);
    }

    /**
     * Displays a form to edit an existing plan entity.
     *
     * @Route("/{id}/edit2", name="plan_edit2",methods={"GET","POST"})
     * @var Request $request
     * @var Plan $plan
     * @return Response
     */
    public function editAction2(Request $request, Plan $plan)
    {
        $newPlan=new Plan();
        $newPlan->setName($plan->getName());
        $newPlan->setIsDone(false);
        $user=$this->getDoctrine()->getRepository(User::class)
            ->findOneBy(['userName'=>$plan->getName()]);

         $newPlan->setUsers($user);
        $form = $this->createForm('JobBundle\Form\PlanType', $newPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $em= $this->getDoctrine()->getManager();
                $em->persist($newPlan);
                    $em->flush();

            return $this->redirectToRoute('plan_index', array('id' => $newPlan->getId()));
        }

        return $this->render('plan/edit2.html.twig', array(
            'plan' => $newPlan,
            'edit_form' => $form->createView(),

        ));
    }

    /**
     *
     * @Route("/userFromPlan/{id}",name="user_from_plan")
     *
     * @param Request  $request
     * @param Plan $pan
     *
     * @return Response
     */
    public function userFromPlan(Plan $plan , Request $request){
        $user=$this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['userName'=>$plan->getName()]);
        $id=$user->getId();
        return $this->redirectToRoute('user_profile',['id'=>$id]);
    }




}