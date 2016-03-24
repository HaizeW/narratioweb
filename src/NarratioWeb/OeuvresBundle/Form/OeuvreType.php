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
            ->add('nom')
            ->add('concept')
            ->add('prodDer', 'text', array('label' => 'Produits dérivés'))
            -> add('TrancheAge', 'entity',
            array('label' => 'Tranche dÂge',
            'class' => 'NarratioWebOeuvresBundle:TrancheAge',
            'property' => 'intitule',
            'multiple' => false,
            'expanded' => false))
            -> add('Epoque', 'entity',
            array('label' => 'Epoque',
            'class' => 'NarratioWebOeuvresBundle:Epoque',
            'property' => 'intitule',
            'multiple' => false,
            'expanded' => false))
            -> add('Genre', 'entity',
            array('label' => 'Genre',
            'class' => 'NarratioWebOeuvresBundle:Genre',
            'property' => 'intitule',
            'multiple' => false,
            'expanded' => false))
            -> add('Thematique', 'entity',
            array('label' => 'Thématique',
            'class' => 'NarratioWebOeuvresBundle:Thematique',
            'property' => 'intitule',
            'multiple' => false,
            'expanded' => false))
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
