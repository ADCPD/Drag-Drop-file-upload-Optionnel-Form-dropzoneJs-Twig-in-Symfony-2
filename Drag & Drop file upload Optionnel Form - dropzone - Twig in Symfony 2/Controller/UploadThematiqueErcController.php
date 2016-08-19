<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 17/08/2016
 * Time: 17:47
 */

namespace Reglementaires\ErcBundle\Controller;

use Administration\UploadFilesBundle\Entity\AdminUploadFiles;
use Reglementaires\ErcBundle\Entity\Erc;
use Reglementaires\ErcBundle\Form\ErcUploadThematiqueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UploadThematiqueErcController
 * @package Reglementaires\ErcBundle\Controller
 */
class UploadThematiqueErcController extends Controller
{

    /**
     * Methood de sauvergarde des fichiers des thematiques ERC
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
     
          $entity = new Erc;
          $em = $this->getDoctrine()->getManager();
          $ercs = $em->getRepository('ReglementairesErcBundle:Erc')->findAll();
        
          $form = $this->createForm(new ErcUploadThematiqueType(), $entity);
          $form->bind($request);
          $em = $this->getDoctrine()->getManager();
          if ($form->isValid()) {
              $em->persist($entity);
              $em->flush();

              $this->get("session")->getFlashBag()->add(FlashMessageConsts::MESSAGE_SUCCESS, "Vos données ont été correctement enregistrées.");
              return $this->redirect($this->generateUrl('reglementaires_thematique_erc_import_new'));
          }
          $this->get("session")->getFlashBag()->add(FlashMessageConsts::MESSAGE_ERROR, "Vos données n'ont pas été correctement enregistrées.");
          return $this->render('ReglementairesErcBundle:UploadThematiqueErc:new.html.twig', array(
              'ercs' => $ercs,
              'form' => $form->createView(),
          ));
        
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Erc();

        $em = $this->getDoctrine()->getManager();
        $ercs = $em->getRepository('ReglementairesErcBundle:Erc')->findAll();

        $form = $this->createForm(new ErcUploadThematiqueType(), array(), array('ercs' => $ercs));

        return $this->render('ReglementairesErcBundle:UploadThematiqueErc:new.html.twig', array(
            'form' => $form->createView(),
 
        ));
    }
}
