<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hierarchy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Hierarchy controller.
 *
 * @Route("hierarchy")
 */
class HierarchyController extends Controller
{
    use BaseControllerTrait;

    /**
     * Lists all hierarchy entities.
     *
     * @Route("/", name="hierarchy_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDbManager();

        $hierarchies = $em->getRepository('AppBundle:Hierarchy')->findBy(['id' => 0]);

        return $this->render('hierarchy/index.html.twig', array(
            'hierarchies' => $hierarchies,
        ));
    }

    /**
     * @Route("/group/{id}", name="hierarchy_group")
     * @Method({"GET"})
     */
    public function getGroupAction($id)
    {
        $em = $this->getDbManager();
        $items = $em->getRepository('AppBundle:Hierarchy')->getGroup($id);

        return $this->json($items);
    }

    /**
     * Creates a new hierarchy entity.
     *
     * @Route("/new", name="hierarchy_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hierarchy = new Hierarchy();
        $form = $this->createForm('AppBundle\Form\HierarchyType', $hierarchy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDbManager();
            $em->persist($hierarchy);
            $em->flush();

            return $this->redirectToRoute('hierarchy_index');
        }

        return $this->render('hierarchy/new.html.twig', array(
            'hierarchy' => $hierarchy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hierarchy entity.
     *
     * @Route("/{id}", name="hierarchy_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDbManager();
        $hierarchy = $em->getRepository('AppBundle:Hierarchy')->findOneBy(['id' => 0, 'code' => sprintf('%02d', $id)]);
        $hierarchies = $em->getRepository('AppBundle:Hierarchy')->findBy(['id' => $id]);

        return $this->render('hierarchy/show.html.twig', array(
            'hierarchy' => $hierarchy,
            'hierarchies' => $hierarchies,
        ));
    }

    /**
     * Displays a form to edit an existing hierarchy entity.
     *
     * @Route("/{id}/edit", name="hierarchy_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hierarchy $hierarchy)
    {
        $deleteForm = $this->createDeleteForm($hierarchy);
        $editForm = $this->createForm('AppBundle\Form\HierarchyType', $hierarchy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDbManager()->flush();

            return $this->redirectToRoute('hierarchy_edit', array('id' => $hierarchy->getId()));
        }

        return $this->render('hierarchy/edit.html.twig', array(
            'hierarchy' => $hierarchy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hierarchy entity.
     *
     * @Route("/{id}", name="hierarchy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hierarchy $hierarchy)
    {
        $form = $this->createDeleteForm($hierarchy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDbManager();
            $em->remove($hierarchy);
            $em->flush();
        }

        return $this->redirectToRoute('hierarchy_index');
    }

    /**
     * Creates a form to delete a hierarchy entity.
     *
     * @param Hierarchy $hierarchy The hierarchy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hierarchy $hierarchy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hierarchy_delete', array('id' => $hierarchy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
