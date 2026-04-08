<?php
namespace App\Dao;

use App\Entity\Filiere;
use PDO;

class FiliereDao
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Filiere $f): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO filiere(code, libelle) VALUES(?, ?)"
        );

        $stmt->execute([
            $f->getCode(),
            $f->getLibelle()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    
    public function findAll()
    {
        $res = $this->pdo->query("SELECT * FROM filiere");
        return $res->fetchAll();
    }

    
    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM filiere WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

   
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM filiere WHERE id=?");
        return $stmt->execute([$id]);
    }
}