<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserUnitType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Código',
            ])
            ->add('description', TextType::class, [
                'label' => 'Descripción',
            ]);
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

    protected function getChoices() {
        $choices = [];
        $items = $this->manager
            ->getRepository('AppBundle:Hierarchy')
            ->getGroup(3);

        foreach ($items as $item) {
            $choices[$item->getCode() . ' - ' . $item->getDescription()] = $item->getCode();
        }

        return $choices;
    }
}
