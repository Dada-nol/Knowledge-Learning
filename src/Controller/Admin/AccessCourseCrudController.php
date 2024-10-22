<?php

namespace App\Controller\Admin;

use App\Entity\AccessCourse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class AccessCourseCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return AccessCourse::class;
  }


  public function configureFields(string $pageName): iterable
  {
    return [
      AssociationField::new('user'),
      AssociationField::new('course'),
      BooleanField::new('isAvailable'),
    ];
  }
}
