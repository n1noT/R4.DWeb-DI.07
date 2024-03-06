<?php


/* indique où "vit" ce fichier */

namespace App\Controller;


/* indique l'utilisation du bon bundle pour gérer nos routes */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use stdClass;
use App\Service\CreditsGenerator;
use App\Service\DatabaseInterface;

/* le nom de la classe doit être cohérent avec le nom du fichier */

class LegoController extends AbstractController
{

    private array $legos;




    
    #[Route('/',)]
    public function home(DatabaseInterface $dbinterface): Response
    {
        
        $this->legos = $dbinterface->getAllLegos();
        
        return $this->render('lego.html.twig', ['legos' => $this->legos, 'collections'=> $dbinterface->getAllCollections()]);
    }



    #[Route('/{collection}', 'filter_by_collection', requirements: ['collection' => '(creator_expert|creator|harry_potter|star_wars)'])]
    public function filter(DatabaseInterface $dbinterface, $collection): Response
    {
        $collection = str_replace('_',' ', strtolower($collection));
        
        $this->legos = $dbinterface->getLegosByCollection($collection);

        return $this->render('lego.html.twig', ['legos' => $this->legos, 'collections'=> $dbinterface->getAllCollections()]);
        
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
}
