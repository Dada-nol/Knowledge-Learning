<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccessCourseDeniedController extends AbstractController
{

  #[Route('/access-dinied', name: 'access_course_dinied')]
  public function accessCourseDenied(): Response
  {
    return $this->render('cursus/dinied.html.twig');
  }
}
