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

        return $this->render('sale/index.htm.twig', array(
            'sales' => $sales,
        ));
    }
}
