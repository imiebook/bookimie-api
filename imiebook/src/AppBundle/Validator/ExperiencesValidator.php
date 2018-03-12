<?php
namespace AppBundle\Validator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ExperiencesValidator extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('description');
        $builder->add('enterprise');
        $builder->add('dateStart', DateTimeType::class,
            ['widget' => 'single_text']
        );
        $builder->add('dateEnd', DateTimeType::class,
            ['widget' => 'single_text']
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Experiences',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
