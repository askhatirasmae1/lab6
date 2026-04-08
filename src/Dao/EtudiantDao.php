<?php
namespace App\Dao;

use App\Entity\Etudiant;
use PDO;

class EtudiantDao
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Etudiant $e): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO etudiant(cne, nom, prenom, email, filiere_id)
             VALUES(?,?,?,?,?)"
        );

        $stmt->execute([
            $e->getCne(),
            $e->getNom(),
            $e->getPrenom(),
            $e->getEmail(),
            $e->getFiliereId()
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(Etudiant $e): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE etudiant SET nom=?, prenom=?, email=?, filiere_id=? WHERE id=?"
        );

        return $stmt->execute([
            $e->getNom(),
            $e->getPrenom(),
            $e->getEmail(),
            $e->getFiliereId(),
            $e->getId()
        ]);
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function countByFiliereId(int $filiereId): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as c FROM etudiant WHERE filiere_id=?");
        $stmt->execute([$filiereId]);
        return (int)$stmt->fetch()['c'];
    }
}