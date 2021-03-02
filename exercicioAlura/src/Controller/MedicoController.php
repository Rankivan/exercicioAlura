<?php


namespace App\Controller;



use App\Entity\Medico;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicoController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
     {

         $this->entityManager = $entityManager;
     }


     //Para inserir
    /**
     * @Route("/medico", methods={"POST"})
     */
    public function novoMedico(Request $request): Response
    {
        $corpoRequisicao = $request-> getContent();
        $dadoEmJson = json_decode($corpoRequisicao);

        $medico = new Medico();
        $medico->crm = $dadoEmJson->crm;
        $medico->nome = $dadoEmJson->nome;

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);

    }

    //Para buscar
    /**
     * @Route("/medico/{id}", methods={"GET"})
     */

    public function buscarDadosMedicos(int $id): Response
    {
       $repositorioMedicos = $this
           ->getDoctrine()
           ->getRepository(Medico::class);

      $medicoList = $repositorioMedicos->find($id);

      return new JsonResponse($medicoList);


    }


    /**
     * @Route("/medico/{id}", methods={"PUT"})
     */
    public function editaDadosMedico(int $id, Request $request): Response
    {

        $corpoRequisicao = $request-> getContent();
        $dadoEmJson = json_decode($corpoRequisicao);

        $medicoEdit = new Medico();
        $medicoEdit->crm = $dadoEmJson->crm;
        $medicoEdit->nome = $dadoEmJson->nome;

        $repositorioMedicos = $this
            ->getDoctrine()
            ->getRepository(Medico::class);

        $medicoBuscado = $repositorioMedicos->find($id);

        $medicoBuscado->crm = $medicoEdit->crm;
        $medicoBuscado->nome = $medicoEdit->nome;

       $this->entityManager->flush();

       return new JsonResponse($medicoBuscado);

    }
}