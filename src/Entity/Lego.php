<?php 

namespace App\Entity;

class Lego {
    private int $id;
    private string $nom;
    private string $collection;
    private string $description;
    private float $price;
    private int $pieces;
    private string $boxImage;
    private string $legoImage;

    public function __construct($id, $nom, $collection) {
        $this->id = $id;
        $this->nom = $nom;
        $this->collection = $collection;
    }

    /**
     * Get the value of id
     */ 
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of nom
     */ 
    public function getNom() : string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom(string $nom) 
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of collection
     */ 
    public function getCollection() : string
    {
        return $this->collection;
    }

    /**
     * Set the value of collection
     *
     * @return  self
     */ 
    public function setCollection(string $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    

    /**
     * Get the value of description
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice(): float 
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice(float $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of pieces
     */ 
    public function getPieces(): int
    {
        return $this->pieces;
    }

    /**
     * Set the value of pieces
     *
     * @return  self
     */ 
    public function setPieces(int $pieces)
    {
        $this->pieces = $pieces;

        return $this;
    }

    /**
     * Get the value of boxImage
     */ 
    public function getBoxImage(): string
    {
        return $this->boxImage;
    }

    /**
     * Set the value of boxImage
     *
     * @return  self
     */ 
    public function setBoxImage(string $boxImage)
    {
        $this->boxImage = $boxImage;

        return $this;
    }

    /**
     * Get the value of legoImage
     */ 
    public function getLegoImage(): string
    {
        return $this->legoImage;
    }

    /**
     * Set the value of legoImage
     *
     * @return  self
     */ 
    public function setLegoImage(string $legoImage)
    {
        $this->legoImage = $legoImage;

        return $this;
    }
}


?>