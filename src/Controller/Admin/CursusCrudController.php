<?php

namespace App\Controller\Admin;

use App\Entity\Cursus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CursusCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Cursus::class;
  }


  public function configureFields(string $pageName): iterable
  {
    return [
      AssociationField::new('theme'),
      TextField::new('name'),
      IntegerField::new('price'),
      TextField::new('lessonsAsString', 'Lessons'),
    ];
  }
}
