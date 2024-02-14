<?php


/* indique où "vit" ce fichier */

namespace App\Controller;


/* indique l'utilisation du bon bundle pour gérer nos routes */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use stdClass;
use App\Entity\Lego;
use App\Service\CreditsGenerator;
use App\Service\DatabaseInterface;

/* le nom de la classe doit être cohérent avec le nom du fichier */

class LegoController extends AbstractController
{

    private array $legos;

    public function __construct()
    {
        $this->legos = [];

        $data = file_get_contents('../src/data.json');
        $json = json_decode($data);


        foreach ($json as $lego) {
            $legoModel = new Lego($lego->id, $lego->name, $lego->collection);
            $legoModel->setDescription($lego->description);
            $legoModel->setPrice($lego->price);
            $legoModel->setPieces($lego->pieces);
            $legoModel->setLegoImage($lego->images->bg);
            $legoModel->setBoxImage($lego->images->box);

            array_push($this->legos, $legoModel);
        }

        return $this->legos;
    }



    #[Route('/',)]
    public function home(DatabaseInterface $dbinterface): Response
    {
        $this->legos = $dbinterface->getAllLegos();

        return $this->render('lego.html.twig', ['legos' => $this->legos]);
    }


    

    #[Route('/{collection}', 'filter_by_collection', requirements: ['collection' => '(creator|star_wars|creator_expert)'])]
    public function filter(DatabaseInterface $dbinterface, $collection): Response
    {
        $collectionMAJ = str_replace('_',' ', strtolower($collection));
        
        $this->legos = $dbinterface->getLegosByCollection($collectionMAJ);

        return $this->render('lego.html.twig', ['legos' => $this->legos]);
        
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
