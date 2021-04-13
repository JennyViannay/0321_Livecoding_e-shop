<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProductManager;

class AdminController extends AbstractController
{
    public function index()
    {
        $productManager = new ProductManager();
        $categoryManager = new CategoryManager();

        return $this->twig->render('Admin/index.html.twig', [
            'products' => $productManager->selectAll(),
            'categories' => $categoryManager->selectAll(),
        ]);
    }

    // Add Product
    public function addProduct()
    {
        $categoryManager = new CategoryManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();
            // GESTION DE FORMULAIRE
            $product = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'qty' => $_POST['qty'],
                'category_id' => $_POST['category_id'],
            ];
            $productManager->insert($product);
            header('Location:/admin/index');
        }

        return $this->twig->render('Admin/Product/add.html.twig', [
            'categories' => $categoryManager->selectAll()
        ]);
    }

    // Edit Product
    public function editProduct(int $id): string
    {
        $categoryManager = new CategoryManager();
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product['title'] = $_POST['title'];
            $product['description'] = $_POST['description'];
            $product['price'] = $_POST['price'];
            $product['qty'] = $_POST['qty'];
            $product['category_id'] = $_POST['category_id'];
            $productManager->update($product);
        }

        return $this->twig->render('Admin/Product/edit.html.twig', [
            'categories' => $categoryManager->selectAll(),
            'product' => $product,
        ]);
    }


    // Dlt product
    public function deleteProduct(int $id)
    {
        $productManager = new ProductManager();
        $productManager->delete($id);
        header('Location:/admin/index');
    }
}
