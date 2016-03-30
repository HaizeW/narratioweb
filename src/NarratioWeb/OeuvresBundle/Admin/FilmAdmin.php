<?php

namespace NarratioWeb\OeuvresBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FilmAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('duree')
            ->add('titre')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('duree', 'text', array('label' => 'Duree en minutes'))
            ->add('titre')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('titre')
            ->add('duree', 'text', array('label' => 'Duree (en minutes)'))
            ->add('synopsis')
            ->add('annee')
            ->add('imageFilm', 'sonata_type_admin', array('btn_add'=>false, 'delete'=>false))
            ->add('acteurs', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Acteur', 
                                  'multiple' => true, 
                                  'expanded' => 'true'))
            ->add('realisateur', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Realisateur', 
                                  'multiple' => false, 
                                  'expanded' => 'true'))
            ->add('type', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Type', 
                                  'multiple' => false, 
                                  'expanded' => 'true'))
            ->add('oeuvre', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Oeuvre', 
                                  'multiple' => false, 
                                  'expanded' => 'true'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('titre')
            ->add('duree', 'text', array('label' => 'Duree (en minutes)'))
            ->add('synopsis')
        ;
    }
}
