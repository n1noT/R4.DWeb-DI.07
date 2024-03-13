<?php


/* indique où "vit" ce fichier */

namespace App\Controller;


/* indique l'utilisation du bon bundle pour gérer nos routes */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use stdClass;
use App\Service\CreditsGenerator;
use App\Entity\Lego;
use App\Repository\LegoRepository;
use App\Entity\LegoCollection;
use App\Repository\LegoCollectionRepository;
use App\Service\DatabaseInterface;
use Doctrine\ORM\EntityManagerInterface;

/* le nom de la classe doit être cohérent avec le nom du fichier */

class LegoController extends AbstractController
{

    private array $legos;




    
    #[Route('/',)]
    public function home(LegoRepository $legoRepository, LegoCollectionRepository $collectionRepository): Response
    {
        
        return $this->render('lego.html.twig', ['legos' =>$legoRepository->findAll(),
        'collections'=> $collectionRepository->findAll()
    ]);
    }



    #[Route('/{name}', 'filter_by_collection', requirements: ['name' => '(CreatorExpert|Creator|HarryPotter|StarWars)'])]
    public function filter(LegoCollection $collection, LegoCollectionRepository $collectionRepository): Response
    {

        return $this->render('lego.html.twig', ['legos' => $collection->getLegos(),
        'collections'=> $collectionRepository->findAll()
    ]);
        
    }


    #[Route('/credits', 'credits')]
    public function credits(CreditsGenerator $credits): Response
    {
        return new Response($credits->getCredits());
    }



    #[Route('/me',)]
    public function me()
    {
        die("Nino.");
    }

    #[Route('/test/{name}', 'test')]
    public function test(LegoCollection $collection): Response
    {
        dd($collection);
    }



}
