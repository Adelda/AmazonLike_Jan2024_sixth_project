<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategorySearchType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(CategorySearchType::class);
        $form->handleRequest($request);

        $categories = $paginator->paginate(
            $categoryRepository->getListQueryBuilder($form->get('query')->getData()), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('category/index.html.twig', [
            'form' => $form,
            'categories' => $categories,
        ]);
    }

    // #[Route('/categories/{id<^\d+$>}', name: 'app_categories_show')]
    // public function show(string $id, CategoryRepository $categoryRepository): Response
    // {
    //     $category = $categoryRepository->find($id);

    //     if (!$category) {
    //         throw $this->createNotFoundException('Category not found');
    //     }

    //     return $this->render('category/show.html.twig', [
    //         'category' => $category,
    //     ]);
    // }

    #[Route('/categories/{slug}', name: 'app_categories_show')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/categories/new', name: 'app_categories_new', priority: 1)]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('app_categories');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    } 

    #[Route('/categories/{id<^\d+$>}/edit', name: 'app_categories_edit')]
    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_categories_show', [
                'slug' => $category->getSlug(),
            ]);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}
