<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Wage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Wage controller.
 *
 * @Route("wage")
 */
class WageController extends Controller
{
    /**
     * Lists all wage entities.
     *
     * @Route("/", name="wage_index",methods={"GET"})
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wages = $em->getRepository('JobBundle:Wage')->findAll();

        return $this->render('wage/index.html.twig', array(
            'wages' => $wages,
        ));
    }

    /**
     * Creates a new wage entity.
     *
     * @Route("/new", name="wage_new",methods={"GET","POST"})
     *
     *
     */
    public function newAction(Request $request)
    {
        $wage = new Wage();
        $form = $this->createForm('JobBundle\Form\WageType', $wage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wage);
            $em->flush();

            return $this->redirectToRoute('wage_show', array('id' => $wage->getId()));
        }

        return $this->render('wage/new.html.twig', array(
            'wage' => $wage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a wage entity.
     *
     * @Route("/{id}", name="wage_show",methods={"GET"})
     *
     */
    public function showAction(Wage $wage)
    {
        $deleteForm = $this->createDeleteForm($wage);

        return $this->render('wage/show.html.twig', array(
            'wage' => $wage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing wage entity.
     *
     * @Route("/{id}/edit", name="wage_edit",methods={"GET","POST"})
     *
     */
    public function editAction(Request $request, Wage $wage)
    {
        $deleteForm = $this->createDeleteForm($wage);
        $editForm = $this->createForm('JobBundle\Form\WageType', $wage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wage_edit', array('id' => $wage->getId()));
        }

        return $this->render('wage/edit.html.twig', array(
            'wage' => $wage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a wage entity.
     *
     * @Route("/{id}", name="wage_delete",methods={"DELETE"})
     *
     */
    public function deleteAction(Request $request, Wage $wage)
    {
        $form = $this->createDeleteForm($wage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wage);
            $em->flush();
        }

        return $this->redirectToRoute('wage_index');
    }

    /**
     * Creates a form to delete a wage entity.
     *
     * @param Wage $wage The wage entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Wage $wage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wage_delete', array('id' => $wage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
