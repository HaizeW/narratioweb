<?php

namespace NarratioWeb\OeuvresBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LivreAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
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
            ->add('resume')
            ->add('annee')
            ->add('imageLivre', 'sonata_type_admin', array('btn_add'=>false, 'delete'=>false))
            ->add('auteur', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Auteur', 
                                  'multiple' => true, 
                                  'expanded' => 'true'))
            ->add('editeur', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Editeur', 
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
            ->add('resume')
        ;
    }
}
