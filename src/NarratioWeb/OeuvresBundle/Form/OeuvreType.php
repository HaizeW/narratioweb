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
            ->add('nom', 'text', array('label' => 'Nom de l\'oeuvre'))
            ->add('concept', 'text', array('label' => 'Concept de l\'oeuvre'))
            ->add('prodDer', 'text', array('label' => 'Produits dérivés'))
            ->add('image', 'text', array('label' => 'Image de l\'oeuvre'), new ImageType())
            -> add('TrancheAge', 'entity',
            array('label' => 'Tranche d\'Âge de l\'oeuvre',
            'class' => 'NarratioWebOeuvresBundle:TrancheAge',
            'property' => 'intitule',
            'multiple' => false,
            'expanded' => false))
            -> add('Epoque', 'entity',
            array('label' => 'Epoque de l\'oeuvre',
            'class' => 'NarratioWebOeuvresBundle:Epoque',
            'property' => 'intitule',
            'multiple' => false,
            'expanded' => false))
            -> add('Genre', 'entity',
            array('label' => 'Genre de l\'oeuvre',
            'class' => 'NarratioWebOeuvresBundle:Genre',
            'property' => 'intitule',
            'multiple' => false,
            'expanded' => false))
            -> add('Thematique', 'entity',
            array('label' => 'Thématique de l\'oeuvre',
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
