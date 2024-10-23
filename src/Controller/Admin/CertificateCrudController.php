<?php

namespace App\Controller\Admin;

use App\Entity\Certificate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class CertificateCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Certificate::class;
  }


  public function configureFields(string $pageName): iterable
  {
    return [
      AssociationField::new('user'),
      AssociationField::new('lesson'),
      AssociationField::new('cursus'),
      BooleanField::new('isCertified'),
    ];
  }
}
