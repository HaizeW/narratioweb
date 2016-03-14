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
            ->add('concept')
            ->add('compteurVues')
            ->add('prodDer')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
     // Champs affichés lorsqu'il faudra lister des entités Livres
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nom')
            ->add('concept')
            ->add('compteurVues')
            ->add('prodDer')
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
     // Champs à intégrer dans les formulaires d'ajout et d'édition de Livres
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('nom')
            ->add('concept')
            ->add('compteurVues')
            ->add('prodDer')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nom')
            ->add('concept')
            ->add('compteurVues')
            ->add('prodDer')
        ;
    }
}
