<?php

namespace App\Controller;

use App\Entity\AccessCourse;
use App\Entity\Certificate;
use App\Entity\Course;
use App\Entity\Lesson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CertificationController extends AbstractController
{

  #[Route('/certifications', name: 'app_certification')]
  public function certification(): Response
  {
    return $this->render('certification/index.htlm.twig');
  }

  #[Route('/certification/lesson/{id}', name: 'app_lesson_completed')]
  public function isCompleted(EntityManagerInterface $em, Security $security, int $id): Response
  {
    $user = $security->getUser();
    $lesson = $em->getRepository(Lesson::class)->find($id);
    $certificate = $em->getRepository(Certificate::class)->findOneBy(['user' => $user, 'course' => $lesson]);

    if (!$certificate) {
      $certificate = new Certificate();
      $certificate->setUser($user);
      $certificate->setLesson($lesson);
      $certificate->setCertified(true);
      $em->persist($certificate);
    }

    $em->flush();

    return $this->redirectToRoute('app_home');
  }
}
