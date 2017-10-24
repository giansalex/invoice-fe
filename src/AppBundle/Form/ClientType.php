<?php

namespace AppBundle\Form;

use AppBundle\Entity\Hierarchy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeDoc', ChoiceType::class, [
                'choices' => $this->buildDocs($options['docs'])
            ])
            ->add('document')
            ->add('nameRzs')
            ->add('comercialName')
            ->add('email', EmailType::class, [
                'required' => false
            ])
            ->add('address')
            ->add('observation');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Client',
            'docs' => []
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_client';
    }

    protected function buildDocs($docs) {
        $choices = [];

        foreach ($docs as $item) {
            /**@var $item Hierarchy */
            $choices[$item->getCode() . ' - ' . $item->getDescription()] = $item->getCode();
        }

        return $choices;
    }
}
