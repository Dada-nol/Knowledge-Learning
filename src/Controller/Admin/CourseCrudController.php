<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CourseCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Course::class;
  }


  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('title'),
      AssociationField::new('lesson'),
      TextField::new('content'),
    ];
  }
}
