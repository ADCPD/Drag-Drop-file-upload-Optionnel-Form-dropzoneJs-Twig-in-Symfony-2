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
     * Cette methode permet de creer un input file dynamiquement 
     * pour chaque instance de la class ERC
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Erc $erc */
        foreach ($options["ercs"] as $index => $erc) {
            $key = sprintf("file-%s", $erc->getId());
            $builder->add($key, 'file', array(
                'label' => $erc->getLibelle(),
                'required' => false,
                'attr' => array(
                    'class' => "dropzone ",
                 )
            ));
        }

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'ercs' => array()
        ));
    }

    public function getName()
    {
        return 'reglementaires_erc_bundle_erc_upload_thematique_type';
    }
}
