<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Rate;
use App\Form\UtilisateurType;
use App\Form\LoginType;
use App\Form\UserType;
use App\Repository\UtilisateurRepository;
use App\Repository\RateRepository;
use App\Services\QrcodeService;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;


#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{    /**
    * @Route("/happy", name="app_utilisateur_index", methods={"GET"})
    */
    
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        
        $utilisateurs = $entityManager
            ->getRepository(Utilisateur::class)
            ->findAll();

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }
     /**
 * @Route("/new", name="app_utilisateur_new", methods={"GET","POST"})
 */
   
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder ): Response
    { 
        $utilisateur = new Utilisateur();
        $utilisateur->setRate(0);
        $utilisateur->setRole('freelancer');
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        $photoFile = $form->get('photo')->getData();
       

        if ($photoFile) {
            $photoFileName = uniqid().'.'.$photoFile->guessExtension();

            // Move the file to the directory where your entity's image property is stored
            $photoFile->move(
                $this->getParameter('your_entity_photo_directory'),
                $photoFileName
            );

            $utilisateur->setPhoto($photoFileName);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form['photo']->getData();
            $plainPassword = $form->get('plainPassword')->getData();
            $encoded = $encoder->encodePassword($utilisateur, $plainPassword);
            $utilisateur->setMdp($encoded);
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }
     /**
 * @Route("/freelancer", name="app_utilisateur_user", methods={"GET","POST"})
 */
    
    public function newuser(Request $request, EntityManagerInterface $entityManager , UserPasswordEncoderInterface $encoder ,MailerService $ms): Response
    {
        $utilisateur = new Utilisateur();
      
        $form = $this->createForm(UserType::class, $utilisateur);
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setRole('user');
            $plainPassword = $form->get('mdp')->getData();
            $to = $form->get('adresse')->getData();
            $encoded = $encoder->encodePassword($utilisateur, $plainPassword);
            $utilisateur->setMdp($encoded);
            $ms->send(
              'test',
              'lord.gaddour.99@gmail.com',
              $to,
              'mail/mail.html.twig',
              [
                'name'=>$form->get('nom')->getData(),
                'mdp'=>$form->get('mdp')->getData()
              ]
            );
            $entityManager->persist($utilisateur);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('utilisateur/newuser.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }
   
  /**
 * @Route("/{id}", name="app_utilisateur_show", methods={"GET"})
 */
   
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
     /**
 * @Route("/{id}/card", name="app_utilisateur_card", methods={"GET"})
 */
   
 public function card(Utilisateur $utilisateur, QrcodeService $qrcodeService): Response
 {    $qrCode = null;
        
    
    $qrCodeData = 'Nom: ' . $utilisateur->getNom() . "\n" . 'Prénom: ' . $utilisateur->getPrenom() . "\n" . 'mail: ' . $utilisateur->getAdresse() . "\n" . 'numero: ' . $utilisateur->getNum();
        
    $qrCode = $qrcodeService->qrcode($qrCodeData);
     return $this->render('utilisateur/card1.html.twig', [
         'utilisateur' => $utilisateur,
         'qrCode' => $qrCode,
     ]);
 }
   /**
     * @Route("/{id}/profil", name="app_utilisateur_profil")
     */
    public function profil($id): Response
    {
        // Retrieve the user by ID from the database
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);

        
        // Render the view and pass the user object to the template
        return $this->render('utilisateur/profil.html.twig', [
            'utilisateur' => $utilisateur
        ]);
    }
   /**
 * @Route("/{id}/edit", name="app_utilisateur_edit", methods={"GET","POST"})
 */
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {   
     
            $form = $this->createForm(UtilisateurType::class, $utilisateur);
       
        
        $form->handleRequest($request);
        $photoFile = $form->get('photo')->getData();

        if ($photoFile) {
            $photoFileName = uniqid().'.'.$photoFile->guessExtension();

            // Move the file to the directory where your entity's image property is stored
            $photoFile->move(
                $this->getParameter('your_entity_photo_directory'),
                $photoFileName
            );

            $utilisateur->setPhoto($photoFileName);
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $encoded = $encoder->encodePassword($utilisateur, $plainPassword);
            $utilisateur->setMdp($encoded);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_profil', ['id' => $utilisateur->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
      
    }

   
     #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager, UtilisateurRepository $ur): Response
    {  
       if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            var_dump($request->request->get('_token'));
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }
        

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/login', name: 'app_utilisateur_login', methods: ['POST'])]
    public function login(Request $request,  EntityManagerInterface $entityManager, UtilisateurRepository $ur, Security $security): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('username')->getData();
            $password = $form->get('password')->getData();
            $utilisateur = $ur->login($email,$password);
            if($utilisateur == null){
                return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
            }
            if($utilisateur->getRole()=='user'){
                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }
            if($utilisateur->getRole()=='admin'){
                return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
            }
            if($utilisateur->getRole()=='freelancer'){
                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }
          
            return $this->redirectToRoute('app_utilisateur_show', ['id' => $utilisateur->getId()], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('utilisateur/login.html.twig', [
            
            'form' => $form,
        ]);

    }
   /**
     * @Route("/{id}/qrcode", name="app_utilisateur_qr")
     * @param Request $request
     * @param QrcodeService $qrcodeService
     * @return Response
     */
    public function qrcode(Utilisateur $utilisateur, QrcodeService $qrcodeService): Response
    {
        $qrCode = null;
        

        
            $qrCode = $qrcodeService->qrcode($utilisateur->getNom());
        

        return $this->render('utilisateur/index.html.twig', [
            
            'qrCode' => $qrCode
        ]);
    }
}
