<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Note;
use App\Entity\User;
use App\Form\AnnonceType;
use App\Form\CategorieType;
use Doctrine\ORM\Mapping\Id;
use App\Repository\UserRepository;
use App\Repository\PhotoRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * 
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    /**
     * @Route("/gestion_annances", name="gestion_annances")
     */
    public function gestion_annances(AnnonceRepository $repoAnnonce): Response
    {

        $annonces=$repoAnnonce->findAll();

        return $this->render('admin/gestion_annances.html.twig',[
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/approuver_annonce/{id}", name="approuver_annonce")
     */
    public function approuver_annonce(Annonce $annonce, EntityManagerInterface $manager){

        $annonce->setStatus(1);
        $manager->persist($annonce);
        $manager->flush();
        return $this->redirectToRoute("gestion_annances");


    }
    /**
     * @Route("/masquer_annonce/{id}", name="masquer_annonce")
     */
    public function masquer_annonce(Annonce $annonce, EntityManagerInterface $manager){

        $annonce->setStatus(2);
        $manager->persist($annonce);
        $manager->flush();

        return $this->redirectToRoute("gestion_annances");


    }

    /**
     * @Route("/gestion_annances/modifier/{id}", name="modifier_annonce")
     */
    public function modifier_annonce(Annonce $annonce, Request $request, EntityManagerInterface $manager)
    {

        

        $form = $this->createForm(AnnonceType::class, $annonce, array( 
            'modifier' => true
           ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            
            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash("modifierAnnonce" , "L'annonce a bien été modifiée!");

            return $this->redirectToRoute("gestion_annances");

        }
        return $this->render('admin/modifier_annonce.html.twig',[
            "formAnnonce" => $form->createView(),
            "annonce" => $annonce
        ]);
    }

    /**
     * @Route("/gestion_annances/afficher/{id}", name="fiche_annonce_admin")
     */
    public function fiche_annonce(Annonce $annonce): Response
    {


        return $this->render('admin/fiche_annonce.html.twig',[
            'annonce' => $annonce
        ]);
    }

    /**
       * 
       * @Route("/gestion_annonce/supprimer/{id}", name="annonce_supprimer")
       */
      public function supprimer_annonce(Annonce $annonce, EntityManagerInterface $manager)
      {
        if(!empty($annonce->getPhotos()))
        {
            $photosTab=$annonce->getPhotos();
            foreach($photosTab as $photo){

               
                unlink($this->getParameter('images_directory') .'/'. $photo->getNom());
                $manager->remove($photo);
                $manager->flush();
            }

            
        }
        
        $manager->remove($annonce);
        $manager->flush();
        
        $this->addFlash("suppAnnonce" , "L'annonce a bien été supprimée");

        return $this->redirectToRoute("gestion_annances");
      }

      /**
     * @Route("/gestion_categories", name="gestion_categories")
     * @Route("/fiche_categorie/{id}/{action}", name="fiche_categorie")
     * @Route("/ajouter_categorie/{action}", name="ajouter_categorie")
     * @Route("/modifier_categorie/{id}/{action}", name="modifier_categorie")
     * @Route("/supprimer_categorie/{id}/{action}", name="supprimer_categorie")
     */
    public function gestion_categories($action=null,Categorie $categorie=null,CategorieRepository $repoCategorie, Request $request , EntityManagerInterface $manager): Response
    {
        //gestion categorie
        $categories=$repoCategorie->findAll();

        $formCat=null;
        //edit categorie
        if($action=='edit' or $action=='add'){
            if($action=='add'){
                $categorie = new Categorie;
            }
            $form = $this->createForm(CategorieType::class, $categorie);
            $formCat=$form->createView();
            $form->handleRequest($request);
           
            
            
            if($form->isSubmitted() && $form->isValid())
            {
                // dd($categorie);
                $manager->persist($categorie); 
                $manager->flush(); 
                if($action=='add'){
                $this->addFlash("ajoutCategorie","Categorie ajoutée!");
                }
                else{
                    $this->addFlash("modificationCategorie","Categorie modifiée!");
                }
                return $this->redirectToRoute("gestion_categories");
            }
        }
        if($action=='delete'){
            $manager->remove($categorie);
            $manager->flush();
            $this->addFlash("suppressionCategorie","Catégorie supprimée!");
            return $this->redirectToRoute("gestion_categories");
        }


        return $this->render('admin/gestion_categories.html.twig',[
            'categories' => $categories,
            'categorie' => $categorie,
            'action' => $action,
            'formCat' => $formCat
            
        ]);
    }


     /**
     * @Route("/gestion_users", name="gestion_users")
     */
    public function gestion_users(UserRepository $userRepo,Request $request, EntityManagerInterface $manager): Response
    {
        $user=null;
        $users=$userRepo->findAll();

        $user= new User();
        $form = $this->createForm(UserType::class, $user, array( 
            'ajouter' => true
           ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $user->setDateEnregistrement(new \DateTime('now'));

            if($user->getPolesUser == 1){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            else{
                $user->setRoles(["ROLE_USER"]);
            }
            $manager->persist($user); 
             $manager->flush(); 
 
            $this->addFlash("ajoutUser","Membre ajouté!");
            $user=new User();
            // dd($user);
            return $this->redirectToRoute("gestion_users");

            
        }
        return $this->render("admin/gestion_users.html.twig" , [
            "users" => $users,
            "formUser" => $form->createView(),
            "user" => $user->getId() ==! null
        ]);
    }

    /**
     * @Route("/fiche_user/{id}", name="fiche_user")
     */
    public function fiche_user(User $user,UserRepository $userRepo,Request $request , EntityManagerInterface $manager){
        
        $users=$userRepo->findAll();
        $form = $this->createForm(UserType::class, $user, array( 
            'modifierRole' => true
           ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $user->setDateEnregistrement(new \DateTime('now'));
            // dd($user);
            if($user->rolesUser == 1){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            else{
                $user->setRoles(["ROLE_USER"]);
            }

            $manager->persist($user); 
             $manager->flush(); 
 
             return $this->redirectToRoute("gestion_users");
            
        }
        return $this->render("admin/gestion_users.html.twig" , [
            "users" => $users,
            "formUser" => $form->createView(),
            "user"=>$user->getId() ==! null
        ]);
    }

    /**
     * @Route("/user_supprimer/{id}", name="user_supprimer")
     */
    public function user_supprimer(User $user,Request $request, EntityManagerInterface $manager){
        $manager->remove($user);
        $manager->flush();
        $this->addFlash("suppressionUser","Utilisateur supprimé!");
        return $this->redirectToRoute("gestion_users");
    }

    /**
     * @Route("/gestion_commentaire", name="gestion_commentaire")
     */
    public function gestion_commentaire(CommentaireRepository $commentRepo){

        $comments=$commentRepo->findAll();

        return $this->render("admin/gestion_comments.html.twig" , [
            "comments" => $comments,
        ]);


    }
    /**
     * @Route("/approuver_commentaire/{id}", name="approuver_commentaire")
     */
    public function approuver_commentaire(Commentaire $comment, EntityManagerInterface $manager){

        $comment->setStatus(1);
        $manager->persist($comment);
        $manager->flush();
        return $this->redirectToRoute("gestion_commentaire");


    }
    /**
     * @Route("/masquer_commentaire/{id}", name="masquer_commentaire")
     */
    public function masquer_commentaire(Commentaire $comment, EntityManagerInterface $manager){

        $comment->setStatus(2);
        $manager->persist($comment);
        $manager->flush();

        return $this->redirectToRoute("gestion_commentaire");


    }
    /**
     * @Route("/comment_supprimer/{id}", name="comment_supprimer")
     */
    public function comment_supprimer(Commentaire $comment,Request $request, EntityManagerInterface $manager){
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash("suppressionComment","Commentaire supprimé!");
        return $this->redirectToRoute("gestion_commentaire");
    }

    /**
     * @Route("/gestion_note", name="gestion_note")
     */
    public function gestion_note(NoteRepository $noteRepo){

        $notes=$noteRepo->findAll();

        return $this->render("admin/gestion_notes.html.twig" , [
            "notes" => $notes,
        ]);


    }
    /**
     * @Route("/approuver_note/{id}", name="approuver_note")
     */
    public function approuver_note(Note $note, EntityManagerInterface $manager){

        $note->setStatus(1);
        $manager->persist($note);
        $manager->flush();
        return $this->redirectToRoute("gestion_note");


    }
    /**
     * @Route("/masquer_note/{id}", name="masquer_note")
     */
    public function masquer_note(Note $note, EntityManagerInterface $manager){

        $note->setStatus(2);
        $manager->persist($note);
        $manager->flush();

        return $this->redirectToRoute("gestion_note");


    }
    /**
     * @Route("/note_supprimer/{id}", name="note_supprimer")
     */
    public function note_supprimer(Note $note,Request $request, EntityManagerInterface $manager){
        $manager->remove($note);
        $manager->flush();
        $this->addFlash("suppressionNote","Note supprimé!");
        return $this->redirectToRoute("gestion_commentaire");
    }

    
}
