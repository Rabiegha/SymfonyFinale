<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class HomepageController extends AbstractController {

    public function __construct(private RequestStack $requestStack , private EntityManagerInterface $entityManager)
	{
	}


    #[Route('/', name:'homepage.index')]
    public function index ():Response
    {

        return $this->render('homepage/index.html.twig', [
            'my_array'=> ['value0','value1','value2'],
            'assoc_array' => [
                'key0'=>'value0',
                'key1'=>'value1',
                'key2'=>'value2',

            ]
        ]);
    }

    #[Route('/contact', name:'homepage.contact')]
    public function contact ():Response
    {
        // création d'un formulaire
		$entity = new Contact();
		$type = ContactType::class;
		$form = $this->createForm($type, $entity);

		// récupérer la saisie précédente dans la requête http
		$form->handleRequest($this->requestStack->getMainRequest());

		// si le formulaire est valide et soumis
		if ($form->isSubmitted() && $form->isValid()) {

			// insérer dans la base
			$this->entityManager->persist($entity);
			$this->entityManager->flush();

			// message de confirmation
			$message =  'Message sent';

			// message flash : message stocké en session, supprimé suite à son affichage
			$this->addFlash('notice', $message);

			// redirection vers la page d'accueil de l'admin
			return $this->redirectToRoute('homepage.index');
        }

        return $this->render('homepage/contact.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
