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
     * Methood de sauvergarde des fichiers par thematique 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
       public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository('ReglementairesErcBundle:Formation')->findAll();
        $form = $this->createForm(new ErcUploadThematiqueType(), array(), array('formations' => $formations));

        $request = $this->getRequest();
        $form->handleRequest($request);

        if ('POST' === $request->getMethod()) {

            if ($form->isValid()) {
                /**  @var Formation $formation */
                foreach ($formations as $index => $formation) {

                    $key = sprintf("file-%s", $formation->getId());
                    $file = $form->get($key)->getData();

//                    $oreginalName = $file->getClientOriginalName();

                    $date = new \DateTime('now');
                    $name = (string)$formation->getId() . "_" . $formation->getLibelle() . "_" . $date->format("Y-m-d").".csv";

                    if ($file !== null) {
                        $type = $file->getClientOriginalExtension();
                        /** Si $type  est en format CSV l'upload se fait correctement sinon message d'erreur*/
                        if ($type === "csv") {
                            $dir = __DIR__ . '/../../../../web/uploads/imports_csv/thematique_formation/';
                            $file->move($dir, $name);
                            $this->get("session")->getFlashBag()->add(FlashMessageConsts::MESSAGE_SUCCESS, "Vos données ont été correctement enregistrées.");
                        } else {
//
                            $this->get("session")->getFlashBag()->add(FlashMessageConsts::MESSAGE_WARNING, "Le fichier  n'a pas la format *.CSV");

                        }
                    }


//                    echo "<br> Key $key  <pre>";
//                    echo "<br> File $file  <pre>";
//                    echo "<br> Type $type  <pre>";
//                    echo "<br> Name $name <pre>";
//                    echo "<br> DIR_ $dir  <pre>";
////                    Debug::dump($file);
//                    echo ' </pre>';
//                    die();
                }
                return $this->redirect($this->generateUrl('reglementaires_thematique_import_new'));

            }

            $this->get("session")->getFlashBag()->add(FlashMessageConsts::MESSAGE_ERROR, "Vos données n'ont pas été correctement enregistrées.");
            return $this->render('ReglementairesErcBundle:UploadThematique:new.html.twig', array(
                'formations' => $formations,
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Formation();

        $em = $this->getDoctrine()->getManager();
        $Formations = $em->getRepository('ReglementairesErcBundle:Formation')->findAll();

        $form = $this->createForm(new ErcUploadThematiqueType(), array(), array('Formations' => $Formations));

        return $this->render('ReglementairesErcBundle:UploadThematiqueErc:new.html.twig', array(
            'form' => $form->createView(),
 
        ));
    }
}
