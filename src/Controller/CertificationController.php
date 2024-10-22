<?php

namespace App\Controller;

use App\Entity\Certificate;
use App\Entity\Cursus;
use App\Entity\Lesson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CertificationController extends AbstractController
{

  #[Route('/certificate', name: 'app_certification')]
  public function certification(EntityManagerInterface $em, Security $security): Response
  {
    $user = $security->getUser();
    $certificates = $em->getRepository(Certificate::class)->findBy(['user' => $user]);

    return $this->render('certification/index.html.twig', ['certificates' => $certificates]);
  }

  #[Route('/certification/lesson/{id}', name: 'app_certified')]
  public function isCompleted(EntityManagerInterface $em, Security $security, int $id): Response
  {
    $user = $security->getUser();
    $lesson = $em->getRepository(Lesson::class)->find($id);
    $cursus = $lesson->getCursus();

    $certificate = $em->getRepository(Certificate::class)->findOneBy(['user' => $user, 'lesson' => $lesson]);

    if (!$certificate) {
      $certificate = new Certificate();
      $certificate->setUser($user);
      $certificate->setLesson($lesson);
      $certificate->setCertified(true);
      $em->persist($certificate);
    }

    $em->flush();


    $lessons = $cursus->getLessons();

    $allLessonsCertified = true;
    foreach ($lessons as $lesson) {
      $certificate = $em->getRepository(Certificate::class)->findOneBy([
        'user' => $user,
        'lesson' => $lesson,
      ]);

      if (!$certificate || !$certificate->isCertified()) {
        $allLessonsCertified = false;
        break;
      }
    }

    if ($allLessonsCertified) {
      $certificateCursus = $em->getRepository(Certificate::class)->findOneBy([
        'user' => $user,
        'cursus' => $cursus,
      ]);

      if (!$certificateCursus) {
        $certificateCursus = new Certificate();
        $certificateCursus->setUser($user);
        $certificateCursus->setCursus($cursus);
        $certificateCursus->setCertified(true);
        $em->persist($certificateCursus);
      }
    }

    $em->flush();

    return $this->redirectToRoute('app_home');
  }
}
