<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/", name="sale_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDbManager();

        $sales = $em->getRepository('AppBundle:Sale')->findBy(['userId' => $this->getUserId()]);

        return $this->render('sale/index.html.twig', array(
            'sales' => $sales,
        ));
    }

    /**
     * List of Sales.
     *
     * @Route("/new", name="sale_new")
     * @Method({"GET"})
     */
    public function newAction()
    {
        return $this->render('sale/new.html.twig');
    }

    /**
     * List of Sales.
     *
     * @Route("/new", name="sale_new_save")
     * @Method({"POST"})
     */
    public function newSaveAction()
    {
        return $this->render('sale/new.html.twig');
    }

    /**
     * List of Sales.
     *
     * @Route("/new", name="sale_edit")
     * @Method({"GET"})
     */
    public function editAction()
    {
        return $this->render('sale/new.html.twig');
    }
}
