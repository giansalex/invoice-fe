<?php

namespace AppBundle\Form;

use AppBundle\Entity\Hierarchy;
use AppBundle\Entity\UserUnit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('description')
            ->add('price', NumberType::class)
            ->add('unitCode', ChoiceType::class, [
                'choices' => $this->buildUnits($options['units'])
            ])
            ->add('taxCode', ChoiceType::class, [
                'choices' => $this->buildTaxs($options['taxs'])
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product',
            'units' => [],
            'taxs' => [],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }

    protected function buildUnits($units) {
        $choices = [];

        foreach ($units as $item) {
            /**@var $item UserUnit */
            $choices[$item->getCode() . ' - ' . $item->getDescription()] = $item->getCode();
        }

        return $choices;
    }

    protected function buildTaxs($taxs) {
        $choices = [];

        foreach ($taxs as $item) {
            /**@var $item Hierarchy */
            $choices[$item->getCode() . ' - ' . $item->getDescription()] = $item->getCode();
        }

        return $choices;
    }
}
