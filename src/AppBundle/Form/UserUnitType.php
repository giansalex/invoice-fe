<?php

namespace AppBundle\Form;

use AppBundle\Entity\Hierarchy;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserUnitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', EntityType::class, [
                'class' => Hierarchy::class,
                'choice_label' => function ($item) {
                    /**@var $item Hierarchy */
                    return $item->getCode() . ' - ' . $item->getDescription();
                },
                'choice_value' => 'code',
                'query_builder' => function (EntityRepository $er) {
                    /**@var $er \AppBundle\Repository\HierarchyRepository */
                    return $er->getGroupQuery(3);
                },
            ])
            ->add('description');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UserUnit',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_userunit';
    }
}
