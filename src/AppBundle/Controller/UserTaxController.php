<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserTax;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Usertax controller.
 *
 * @Route("tipo-tributo")
 */
class UserTaxController extends Controller
{
    /**
     * Lists all userTax entities.
     *
     * @Route("/", name="tipo-tributo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userTaxes = $em->getRepository('AppBundle:UserTax')->findAll();

        return $this->render('usertax/index.html.twig', array(
            'userTaxes' => $userTaxes,
        ));
    }

    /**
     * Creates a new userTax entity.
     *
     * @Route("/new", name="tipo-tributo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userTax = new Usertax();
        $form = $this->createForm('AppBundle\Form\UserTaxType', $userTax);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userTax);
            $em->flush();

            return $this->redirectToRoute('tipo-tributo_show', array('id' => $userTax->getId()));
        }

        return $this->render('usertax/new.html.twig', array(
            'userTax' => $userTax,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userTax entity.
     *
     * @Route("/{id}", name="tipo-tributo_show")
     * @Method("GET")
     */
    public function showAction(UserTax $userTax)
    {
        $deleteForm = $this->createDeleteForm($userTax);

        return $this->render('usertax/show.html.twig', array(
            'userTax' => $userTax,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userTax entity.
     *
     * @Route("/{id}/edit", name="tipo-tributo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserTax $userTax)
    {
        $deleteForm = $this->createDeleteForm($userTax);
        $editForm = $this->createForm('AppBundle\Form\UserTaxType', $userTax);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipo-tributo_edit', array('id' => $userTax->getId()));
        }

        return $this->render('usertax/edit.html.twig', array(
            'userTax' => $userTax,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userTax entity.
     *
     * @Route("/{id}", name="tipo-tributo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserTax $userTax)
    {
        $form = $this->createDeleteForm($userTax);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userTax);
            $em->flush();
        }

        return $this->redirectToRoute('tipo-tributo_index');
    }

    /**
     * Creates a form to delete a userTax entity.
     *
     * @param UserTax $userTax The userTax entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserTax $userTax)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo-tributo_delete', array('id' => $userTax->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
