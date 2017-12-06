<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Client controller.
 *
 * @Route("client")
 */
class ClientController extends AbstractController
{
    use BaseControllerTrait;

    /**
     * Lists all client entities.
     *
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository(Client::class)->findBy(['userId' => $this->getUserId()]);

        return $this->render('client/index.html.twig', array(
            'clients' => $clients,
        ));
    }

    /**
     * @Route("/filter", name="client_filter", methods={"GET"})
     */
    public function getClientsAction(Request $request)
    {
        $text = $request->query->get('s');
        if (empty($text)) {
            return new Response('missing filter', 400);
        }

        $em = $this->getDbManager();
        $clients = $em->getRepository(Client::class)
            ->filterByText($this->getUser(), $text);

        return $this->json($clients);
    }

    /**
     * Creates a new client entity.
     *
     * @Route("/new", name="client_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $client = new Client();
        $form = $this->createForm('App\Form\ClientType', $client, $this->getChoiceOptions());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('client_show', array('id' => $client->getId()));
        }

        return $this->render('client/new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function showAction(Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/show.html.twig', array(
            'client' => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     * @Route("/{id}/edit", name="client_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('App\Form\ClientType', $client, $this->getChoiceOptions());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($client->getUserId() != $this->getUserId()) { //TODO: Validar que el usuario fuel el creador.
                $this->createAccessDeniedException();
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client entity.
     *
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Client $client)
    {
        $form = $this->createDeleteForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function getChoiceOptions()
    {
        $em = $this->getDbManager();
        $values = $em->getRepository('App:Hierarchy')->getGroup(6);

        return ['docs' => $values];
    }
}
