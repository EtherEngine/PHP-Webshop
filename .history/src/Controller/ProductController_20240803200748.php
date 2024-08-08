<?php

namespace App\Controller;

class ProductController extends BaseController
{
    public function list()
    {
        // Logik zur Produktauflistung
        $this->render('partials/product_list', ['products' => $products]);
    }

    public function detail($id)
    {
        // Logik zur Produktdetailansicht
        $this->render('partials/product_detail', ['product' => $product]);
    }
}
