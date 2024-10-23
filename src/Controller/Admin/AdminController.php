<?php

namespace App\Controller\Admin;

use App\Entity\AccessCourse;
use App\Entity\Certificate;
use App\Entity\Course;
use App\Entity\Cursus;
use App\Entity\Lesson;
use App\Entity\Theme;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller\Admin
 * 
 * This controller manages the admin dashboard and menu items for the application.
 */
class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    /**
     * Configures the dashboard settings.
     *
     * @return Dashboard The configured dashboard.
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Kwonledge Learning');
    }

    /**
     * Configures the menu items for the admin dashboard.
     *
     * @return iterable The menu items to be displayed.
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Themes', 'fas fa-palette', Theme::class);
        yield MenuItem::linkToCrud('Cursus', 'fas fa-book', Cursus::class);
        yield MenuItem::linkToCrud('Lessons', 'fas fa-chalkboard-teacher', Lesson::class);
        yield MenuItem::linkToCrud('Courses', 'fas ', Course::class);
        yield MenuItem::linkToCrud('AccessCourse', 'fas ', AccessCourse::class);
        yield MenuItem::linkToCrud('Certificates', 'fas ', Certificate::class);
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-arrow-left', 'app_home');
    }
}
