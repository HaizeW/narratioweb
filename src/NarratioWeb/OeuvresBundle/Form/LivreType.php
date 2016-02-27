<?php

namespace NarratioWeb\OeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LivreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('titre')
            ->add('auteur')
            ->add('editeur')
            //->add('oeuvreLitt')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NarratioWeb\OeuvresBundle\Entity\Livre'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'narratioweb_oeuvresbundle_livre';
    }
}
