<?php

namespace App\Controller;

use App\Entity\UserUnit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userunit controller.
 *
 * @Route("unidades")
 */
class UserUnitController extends Controller
{
    use BaseControllerTrait;

    /**
     * Lists all userUnit entities.
     *
     * @Route("/", name="unidades_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDbManager();

        $userUnits = $em->getRepository(UserUnit::class)->findBy(['userId' => $this->getUserId()]);

        return $this->render('userunit/index.html.twig', array(
            'userUnits' => $userUnits,
        ));
    }

    /**
     * Creates a new userUnit entity.
     *
     * @Route("/new", name="unidades_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userUnit = new Userunit();

        $form = $this->createForm('App\Form\UserUnitType', $userUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userUnit->setUser($this->getUser());
            $em = $this->getDbManager();
            $em->persist($userUnit);
            $em->flush();

            return $this->redirectToRoute('unidades_show', array('id' => $userUnit->getId()));
        }

        return $this->render('userunit/new.html.twig', array(
            'userUnit' => $userUnit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userUnit entity.
     *
     * @Route("/{id}", name="unidades_show")
     * @Method("GET")
     */
    public function showAction(UserUnit $userUnit)
    {
        $deleteForm = $this->createDeleteForm($userUnit);

        return $this->render('userunit/show.html.twig', array(
            'userUnit' => $userUnit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userUnit entity.
     *
     * @Route("/{id}/edit", name="unidades_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserUnit $userUnit)
    {
        $deleteForm = $this->createDeleteForm($userUnit);
        $editForm = $this->createForm('App\Form\UserUnitType', $userUnit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDbManager()->flush();

            return $this->redirectToRoute('unidades_edit', array('id' => $userUnit->getId()));
        }

        return $this->render('userunit/edit.html.twig', array(
            'userUnit' => $userUnit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userUnit entity.
     *
     * @Route("/{id}", name="unidades_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserUnit $userUnit)
    {
        $form = $this->createDeleteForm($userUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userUnit->getUserId() == $this->getUserId()) {
                $em = $this->getDbManager();
                $em->remove($userUnit);
                $em->flush();
            }
        }

        return $this->redirectToRoute('unidades_index');
    }

    /**
     * Creates a form to delete a userUnit entity.
     *
     * @param UserUnit $userUnit The userUnit entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(UserUnit $userUnit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unidades_delete', array('id' => $userUnit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
