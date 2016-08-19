<?php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$collection = new RouteCollection();

$collection->add('reglementaires_thematique_erc', new Route('/thematique-erc/index/', array(
    '_controller' => 'ReglementairesErcBundle:UploadThematiqueErc:index',
)));

$collection->add('reglementaires_thematique_erc_import_new', new Route('/thematique-erc/import/new', array(
    '_controller' => 'ReglementairesErcBundle:UploadThematiqueErc:new',
)));

$collection->add('reglementaires_thematique_erc_import_new_create', new Route(
    '/thematique-erc/import/create',
    array('_controller' => 'ReglementairesErcBundle:UploadThematiqueErc:create'),
    array('_method' => 'post')
));

return $collection;