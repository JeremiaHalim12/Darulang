<?php

class ProductController
{
    private $productDao;
    private $categoryDao;
    private $cartDao;

    function __construct()
    {
        $this->productDao = new ProductDaoImpl();
        $this->categoryDao = new CategoryDaoImpl();
        $this->cartDao = new CartDaoImpl();
    }

    public function index()
    {
        $search = filter_input(INPUT_GET, 'search');
        $filter = filter_input(INPUT_GET, 'filter');
        if (isset($search) && $search != '' && isset($filter) && $filter != 'All') {
            $product = $this->productDao->fetchAllProductWithSearchAndFilter($search, $filter);
        } else if (isset($search) && $search != '' && ($filter == 'All' || !isset($filter))) {
            $product = $this->productDao->fetchAllProductWithSearch($search);
        } else if ($search == '' && $filter != 'All' && isset($filter)) {
            $product = $this->productDao->fetchAllProductWithFilter($filter);
        } else {
            $product = $this->productDao->fetchAllProduct();
        }


        $addCart = filter_input(INPUT_GET, 'addcart');
        if ($_SESSION["web_user"]) {
            $cart = new Cart();
            $user = new User();

            $user->setId($_SESSION["web_user_id"]);
            $cart->setUser($user);
            $cart->setItemCart($this->cartDao->fetchUserCart($_SESSION["web_user_id"]));


            if (isset($addCart) && $addCart == 1) {
                $productId = filter_input(INPUT_GET, 'product-id');
                $userId = $_SESSION["web_user_id"];
                $amount = filter_input(INPUT_GET, 'amount');

                $new_item = new CartItem();
                $newProduct = new Product();

                $newProduct->setId($productId);
                $new_item->setAmount($amount);
                $new_item->setProduct($newProduct);

                $found = false;
                foreach ($cart->getItemCart() as $itemCart) {
                    if ($cart->getUser()->getId() == $userId && $itemCart->getProduct()->getId() == (int)$productId) {
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    $result = $this->cartDao->updateCart($cart, $new_item);
                } else {
                    $result = $this->cartDao->addCart($new_item, $cart);
                }

                if ($result) {
                    echo '<div class="alert alert-success" role="alert">Product added</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error adding Product</div>';
                }
            }

            $deleteCart = filter_input(INPUT_GET, 'deleteCart');
            if (isset($deleteCart) && $deleteCart == 1) {
                $productId = filter_input(INPUT_GET, 'product-id');
                $userId = filter_input(INPUT_GET, 'user-id');

                if ($this->cartDao->deleteCart($cart, $productId)) {
                    echo '<div class="alert alert-success" role="alert">Product deleted</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error delete Product</div>';
                }
            }


            $cart->setItemCart($this->cartDao->fetchUserCart($_SESSION["web_user_id"]));
        } else if ($addCart == 1) {
            header('location:index.php?key=login');
        }
        $categories = $this->categoryDao->fetchAllCategory();
        include_once 'View/product-view.php';
    }

    public function index_admin()
    {
        // Create
        $submit_product = filter_input(INPUT_POST, 'submitProduct');
        $submit_category = filter_input(INPUT_POST, 'submitCategory');
        if (isset($submit_product)) {
            $name = trim(filter_input(INPUT_POST, 'name'));
            $price = trim(filter_input(INPUT_POST, 'price'));
            $stock = trim(filter_input(INPUT_POST, 'stock'));
            $image = '';
            $category_id = trim(filter_input(INPUT_POST, 'category'));

            // Handle File Upload
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $directory = 'Uploads/';
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = $name . '.' . $extension;
                $file = $directory . $image;
                if ($_FILES['image']['size'] > 1024 * 2048) {
                    echo '<div class="bg-error">File size is too large.</div>';
                } else {
                    move_uploaded_file($_FILES['image']['tmp_name'], $file);
                }
            }

            $product = new Product();
            $product->setName($name);
            $product->setPrice($price);
            $product->setStock($stock);
            $product->setImage($image);
            $product->setCategory($this->categoryDao->fetchCategoryById($category_id));

            if ($this->productDao->createProduct($product)) {
                echo '<div class="alert alert-success" role="alert">Product added</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error adding Product</div>';
            }
        } elseif (isset($submit_category)) {
            $name = trim(filter_input(INPUT_POST, 'name'));
            $category = new Category();
            $category->setName($name);

            if ($this->categoryDao->createCategory($category)) {
                echo '<div class="alert alert-success" role="alert">Category added</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error adding category</div>';
            }
        }

        // Update
        $submit_update = filter_input(INPUT_POST, 'submitUpdate');
        if (isset($submit_update)) {
            $id = trim(filter_input(INPUT_POST, 'idUpdate'));
            $name = trim(filter_input(INPUT_POST, 'nameUpdate'));
            $price = trim(filter_input(INPUT_POST, 'priceUpdate'));
            $stock = trim(filter_input(INPUT_POST, 'stockUpdate'));
            $category_id = trim(filter_input(INPUT_POST, 'categoryUpdate'));

            $product = $this->productDao->fetchProductById($id);

            // Handle File Upload
            if (isset($_FILES['imageUpdate']['name']) && $_FILES['imageUpdate']['name'] != '') {
                $directory = 'Uploads/';
                $extension = pathinfo($_FILES['imageUpdate']['name'], PATHINFO_EXTENSION);
                $image = $name . '.' . $extension;
                $file = $directory . $image;
                if ($_FILES['imageUpdate']['size'] > 1024 * 2048) {
                    echo '<div class="bg-error">File size is too large.</div>';
                } else {
                    move_uploaded_file($_FILES['imageUpdate']['tmp_name'], $file);
                    $product->setImage($image);
                }
            }

            $product->setName($name);
            $product->setPrice($price);
            $product->setStock($stock);
            $product->setCategory($this->categoryDao->fetchCategoryById($category_id));

            if ($this->productDao->updateProduct($product)) {
                echo '<div class="alert alert-success" role="alert">Product updated</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error updating Product</div>';
            }
        }

        // Delete
        $delete_confirm = filter_input(INPUT_GET, 'delete-confirm');
        if (isset($delete_confirm)) {
            $id = filter_input(INPUT_GET, 'id');
            $product = $this->productDao->fetchProductById($id);
            unlink('Uploads/' . $product->getImage());
            if ($this->productDao->deleteProduct($id)) {
                echo '<div class="alert alert-success" role="alert">Product deleted</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error deleting Product</div>';
            }
        }

        $categories = $this->categoryDao->fetchAllCategory();
        $product = $this->productDao->fetchAllProduct2();
        include_once 'View/product-admin-view.php';
    }
}
