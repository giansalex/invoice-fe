<?php

namespace App\Controller;

use App\Entity\Hierarchy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/", name="hierarchy_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDbManager();

        $hierarchies = $em->getRepository(Hierarchy::class)->findBy(['id' => 0]);

        return $this->render('hierarchy/index.html.twig', array(
            'hierarchies' => $hierarchies,
        ));
    }

    /**
     * @Route("/group/{id}", name="hierarchy_group", methods={"GET"})
     */
    public function getGroupAction($id)
    {
        $em = $this->getDbManager();
        $items = $em->getRepository(Hierarchy::class)->getGroup($id);

        return $this->json($items);
    }

    /**
     * Creates a new hierarchy entity.
     *
     * @Route("/new", name="hierarchy_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hierarchy = new Hierarchy();
        $form = $this->createForm('App\Form\HierarchyType', $hierarchy);
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
     * @Route("/{id}", name="hierarchy_show", methods={"GET"})
     */
    public function showAction($id)
    {
        $em = $this->getDbManager();
        $hierarchy = $em->getRepository(Hierarchy::class)->findOneBy(['id' => 0, 'code' => sprintf('%02d', $id)]);
        $hierarchies = $em->getRepository(Hierarchy::class)->findBy(['id' => $id]);

        return $this->render('hierarchy/show.html.twig', array(
            'hierarchy' => $hierarchy,
            'hierarchies' => $hierarchies,
        ));
    }

    /**
     * Displays a form to edit an existing hierarchy entity.
     *
     * @Route("/{id}/edit/{code}", name="hierarchy_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, $id, $code)
    {
        $em = $this->getDbManager();
        $hierarchy = $em->getRepository(Hierarchy::class)
                        ->findOneBy(['id' => $id, 'code' => $code]);

        $deleteForm = $this->createDeleteForm($hierarchy);
        $editForm = $this->createForm('App\Form\HierarchyType', $hierarchy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDbManager()->flush();

            return $this->redirectToRoute('hierarchy_show', array('id' => $hierarchy->getId()));
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
     * @Route("/{id}", name="hierarchy_delete", methods={"DELETE"})
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
     * @return \Symfony\Component\Form\FormInterface The form
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
