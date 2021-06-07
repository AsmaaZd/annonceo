<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Photo;
use App\Form\NoteType;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;
use App\Repository\PhotoRepository;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="afficher_annonce")
     */
    public function afficher_annonce(AnnonceRepository $repoAnnonce, NoteRepository $noteRepo, UserRepository $user): Response
    {

        $annonces = $repoAnnonce->findAnnonceActive();

        // dd($annonces);

        foreach ($annonces as $annonce) {
            $avgNote = $noteRepo->findNoteMoyenne($annonce->getUser()->getId());
            
            // $avgNote[2]=round($avgNote[1], 1);
            $avgNote[1]=round($avgNote[1],1);
            // dd($avgNote[1]);
            $annonce->moyenne = $avgNote;
            // array_push($annonce,$avgNote);


            // $userAct=$user->find($annonce->getUser());
            // $userAct->avgNotes=$avgNote;

        }

        // dd($annonces);
        return $this->render('page/acceuil.html.twig', [
            'annonces' => $annonces,

        ]);
    }

    /**
     * @Route("/fiche_annonce/{id}", name="fiche_annonce")
     * @Route("/depo_note/{id}", name="depo_note")
     */
    public function fiche_annonce(Request $request, Annonce $annonce,CommentaireRepository $repoComment, AnnonceRepository $repoAnnonce, EntityManagerInterface $manager,NoteRepository $noteRepo): Response
    {

        // $annoncesCat = $repoAnnonce->findAnnoncesCat($annonce->getCategorie());
        $annoncesCat = $repoAnnonce->findAnnoncesCat($annonce,$annonce->getCategorie());
        // dd($annoncesCat);

        $aNote=$noteRepo->findUser1User2($this->getUser(),$annonce->getUser());
        if($aNote){
            $dejaNoter=true;
        }
        else{
            $dejaNoter=false;
        }

        $comment = new Commentaire();

        $comments=$repoComment->findlastComment($annonce);

        $form = $this->createForm(CommentaireType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setAnnonce($annonce);
            $comment->setDateEnregistrement(new \DateTime('now'));
            $manager->persist($comment); // on persiste l'instance
            $manager->flush();
            return $this->redirectToRoute("fiche_annonce", [
                'id' => $annonce->getId()
            ]);
        }

        
        //note
        $note = new Note;
        $formNote = $this->createForm(NoteType::class, $note);

        $formNote->handleRequest($request);

        if ($formNote->isSubmitted() and $formNote->isValid()) {
            $note->setUser2($this->getUser());
            $note->setUser1($annonce->getUser() );
            $note->setDateEnregistrement(new \DateTime('now'));
            $manager->persist($note); // on persiste l'instance
            $manager->flush();
            return $this->redirectToRoute("fiche_annonce", [
                'id' => $annonce->getId()
            ]);
        }

        return $this->render('page/fiche_annonce.html.twig', [
            'annonce' => $annonce,
            'annoncesCat' => $annoncesCat,
            'formC' => $form->createView(),
            'comments' => $comments,
            'dejaNoter' => $dejaNoter,
            'formNote' => $formNote->createView(),

        ]);
    }
    // Route("/depo_note/{id}", name="depo_note")

    /**
     * @Route("/add_annonce", name="add_annonce")
     * @Route("/depo_note/{id}", name="depo_note")
   
     */
    public function add_annonce(Request $request, EntityManagerInterface $manager): Response
    {

        
        $annonce = new Annonce;
        $form = $this->createForm(AnnonceType::class, $annonce, array(
            'add' => true
        ));

        $form->handleRequest($request);
        // dd($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $annonce->setDateEnregistrement(new \DateTime('now'));

            $annonce->setUser($this->getUser());

            $manager->persist($annonce); // on persiste l'instance
            $manager->flush();
            //    dd($annonce);

            $imageFile = $form->get('photos')->getData();
            // dd($imageFile);


            // si une image a été upload, on rentre dans la condition
            // renommer l'image
            // envoyer l'image dans le dossier public / images
            // envoyer le nom de l'image en bdd
            if ($imageFile) {
                // redéfinir le nom de l'image
                for ($i = 0; $i < count($imageFile); $i++) {



                    $nomImage = date("YmdHis") . "-" . uniqid() . "-" . $imageFile[$i]->getClientOriginalName();
                    //dd($nomImage);

                    // envoie de l'image dans le dossier public/images 

                    try // on exécute le code dans try
                    {
                        $imageFile[$i]->move(
                            $this->getParameter('images_directory'),
                            $nomImage
                        );

                        // méthode move() permet de déplacer un fichier
                        // 2 arguments :
                        // 1e : le "placement"
                        // 2e : le nom
                    } catch (FileException $e) // s'il y a une erreur, on récupère l'erreur et on l'affiche ici
                    {
                    }


                    // Envoie du nouveau nom en bdd
                    $photo = new Photo;
                    $photo->setNom($nomImage);
                    $photo->setAnnonce($annonce);
                    $manager->persist($photo); // on persiste l'instance
                    $manager->flush();
                }
            }

            
            //addFlush
            return $this->redirectToRoute("fiche_annonce", [
                'id' => $annonce->getId()
            ]);

        }

        return $this->render('page/add_annonce.html.twig', [
            'formAnnonce' => $form->createView(),

        ]);
    }

     
}
