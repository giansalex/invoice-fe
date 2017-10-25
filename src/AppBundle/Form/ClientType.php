<?php

namespace AppBundle\Form;

use AppBundle\Entity\Hierarchy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                'choices' => $this->buildDocs($options['docs']),
                'label' => 'Tipo Documento',
            ])
            ->add('document', TextType::class, ['label' => 'Nro. Documento'])
            ->add('nameRzs', TextType::class, ['label' => 'Nombre o Razón Social'])
            ->add('comercialName', TextType::class, ['label' => 'Nombre Comercial'])
            ->add('email', EmailType::class, [
                'required' => false
            ])
            ->add('address', TextType::class, ['label' => 'Dirección'])
            ->add('observation', TextType::class, ['label' => 'Observaciones']);
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
