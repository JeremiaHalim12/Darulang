<div class="row mt-4 mb-3">
  <div class="col-4">
    <form id="formFilter" method="GET">
      <input name="key" value="product" type="hidden">
      <h1 style="color: #45a3a4;">OUR PRODUCT</h1>
      <div class="input-group">
        <select id="filter" class="form-select" name="filter" onchange="searchFilter()">
          <option>All</option>
          <?php foreach ($categories as $category) { ?>
            <option value="<?= $category->getId() ?>" <?php echo $category->getId() == $filter ? 'selected' : '' ?>>
              <?= $category->getName() ?></option>
          <?php } ?>
        </select>
      </div>
    </form>
  </div>
</div>
<div class="col my-4 m-auto">
  <div class="d-flex flex-wrap">
    <?php

    foreach ($product as $p) {

      echo "<div class='card m-3 shadow-sm' style='width: 18rem;'>";
      echo "<img id='image-{$p->getId()}' src='Uploads/{$p->getImage()}' class='card-img-top'>";
      echo "<div class='card-body'>";
      echo "<a id='name-{$p->getId()}' class='card-title h5' onclick='detailProduct({$p->getId()})' data-bs-toggle='modal' data-bs-target='#exampleModal' href=''>{$p->getName()}</a>";
      echo "<p id='category-{$p->getId()}' class='card-text'>{$p->getCategory()->getName()}</p>";
      echo "<p id='price-{$p->getId()}' class='card-text'>Rp. {$p->getPrice()}</p>";
      echo "</div>";
      echo "</div>";
    }
    ?>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          <h5 class="nameDetail"></h5>
        </h5>
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <img id="imageDetail" style="width:1500px;" src="" class="img-fluid">
          </div>
          <div class="col-md-8">
            <h6>ID product</h6>
            <h5 id="idDetail"></h5>
            <h6>Nama product</h6>
            <h5 id="nameDetail"></h5>
            <h6>Harga satuan</h6>
            <h5 id="priceDetail"></h5>
            <h6>Kategori product</h6>
            <h5 id="categoryDetail"></h5>
            <h6>Product description</h6>
            <h5>Produk terbuat dari sampah kotak susu dan plastik, tentu sudah melalui tahap
              pembersihan. Produk dijahit dengan sangat rapi sehingga tahan untuk membawa barang yang cukup berat.
            </h5>
            <h5>Berukuran 15x10x10</h5>
            <input class="form-control mt-4" type="number" min="1" id="amount" value="1">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button onclick="addCart()" type="button" class="btn btn-success">Tambah Keranjang</button>
      </div>
    </div>
  </div>
</div>

<?php if ($_SESSION['web_user']) { ?>
  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-light">
          <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table" style="width:100%">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Amount</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $priceTotal = 0;
              /**
               * @var Cart $cart
               * @var int $index
               * @var  CartItem $item
               */
              foreach ($cart->getItemCart() as $index => $item) {
                echo '<tr>';
                echo '<td>' . ($index + 1) . '</td>';
                echo '<td>' . $item->getProduct()->getName() . '</td>';
                echo '<td>' . $item->getProduct()->getPrice() . '</td>';
                echo '<td>' . $item->getAmount() . '</td>';
                echo '<td>';
                echo '<form method="get">';
                echo '<input type="hidden" name="key" value="product">';
                echo '<input type="hidden" name="deleteCart" value="1">';
                echo '<input type="hidden" name="user-id" value="' . $cart->getUser()->getId() . '">';
                echo '<input type="hidden" name="product-id" value="' . $item->getProduct()->getId() . '">';
                echo '<button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-trash"></i>
                    </button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
                $priceTotal += $item->getProduct()->getPrice() * $item->getAmount();
              }
              ?>
            </tbody>
          </table>
          <div>Total Harga : <?= $priceTotal ?></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form method="post" action="?key=checkout">
            <input type="hidden" name="makeOrder" value="1">
            <?php if (count($cart->getItemCart()) > 0) { ?>
              <button type="submit" class="btn btn-success">Buat Order</button>
            <?php } ?>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<script>
  function searchFilter() {
    let form = $('#formFilter');
    let data = '<?= filter_input(INPUT_GET, 'search') ?>';
    if (data != '') {
      let search = `<input type="hidden" name="search" value="${data}">`;
      form.append(search);
    }
    form.submit();
  }

  function detailProduct(id) {
    let name = $(`#name-${id}`).text();
    let price = $(`#price-${id}`).text();
    let category = $(`#category-${id}`).text();
    let image = $(`#image-${id}`).prop('src');

    $('#nameDetail').text(name);
    $('.nameDetail').text(name);
    $('#priceDetail').text(price);
    $('#categoryDetail').text(category);
    $('#idDetail').text(id);
    $('#imageDetail').attr('src', image);
  }

  function addCart() {
    let id = $('#idDetail').text();
    let amount = $('#amount').val();

    window.location = 'index.php?key=product&addcart=1&product-id=' + id + '&amount=' + amount;
  }
</script>