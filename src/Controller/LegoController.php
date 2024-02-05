<?php


/* indique où "vit" ce fichier */

namespace App\Controller;


/* indique l'utilisation du bon bundle pour gérer nos routes */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use stdClass;
use App\Entity\Lego;


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

    // L’attribute #[Route] indique ici que l'on associe la route
    // "/" à la méthode home pour que Symfony l'exécute chaque fois
    // que l'on accède à la racine de notre site.


    #[Route('/',)]
    public function home()
    {

        // the template path is the relative file path from `templates/`
        return $this->render('lego.html.twig', ['legos' => $this->legos]);
    }

    //    #[Route('/creator', )]
    //    public function creator()
    //    {
    //         return $this->render('lego.html.twig', ['legos' => array_filter($this->legos, function($lego) { return $lego->getCollection() === "Creator"; })]);
    //    }

    //    #[Route('/star_wars', )]
    //    public function starWars()
    //    {
    //         return $this->render('lego.html.twig', ['legos' => array_filter($this->legos, function($lego) { return $lego->getCollection() === "Star Wars"; })]);
    //    }
    //    #[Route('/creator_expert', )]
    //    public function creatorExpert()
    //    {
    //         return $this->render('lego.html.twig', ['legos' => array_filter($this->legos, function($lego) { return $lego->getCollection() === "Creator Expert"; })]);
    //    }
    
    #[Route('/{collection}', 'filter_by_collection', requirements: ['collection' => '(creator|star_wars|creator_expert)'])]
    public function filter($collection): Response
    {
        
        return $this->render('lego.html.twig', ['legos' => array_filter($this->legos, function($lego) use ($collection) {return strtolower($lego->getCollection()) == str_replace('_',' ', strtolower($collection));})]);
        
    }


    #[Route('/me',)]
    public function me()
    {
        die("Nino.");
    }
}
