<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\FiliereCreateDTO;
use App\Dto\EtudiantCreateDTO;
use App\Dto\EtudiantUpdateDTO;
use App\Service\FiliereService;
use App\Service\EtudiantService;
use App\Exception\BusinessException;

class AppController
{
    private $filiereService;
    private $etudiantService;

    public function __construct(FiliereService $f, EtudiantService $e)
    {
        $this->filiereService=$f;
        $this->etudiantService=$e;
    }

    public function handle(array $req): Response
    {
        try {
            switch ($req['action']) {

                case 'create_filiere':
                    $id = $this->filiereService->createFiliere(
                        new FiliereCreateDTO($req['code'],$req['libelle'])
                    );
                    return new Response(true,['id'=>$id]);

                case 'create_etudiant':
                    $id = $this->etudiantService->create(
                        new EtudiantCreateDTO(
                            $req['cne'],$req['nom'],$req['prenom'],$req['email'],$req['filiere_id']
                        )
                    );
                    return new Response(true,['id'=>$id]);

                default:
                    return new Response(false,null,'action inconnue');
            }

        } catch (BusinessException $e) {
            return new Response(false,null,$e->getMessage());
        }
    }
}