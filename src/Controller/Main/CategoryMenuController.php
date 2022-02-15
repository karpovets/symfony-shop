<?php

namespace App\Controller\Main;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryMenuController extends AbstractController
{
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], ['id' => 'DESC']);
        return $this->render('main/_embed/_menu/_category_menu.html.twig', [
            'categories' => $categories,
        ]);
    }
}
