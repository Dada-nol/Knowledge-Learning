<?php

namespace App\Controller;

use App\Entity\Cursus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CursusController extends AbstractController
{
    #[Route('/cursus', name: 'app_cursus')]
    public function index(EntityManagerInterface $em): Response
    {
        $cursus = $em->getRepository(Cursus::class)->findAll();

        return $this->render('cursus/index.html.twig', [
            'cursus' => $cursus,
        ]);
    }
}
