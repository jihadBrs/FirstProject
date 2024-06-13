<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonces;
use App\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\Request; // Import Request class


class TeatcherController extends AbstractController
{
    /**
     * @Route("/teatcher", name="app_teacher_dashboard")
     */
    public function index(): Response
    {
        return $this->render('teatcher/index.html.twig', [
            'controller_name' => 'TeatcherController',
        ]);
    }
   /**
     * @Route("/teatcher/annonces/new", name="app_teacher_annonces_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() ) {
            // Gestion de l'upload du fichier
            $file = $form['courseFile']->getData();
            if ($file instanceof UploadedFile) {
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($fileName);
                $newFileName = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $newFileName
                    );
                    $annonce->setFile(new File($this->getParameter('upload_directory').'/'.$newFileName));
                } catch (FileException $e) {
                    // Gestion de l'erreur si le déplacement du fichier échoue
                }
            }
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_teacher_annonces_new');
        }

        return $this->render('teatcher/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }
}