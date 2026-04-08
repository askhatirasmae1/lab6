<?php
declare(strict_types=1);

namespace App\Service;

use App\Dao\FiliereDao;
use App\Dao\EtudiantDao;
use App\Dto\EtudiantCreateDTO;
use App\Dto\EtudiantUpdateDTO;
use App\Entity\Etudiant;
use App\Exception\BusinessException;
use App\Log\Logger;
use PDO;

class EtudiantService
{
    private $etudiantDao;
    private $filiereDao;
    private $pdo;
    private $logger;

    public function __construct(EtudiantDao $etudiantDao, FiliereDao $filiereDao, PDO $pdo, Logger $logger)
    {
        $this->etudiantDao = $etudiantDao;
        $this->filiereDao = $filiereDao;
        $this->pdo = $pdo;
        $this->logger = $logger;
    }

    public function create(EtudiantCreateDTO $dto): int
    {
        if ($this->filiereDao->findById($dto->getFiliereId()) === false) {
            throw new BusinessException('filiere_id inexistant');
        }

        $entity = new Etudiant(
            null,
            $dto->getCne(),
            $dto->getNom(),
            $dto->getPrenom(),
            $dto->getEmail(),
            $dto->getFiliereId()
        );

        return $this->etudiantDao->create($entity);
    } 

    public function update(EtudiantUpdateDTO $dto): bool
    {
        $found = $this->etudiantDao->findById($dto->getId());

        if (!$found) {
            throw new BusinessException('introuvable');
        }

        $entity = new Etudiant(
            $dto->getId(),
            $found['cne'],
            $dto->getNom(),
            $dto->getPrenom(),
            $dto->getEmail(),
            $dto->getFiliereId()
        );

        return $this->etudiantDao->update($entity);
    }
}