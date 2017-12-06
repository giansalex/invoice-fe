<?php

namespace App\Form;

use App\Entity\Hierarchy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTaxType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('userId');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\UserTax',
            'taxs' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_usertax';
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
