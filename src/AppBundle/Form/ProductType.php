<?php

namespace AppBundle\Form;

use AppBundle\Entity\Hierarchy;
use AppBundle\Entity\UserUnit;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProductType extends AbstractType
{
    private $tokenStorage;
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(TokenStorageInterface $tokenStorage, ObjectManager $manager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $builder
            ->add('code')
            ->add('description')
            ->add('price', NumberType::class)
            ->add('unitCode', ChoiceType::class, [
                'choices' => $this->getUnitChoices($user)
            ])
            ->add('taxCode', ChoiceType::class, [
                'choices' => $this->getTaxChoices(),

            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }

    private function getUnitChoices($user)
    {
        $units = $this->manager->getRepository('AppBundle:UserUnit')
            ->findBy(['user' => $user]);


        $choices = [];
        foreach ($units as $item) {
            $choices[$item->getCode() . ' - ' . $item->getDescription()] = $item->getCode();
        }

        return $choices;
    }

    private function getTaxChoices()
    {
        $taxs = $this->manager
            ->getRepository('AppBundle:Hierarchy')
            ->getGroup(7);

        $choices = [];
        foreach ($taxs as $item) {
            $choices[$item->getCode() . ' - ' . $item->getDescription()] = $item->getCode();
        }

        return $choices;
    }
}
