<?php

namespace Reglementaires\ErcBundle\Form;

use Reglementaires\ErcBundle\Entity\Erc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ErcUploadThematiqueType
 * @package Reglementaires\ErcBundle\Form
 */
class ErcUploadThematiqueType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var Formation $formation */
        foreach ($options["formations"] as $index => $formation) {
            $key = sprintf("file-%s", $formation->getId());
            $builder->add($key, 'file', array(
                'label' => $formation->getLibelle(),
                'required' => false,
                'attr' => array(
                    'class' => "dropzone ",
                )
            ));
        }
        $builder->add('Deposer', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-success btn-block  pull-right '
            )
        ));


    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'formations' => array()
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'reglementaires_erc_bundle_erc_upload_thematique_type';
    }
}
