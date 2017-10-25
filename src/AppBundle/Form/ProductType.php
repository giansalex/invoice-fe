<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('code', TextType::class, ['label' => 'Código'])
            ->add('description', TextType::class, ['label' => 'Descripción'])
            ->add('price', NumberType::class, ['label' => 'Precio'])
            ->add('unitCode', ChoiceType::class, [
                'choices' => $this->getUnitChoices($user),
                'label' => 'Unidad de Medida',
            ])
            ->add('taxCode', ChoiceType::class, [
                'choices' => $this->getTaxChoices(),
                'label' => 'Afectación IGV',
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
