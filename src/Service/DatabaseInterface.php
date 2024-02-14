<?php


// Là ou la classe est déclarée (où son fichier se trouve)
namespace App\Service;

use App\Entity\Lego;

use PDO;

class DatabaseInterface 
{
    public function getAllLegos(): array
    {
        $pdo = new PDO("mysql:host=tp-symfony-mysql;dbname=lego_store", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->query("SELECT * FROM lego");
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLegosByCollection($collection): array
    {
        $pdo = new PDO("mysql:host=tp-symfony-mysql;dbname=lego_store", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare("SELECT * FROM lego WHERE collection = :collection");
        $statement->bindParam(':collection', $collection);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
