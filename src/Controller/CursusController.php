<?php

namespace App\Controller;

use App\Entity\Cursus;
use App\Entity\Lesson;
use App\Entity\Theme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CursusController extends AbstractController
{
    #[Route('/theme', name: 'app_theme')]
    public function allTheme(EntityManagerInterface $em): Response
    {
        $themes = $em->getRepository(Theme::class)->findAll();

        return $this->render('Course/theme/index.html.twig', [
            'themes' => $themes,
        ]);
    }

    #[Route('/theme/{id}', name: 'app_one_theme')]
    public function oneTheme(EntityManagerInterface $em, int $id): Response
    {
        $theme = $em->getRepository(Theme::class)->find($id);

        return $this->render('Course/theme/one.html.twig', [
            'theme' => $theme,
        ]);
    }

    #[Route('/theme/{id}/cursus', name: 'app_cursus')]
    public function allCursus(EntityManagerInterface $em, int $id): Response
    {
        $theme = $em->getRepository(Theme::class)->find($id);

        return $this->render('Course/cursus/index.html.twig', [
            'theme' => $theme,
        ]);
    }

    #[Route('/cursus/{id}', name: 'app_one_cursus')]
    public function oneCursus(EntityManagerInterface $em, int $id): Response
    {
        $cursus = $em->getRepository(Cursus::class)->find($id);

        return $this->render('Course/cursus/one.html.twig', [
            'cursus' => $cursus,
        ]);
    }

    #[Route('/cursus/{id}/lesson', name: 'app_lesson')]
    public function allLesson(EntityManagerInterface $em, int $id): Response
    {
        $cursus = $em->getRepository(Cursus::class)->find($id);

        return $this->render('Course/lesson/index.html.twig', [
            'cursus' => $cursus,
        ]);
    }

    #[Route('/lesson/{id}', name: 'app_one_lesson')]
    public function oneLesson(EntityManagerInterface $em, int $id): Response
    {
        $lesson = $em->getRepository(Lesson::class)->find($id);

        return $this->render('Course/lesson/one.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}
