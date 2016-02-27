<?php

namespace NarratioWeb\OeuvresBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OeuvreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('nom')
            //->add('resume')
            //->add('compteurVues')
            ->add('epoque')
            ->add('genre')
            ->add('thematique')
            ->add('trancheAge')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NarratioWeb\OeuvresBundle\Entity\Oeuvre'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'narratioweb_oeuvresbundle_oeuvre';
    }
}
