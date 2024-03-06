<?php


// Là ou la classe est déclarée (où son fichier se trouve)
namespace App\Service;

use App\Entity\Lego;
use App\Entity\Collection;

use PDO;

class DatabaseInterface 
{

    public function createLego($data): array {
        $result = [];

        foreach ($data as $lego) {

            $legoModel = new Lego($lego['id'], $lego['name'], $lego['collection']);
            $legoModel->setDescription($lego['description']);
            $legoModel->setPrice($lego['price']);
            $legoModel->setPieces($lego['pieces']);
            $legoModel->setLegoImage($lego['imagebg']);
            $legoModel->setBoxImage($lego['imagebox']);
        
            array_push($result, $legoModel);
        }
        

        return $result;
    }

    public function createCollection($data): array {
        $result = [];

        foreach ($data as $col) {
            
            $name = $col['collection'];
            $link = str_replace(' ','_', strtolower($col['collection']));
            $collection = new Collection($name, $link);

            array_push($result, $collection);
        }

        return $result;
    }

    public function getAllLegos(): array
    {
        $pdo = new PDO("mysql:host=tp-symfony-mysql;dbname=lego_store", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->query("SELECT * FROM lego");
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->createLego($data);

        return $result;
    }

    public function getLegosByCollection($collection): array
    {
        $pdo = new PDO("mysql:host=tp-symfony-mysql;dbname=lego_store", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare("SELECT * FROM lego WHERE collection = :collection");
        $statement->bindParam(':collection', $collection);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $result = $this->createLego($data);

        return $result;
    }

    public function getAllCollections(): array
    {
        $pdo = new PDO("mysql:host=tp-symfony-mysql;dbname=lego_store", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->query("SELECT DISTINCT collection FROM lego");
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        
        $result = $this->createCollection($data);
        
        return $result;
    }
}
