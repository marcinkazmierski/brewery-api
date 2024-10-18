<?php

namespace App\Controller\Admin;

use App\Application\Domain\Entity\Beer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class BeerCrudController extends AbstractCrudController {

	public static function getEntityFqcn(): string {
		return Beer::class;
	}

	public function configureFields(string $pageName): iterable {
		$fields = parent::configureFields($pageName);
		$fields[] =
			ArrayField::new('tags');
		return $fields;
	}

	public function configureActions(Actions $actions): Actions {
		return $actions
			->add(Crud::PAGE_INDEX, Action::DETAIL);
	}

}
