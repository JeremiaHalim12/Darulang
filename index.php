<?php
session_start();
include_once 'Entity/Category.php';
include_once 'Entity/User.php';
include_once 'Entity/Product.php';
include_once 'Entity/Cart.php';
include_once 'Entity/CartItem.php';
include_once 'Entity/Order.php';
include_once 'Dao/UserDaoImpl.php';
include_once 'Dao/ProductDaoImpl.php';
include_once 'Dao/CategoryDaoImpl.php';
include_once 'Dao/CartDaoImpl.php';
include_once 'Dao/OrderDaoImpl.php';
include_once 'Controller/UserController.php';
include_once 'Controller/ProductController.php';
include_once 'Controller/OrderController.php';
include_once 'Controller/HomeController.php';
include_once 'Util/PDOUtil.php';

if (!isset($_SESSION['web_user'])) {
  $_SESSION['web_user'] = false;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="Author" content="NUSENTRA TEAM">
  <title>DARULANG</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="icon" type="image/x-icon" href="assets/d_logo.png">
  <link type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
  <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.4/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="./styles/my_style.css">
  <link rel="stylesheet" type="text/css" href="./styles/query.css">
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.4/datatables.min.js"></script>
</head>

<body>
  <?php
  $menu = filter_input(INPUT_GET, 'key');
  if ($menu != 'login' && $menu != 'register' && $menu != 'logout') {
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-center flex-wrap container-nav" style="width: 100%;">

          <div class="d-flex align-items-center justify-content-center">
            <a class="me-3" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
              <ion-icon name="menu-outline" style="font-size: 36px; margin-top: 10px;"></ion-icon>
            </a>

            <a class="navbar-brand" href="?key=home"><img src="assets/png_darulang.png" alt="logo" style="max-width: 150px"></a>
          </div>

          <div class="mx-auto container-search" style="width: 60%;">
            <form method="GET">
              <div class="input-group d-flex flex-nowrap ">
                <input type="hidden" name="key" value="product">
                <input name="search" type="text" class="form-control search-input" placeholder="Search Product" aria-label="Cari sayuran" aria-describedby="button-addon2" value="<?= filter_input(INPUT_GET, 'search') ?>" style="min-width: 200px;">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </div>
            </form>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button> -->
          </div>


          <div class="text-end">
            <?php if ($_SESSION['web_user'] && $menu == 'product') { ?>
              <button class="btn btn-success" data-bs-toggle='modal' data-bs-target='#cartModal'>
                <i class="fa-solid fa-cart-shopping"></i>
              </button>
            <?php }
            if ($_SESSION['web_user']) { ?>
              <a class="btn btn-danger" href="?key=logout">Log out</a>
            <?php } else { ?>
              <a class="btn btn-outline-success" href="?key=login">Login</a>
              <a class="btn btn-success ms-2" href="?key=register">Register</a>
            <?php } ?>
          </div>
        </div>
      </div>


    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <a class="navbar-brand" href="?key=home"><img src="assets/png_darulang.png" alt="logo" style="max-width: 150px"></a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

      </div>
      <div class="offcanvas-body">
        <div class="d-flex flex-column align-items-center">
          <div class="border-bottom mb-3 d-flex " style="width: 100%;">
            <a class="" href="?key=home">Home</a>
          </div>
          <div class="border-bottom mb-3 d-flex " style="width: 100%;">
            <a class="" href="?key=product">Products</a>
          </div>
          <?php if ($_SESSION['web_user'] && $_SESSION['web_user_role'] == 'Admin') { ?>
            <div class="border-bottom mb-3 d-flex " style="width: 100%;">
              <a class="" href="?key=productManagement">Products Management</a>
            </div>
          <?php }
          if ($_SESSION['web_user']) { ?>
            <div class="border-bottom mb-3 d-flex " style="width: 100%;">
              <a class="" href="?key=order">Order</a>
            </div>
          <?php } ?>

        </div>
      </div>
    </div>
  <?php } ?>

  <div class="container">
    <?php
    switch ($menu) {
      case 'home':
        $homeController = new HomeController();
        $homeController->index();
        break;
      case 'product':
        $ProductController = new ProductController();
        $ProductController->index();
        break;
      case 'productManagement':
        $ProductController = new ProductController();
        $ProductController->index_admin();
        break;
      case 'order':
        $orderController = new OrderController();
        if ($_SESSION['web_user'] && $_SESSION['web_user_role'] == "Admin") {
          $orderController->index_admin();
        } else {
          $orderController->index();
        }
        break;
      case 'checkout':
        $orderController = new OrderController();
        $orderController->checkout();
        break;
      case 'login':
        $userController = new UserController();
        $userController->index();
        break;
      case 'register':
        $userController = new UserController();
        $userController->register();
        break;
      case 'logout':
        $userController = new UserController();
        $userController->logout();
        break;
      default:
        $homeController = new HomeController();
        $homeController->index();
        break;
    }
    ?>
  </div>
</body>
<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted">
  <!-- Section: Social media -->
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <!-- Left -->
    <div class="me-5 d-none d-lg-block">
      <span>Get connected with us on social networks:</span>
    </div>
    <!-- Left -->

    <!-- Right -->
    <div>
      <a href="https://instagram.com/darulang.now?igshid=YmMyMTA2M2Y=" target="_blank" class="me-4 text-reset">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-google"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-github"></i>
      </a>
    </div>
    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <!-- <i class="fas fa-gem me-3"></i>DARULANG -->
            <!-- <i class="fas fa-gem me-3"></i>DARULANG -->
            <i><img src="assets/d_logo.png" alt="" style="width:30px;padding-right: 10px"></i>DARULANG
          </h6>
          <p>
            Let's be the part of #earthhero by upcycle with us to be friends of the earth 🌎 wujudkan #bumiberpotensi
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Products
          </h6>
          <p>
            <a href="?key=product" class="text-reset">Bags</a>
          </p>
          <p>
            <a href="?key=product" class="text-reset">Totebag</a>
          </p>
          <!-- <p>
            <a href="#!" class="text-reset">Accessories</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Vue</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Laravel</a>
          </p> -->
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Links</h6>
          <!-- <p>
            <a href="#!" class="text-reset">Pricing</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Settings</a>
          </p> -->
          <p>
            <a href="?key=product" class="text-reset">Orders</a>
          </p>
          <!-- <p>
            <a href="#!" class="text-reset">Help</a>
          </p> -->
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-home me-3"></i>Universitas Kristen Maranatha</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            darulang.now@gmail.com
          </p>
          <p>
            <!-- <i class="fas fa-phone me-3"></i> + 01 234 567 88 -->
          </p>
          <p>
            <!-- <i class="fas fa-print me-3"></i> + 01 234 567 89 -->
          </p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2022 Copyright:
    <a class="text-reset fw-bold" href="https://instagram.com/darulang.now?igshid=YmMyMTA2M2Y=">DARULANG</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->

<script src="https://kit.fontawesome.com/cf5a611c4c.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('.dataTable').DataTable();
  });
</script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</html>