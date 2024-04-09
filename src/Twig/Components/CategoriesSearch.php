<?php

namespace App\Twig\Components;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class CategoriesSearch extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true)]
    public ?string $query = null;

    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CategoryType::class);
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->getListQueryBuilder($this->query)->getQuery()->getResult();
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();

        $entityManager->persist($this->getForm()->getData());
        $entityManager->flush();

        $this->resetForm();
    }
}
