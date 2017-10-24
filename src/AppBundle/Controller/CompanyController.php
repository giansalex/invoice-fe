<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Company Controller.
 *
 * @Route("empresa")
 */
class CompanyController extends Controller
{
    use BaseControllerTrait;

    /**
     * @Route("/", name="company_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDbManager();
        $user = $this->getUser();
        $company = $em->getRepository('AppBundle:Company')
                      ->findOneBy(['user' => $user]);
        if (!$company) {
            $company = new Company();
        }
        $editForm = $this->createForm('AppBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if (!$company->getId()) {
                $company->setUser($user);
                $em->persist($company);
            }
            $em->flush();
            //return $this->redirectToRoute('company_index');
        }

        return $this->render('company/edit.html.twig', array(
            'company' => $company,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/direccion", name="company_address")
     */
    public function addressAction(Request $request)
    {
        $em = $this->getDbManager();
        $user = $this->getUser();
        $address = $em->getRepository('AppBundle:Address')
            ->findOneBy(['user' => $user]);
        if (!$address) {
            $address = new Address();
        }
        $editForm = $this->createForm('AppBundle\Form\AddressType', $address);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if (!$address->getId()) {
                $address->setUser($user);
                $em->persist($address);
            }
            $em->flush();
            //return $this->redirectToRoute('company_address');
        }

        return $this->render('company/address.html.twig', array(
            'address' => $address,
            'edit_form' => $editForm->createView(),
        ));
    }
}
