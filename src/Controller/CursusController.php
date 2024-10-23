<?php

namespace App\Controller;

use App\Entity\Certificate;
use App\Entity\Cursus;
use App\Entity\Lesson;
use App\Entity\Theme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CursusController extends AbstractController
{
    /**
     * Displays all themes.
     *
     * @Route('/theme', name: 'app_theme')
     * @param EntityManagerInterface $em The entity manager for database operations.
     * @return Response The response containing the rendered themes page.
     */
    #[Route('/theme', name: 'app_theme')]
    public function allTheme(EntityManagerInterface $em): Response
    {
        $themes = $em->getRepository(Theme::class)->findAll();

        return $this->render('cursus/theme.html.twig', [
            'themes' => $themes,
        ]);
    }

    /**
     * Displays all cursus associated with a specific theme.
     *
     * @Route('/theme/{id}/cursus', name: 'app_cursus')
     * @param EntityManagerInterface $em The entity manager for database operations.
     * @param int $id The ID of the theme.
     * @param Security $security The security service to get the current user.
     * @return Response The response containing the rendered cursus page.
     */
    #[Route('/theme/{id}/cursus', name: 'app_cursus')]
    public function allCursus(EntityManagerInterface $em, int $id, Security $security): Response
    {
        $user = $security->getUser();
        $theme = $em->getRepository(Theme::class)->find($id);

        $certificationStatus = [];

        foreach ($theme->getCursus() as $cursus) {
            $isCertified = $em->getRepository(Certificate::class)->findOneBy([
                'user' => $user,
                'cursus' => $cursus
            ]);

            $certificationStatus[$cursus->getId()] = ($isCertified !== null);
        }

        return $this->render('cursus/cursus.html.twig', [
            'theme' => $theme,
            'certificationStatus' => $certificationStatus
        ]);
    }

    /**
     * Displays all lessons associated with a specific cursus.
     *
     * @Route('/cursus/{id}/lesson', name: 'app_lesson')
     * @param EntityManagerInterface $em The entity manager for database operations.
     * @param int $id The ID of the cursus.
     * @param Security $security The security service to get the current user.
     * @return Response The response containing the rendered lessons page.
     */
    #[Route('/cursus/{id}/lesson', name: 'app_lesson')]
    public function allLesson(EntityManagerInterface $em, int $id, Security $security): Response
    {
        $user = $security->getUser();
        $cursus = $em->getRepository(Cursus::class)->find($id);
        $certificationStatus = [];

        foreach ($cursus->getLessons() as $lesson) {
            $isCertified = $em->getRepository(Certificate::class)->findOneBy([
                'user' => $user,
                'lesson' => $lesson
            ]);

            $certificationStatus[$lesson->getId()] = ($isCertified !== null);
        }

        return $this->render('cursus/lesson.html.twig', [
            'cursus' => $cursus,
            'certificationStatus' => $certificationStatus
        ]);
    }

    /**
     * Displays a specific lesson and its associated courses.
     *
     * @Route('/lesson/{id}/course', name: 'app_course')
     * @param EntityManagerInterface $em The entity manager for database operations.
     * @param int $id The ID of the lesson.
     * @param AuthorizationCheckerInterface $authChecker The authorization checker service.
     * @param Security $security The security service to get the current user.
     * @return Response The response containing the rendered course page.
     */
    #[Route('/lesson/{id}/course', name: 'app_course')]
    public function oneLesson(EntityManagerInterface $em, int $id, AuthorizationCheckerInterface $authChecker, Security $security): Response
    {
        $user = $security->getUser();
        $lesson = $em->getRepository(Lesson::class)->find($id);
        $courses = $lesson->getCourse();
        $isCertified = $em->getRepository(Certificate::class)->findOneBy(['user' => $user, 'lesson' => $lesson]);

        foreach ($courses as $course) {
            if (!$authChecker->isGranted('CAN_ACCESS', $course)) {
                return $this->redirectToRoute('access_course_dinied');
            }
        }

        return $this->render('cursus/course.html.twig', [
            'lesson' => $lesson,
            'isCertified' => $isCertified,
        ]);
    }
}
