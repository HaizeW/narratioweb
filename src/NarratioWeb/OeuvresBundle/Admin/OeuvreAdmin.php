<?php

namespace NarratioWeb\OeuvresBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OeuvreAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
      // Champs à intégrer dans les formulaires de filtrage
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nom')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
     // Champs affichés lorsqu'il faudra lister des entités Oeuvre
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nom')
            ->add('compteurVues')
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
     // Champs à intégrer dans les formulaires d'ajout et d'édition d'Oeuvres
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nom')
            ->add('concept')
            ->add('prodDer', null, array('label' => 'Produits Derives'))
            ->add('epoque', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Epoque', 
                                  'multiple' => false, 
                                  'expanded' => 'true'))
            ->add('genre', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\Genre', 
                                  'multiple' => false, 
                                  'expanded' => 'true'))
            ->add('trancheAge', 'entity', array('class' => 'NarratioWeb\OeuvresBundle\Entity\TrancheAge', 
                                  'multiple' => false, 
                                  'expanded' => 'true'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
     // Champs à intégrer dans les affichages des Oeuvres
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nom')
            ->add('concept')
            ->add('compteurVues', 'text', array('label' => 'Nombre de vues'))
            ->add('prodDer', 'text', array('label' => 'Produits Derives'))
        ;
    }
}
