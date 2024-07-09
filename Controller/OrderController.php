<?php

class OrderController
{
    private $cartDao;
    private $userDao;
    private $orderDao;
    private $productDao;

    public function __construct()
    {
        $this->cartDao = new CartDaoImpl();
        $this->userDao = new UserDaoImpl();
        $this->orderDao = new OrderDaoImpl();
        $this->productDao = new ProductDaoImpl();
    }

    public function index()
    {
        $orders = $this->orderDao->fetchUserOrder();
        /** @var Order $order */
        foreach ($orders as $order) {
            $order->setProduct($this->orderDao->fetchProductOrder($_SESSION['web_user_id'], $order->getId()));
        }
        include_once 'View/order-view.php';
    }

    public function index_admin()
    {
        $orders = $this->orderDao->fetchAll();
        /** @var Order $order */
        foreach ($orders as $order) {
            $order->setProduct($this->orderDao->fetchProductOrder($order->getUser()->getId(), $order->getId()));
        }
        $countOrders = $this->orderDao->fetchCountOrder();
        $totalUsers = $this->orderDao->fetchTotalUsers()[0]['count'];
        $totalOrders = $this->orderDao->fetchTotalOrders()[0]['count'];
        include_once 'View/order-admin-view.php';
    }

    public function checkout()
    {
        $cart = new Cart();
        $user = $this->userDao->fetchCurrentUser();

        $cart->setItemCart($this->cartDao->fetchUserCart($_SESSION["web_user_id"]));
        $cart->setUser($user);

        $confirm = filter_input(INPUT_POST, 'checkout');
        if (isset($confirm)) {
            $time = filter_input(INPUT_POST, 'time');
            $location = filter_input(INPUT_POST, 'location');

            $new_order = new Order();
            $new_order->setUser($user);
            $new_order->setTime($time);
            $new_order->setLocation($location);

            $new_order_id = $this->orderDao->createOrder($new_order);
            $new_order->setId($new_order_id);
            $result = false;
            foreach ($cart->getItemCart() as $itemCart) {
                $result = $this->orderDao->processOrder($new_order, $itemCart);
            }
            if ($result) {
                foreach ($cart->getItemCart() as $item) {
                    $this->cartDao->deleteCart($cart, $item->getProduct()->getId());
                    $updateProduct = $this->productDao->fetchProductById($item->getProduct()->getId());
                    $updateProduct->setStock($updateProduct->getStock() - $item->getAmount());
                    $this->productDao->updateProduct($updateProduct);
                }
                echo '<script> location.replace("index.php?key=order"); </script>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error create order</div>';
            }
        }

        include_once 'View/checkout-view.php';
    }
}
