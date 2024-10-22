<?php

namespace App\Controller\Admin;

use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Entity\Review;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\BeerRepositoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(BeerCrudController::class)->generateUrl());


        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


	/**
	 * @param \App\Application\Domain\Repository\BeerRepositoryInterface $beerRepository
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    #[Route('/admin/beers', name: 'admin-beers')]
    public function beers(BeerRepositoryInterface $beerRepository): Response
    {
        // todo: use "use case"
        $beers = $beerRepository->findByCriteria(['status' => 1]);
        return $this->render("admin/beers.html.twig", ['beers' => $beers]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Zdalny Browar Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Beers', 'fas fa-beer', Beer::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Reviews', 'fas fa-comments', Review::class);

        yield MenuItem::linkToRoute('QR beers', 'fas fa-beer', 'admin-beers');
        yield MenuItem::linkToRoute('API documentation', 'fas fa-book', 'documentation-api');
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
