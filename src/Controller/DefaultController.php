<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\EditProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'main_homepage')]
    public function index(): Response
    {
        /*$entityManager = $this->getDoctrine()->getManager();
        $productList = $entityManager->getRepository(Product::class)->findAll();*/
        return $this->render('main/default/index.html.twig', []);
    }

    #[Route('/product-add', methods: 'GET', name: 'product_add_old')]
    public function productAdd(Request $request): Response
    {
        $product = new Product();
        $product->setTitle('Product '.rand(1, 100));
        $product->setDescription('smth');
        $product->setPrice(10);
        $product->setQuantity(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('main_homepage');
    }

    #[Route('/edit-product/{id}', methods: 'GET|POST', name: 'product_edit', requirements: ['id'=> '\d+'])]
    #[Route('/add-product', methods: 'GET|POST', name: 'product_add')]
    public function editProduct(Request $request, int $id = null): Response
    {
        $entityManager = $this->getDoctrine()->getManager();


        $checkProduct = false;

        if ($id) {
            $product = $entityManager->getRepository(Product::class)->find($id);
            if (!$product) {
                $checkProduct = true;
            }
        }

        if ($checkProduct || !$id) {
            $product = new Product();
        }

        $form = $this->createForm(EditProductFormType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }

        return $this->render('main/default/edit_product.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
