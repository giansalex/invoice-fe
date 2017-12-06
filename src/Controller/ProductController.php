<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Product controller.
 *
 * @Route("productos")
 */
class ProductController extends Controller
{
    use BaseControllerTrait;

    /**
     * Lists all product entities.
     *
     * @Route("/", name="productos_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findBy(['user' => $this->getUser()]);

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * @Route("/filter", name="productos_filter", methods={"GET"})
     */
    public function filterAction(Request $request)
    {
        $text = $request->query->get('s');
        if (empty($text)) {
            return new Response('missing filter', 400);
        }

        $em = $this->getDbManager();
        $clients = $em->getRepository(Product::class)
            ->filterByText($this->getUser(), $text);

        return $this->json($clients);
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="productos_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('App\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $exist = $em->getRepository(Product::class)->existProduct($product);
            if ($exist) {
                $form->get('code')
                    ->addError(new FormError('Código ya esta registrado'));
            } else {
                $em->persist($product);
                $em->flush();

                return $this->redirectToRoute('productos_show', array('id' => $product->getId()));
            }
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="productos_show", methods={"GET"})
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="productos_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('App\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $exist = $em->getRepository(Product::class)->existProduct($product);
            if ($exist) {
                $editForm->get('code')
                    ->addError(new FormError('Código ya esta registrado'));
            } else {
                $em->flush();
                return $this->redirectToRoute('productos_edit', array('id' => $product->getId()));
            }
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="productos_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('productos_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productos_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
