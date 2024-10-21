<?php

namespace App\Controller;

use App\Entity\Cursus;
use App\Entity\Lesson;
use App\Entity\Theme;
use App\Form\CursusType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CursusController extends AbstractController
{
    #[Route('/theme', name: 'app_theme')]
    public function allTheme(EntityManagerInterface $em): Response
    {
        $themes = $em->getRepository(Theme::class)->findAll();

        return $this->render('cursus/theme.html.twig', [
            'themes' => $themes,
        ]);
    }


    #[Route('/theme/{id}/cursus', name: 'app_cursus')]
    public function allCursus(EntityManagerInterface $em, int $id): Response
    {
        $theme = $em->getRepository(Theme::class)->find($id);


        return $this->render('cursus/cursus.html.twig', [
            'theme' => $theme,
        ]);
    }


    #[Route('/cursus/{id}/lesson', name: 'app_lesson')]
    public function allLesson(EntityManagerInterface $em, int $id): Response
    {
        $cursus = $em->getRepository(Cursus::class)->find($id);

        return $this->render('cursus/lesson.html.twig', [
            'cursus' => $cursus,

        ]);
    }

    #[Route('/lesson/{id}/course', name: 'app_course')]
    public function oneLesson(EntityManagerInterface $em, int $id, AuthorizationCheckerInterface $authChecker): Response
    {
        $lesson = $em->getRepository(Lesson::class)->find($id);
        $course = $lesson->getCourse();

        if (!$authChecker->isGranted('CAN_ACCESS', $course)) {
            // Redirige vers une page d'erreur ou de connexion
            return $this->redirectToRoute('app_home');
        }

        return $this->render('cursus/oneLesson.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}
