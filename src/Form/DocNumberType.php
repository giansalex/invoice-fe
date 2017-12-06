<?php

namespace App\Form;

use App\Entity\Hierarchy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocNumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', ChoiceType::class, [
                'choices' => $this->buildChoices($options['docs']),
            ])
            ->add('serie')
            ->add('correlativo');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\DocNumber',
            'docs' => [],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_docnumber';
    }

    protected function buildChoices($items) {
        $choices = [];

        foreach ($items as $item) {
            /**@var $item Hierarchy */
            $choices[$item->getCode() . ' - ' . $item->getDescription()] = $item->getCode();
        }

        return $choices;
    }
}
