<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DocNumber;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Docnumber controller.
 *
 * @Route("series-documento")
 */
class DocNumberController extends Controller
{
    use BaseControllerTrait;

    /**
     * Lists all docNumber entities.
     *
     * @Route("/", name="series-documento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $docNumbers = $em->getRepository('AppBundle:DocNumber')->findAll();

        return $this->render('docnumber/index.html.twig', array(
            'docNumbers' => $docNumbers,
        ));
    }

    /**
     * @Route("/by-doc", name="serie_by_doc")
     * @Method({"POST"})
     */
    public function serieForDocAction(Request $request)
    {
       $obj = json_decode($request->getContent());
       if (!isset($obj->doc)) {
           return new Response('missing doc', 400);
       }

       $em = $this->getDbManager();
       $serie = $em->getRepository('AppBundle:DocNumber')
                ->findOneBy(['user' => $this->getUser(), 'code' => $obj->doc]);

       if (!$serie) {
           $this->createNotFoundException();
       }

       return new JsonResponse([
           'serie' => $serie->getSerie(),
           'correlativo' => $serie->getCorrelativo(),
       ]);
    }

    /**
     * Creates a new docNumber entity.
     *
     * @Route("/new", name="series-documento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $docNumber = new Docnumber();
        $form = $this->createForm('AppBundle\Form\DocNumberType', $docNumber, $this->getChoiceOptions());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $docNumber->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($docNumber);
            $em->flush();

            return $this->redirectToRoute('series-documento_show', array('id' => $docNumber->getId()));
        }

        return $this->render('docnumber/new.html.twig', array(
            'docNumber' => $docNumber,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a docNumber entity.
     *
     * @Route("/{id}", name="series-documento_show")
     * @Method("GET")
     */
    public function showAction(DocNumber $docNumber)
    {
        $deleteForm = $this->createDeleteForm($docNumber);

        return $this->render('docnumber/show.html.twig', array(
            'docNumber' => $docNumber,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing docNumber entity.
     *
     * @Route("/{id}/edit", name="series-documento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DocNumber $docNumber)
    {
        $deleteForm = $this->createDeleteForm($docNumber);
        $editForm = $this->createForm('AppBundle\Form\DocNumberType', $docNumber, $this->getChoiceOptions());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('series-documento_index');
        }

        return $this->render('docnumber/edit.html.twig', array(
            'docNumber' => $docNumber,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a docNumber entity.
     *
     * @Route("/{id}", name="series-documento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DocNumber $docNumber)
    {
        $form = $this->createDeleteForm($docNumber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($docNumber);
            $em->flush();
        }

        return $this->redirectToRoute('series-documento_index');
    }

    /**
     * Creates a form to delete a docNumber entity.
     *
     * @param DocNumber $docNumber The docNumber entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DocNumber $docNumber)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('series-documento_delete', array('id' => $docNumber->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function getChoiceOptions()
    {
        $em = $this->getDbManager();
        $values = $em->getRepository('AppBundle:Hierarchy')->getGroup(1);

        return ['docs' => $values];
    }
}
