<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Company Controller.
 *
 * @Route("empresa")
 */
class CompanyController extends AbstractController
{
    use BaseControllerTrait;

    /**
     * @Route("/", name="company_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDbManager();
        $user = $this->getUser();
        $company = $em->getRepository(Company::class)
                      ->findOneBy(['user' => $user]);
        if (!$company) {
            $company = new Company();
        }
        $editForm = $this->createForm('App\Form\CompanyType', $company);
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
        $address = $em->getRepository('App:Address')
            ->findOneBy(['user' => $user]);
        if (!$address) {
            $address = new Address();
        }
        $editForm = $this->createForm('App\Form\AddressType', $address);
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
