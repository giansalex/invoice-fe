<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\SaleDetail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Sale Controller.
 *
 * @Route("ventas")
 */
class SaleController extends Controller
{
    use BaseControllerTrait;

    /**
     * List of Sales.
     *
     * @Route("/", name="sale_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDbManager();

        $sales = $em->getRepository(Sale::class)->findBy(['userId' => $this->getUserId()]);

        return $this->render('sale/index.html.twig', array(
            'sales' => $sales,
        ));
    }

    /**
     * List of Sales.
     *
     * @Route("/new", name="sale_new", methods={"GET"})
     */
    public function newAction()
    {
        return $this->render('sale/new.html.twig');
    }

    /**
     * List of Sales.
     *
     * @Route("/new", name="sale_new_save", methods={"POST"})
     */
    public function newSaveAction(Request $request)
    {
        $serializer = $this->get('serializer');
        /**@var $sale Sale */
        $sale = $serializer->deserialize($request->getContent(), Sale::class, 'json');

        $em = $this->getDbManager();

        $details = $sale->getDetails();
        $sale->setEmision(new \DateTime($sale->getEmision()));

        // incrementar correlativo doc.

        foreach ($details as $detail) {
            $det = $serializer->deserialize(json_encode($detail), SaleDetail::class, 'json');
            $det->setSale($sale);
            $em->persist($det);
        }
        $sale->setDetails([]);
        $sale->setUser($this->getUser());
        $em->persist($sale);
        $em->flush();

        return $this->json($sale);
    }

    /**
     * List of Sales.
     *
     * @Route("/new", name="sale_edit", methods={"GET"})
     */
    public function editAction()
    {
        return $this->render('sale/new.html.twig');
    }
}
