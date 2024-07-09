<div class="h2 mt-4">Daftar Transaksi</div>
<div class="accordion mt-4 col-8" id="accordionOrder">
    <?php foreach ($orders as $order) {
        $total = 0 ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading-<?= $order->getId() ?>">
                <button class="accordion-button collapsed text-light bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $order->getId() ?>" aria-expanded="true" aria-controls="collapse-<?= $order->getId() ?>">
                    ID Order : <?= $order->getId() ?>
                </button>
            </h2>
            <div id="collapse-<?= $order->getId() ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $order->getId() ?>" data-bs-parent="#accordionOrder">
                <div class="accordion-body row">
                    <div class="col">
                        <div class="h5"><strong>Daftar Product :</strong></div>
                        <ol class="list-group list-group-numbered">
                            <?php foreach ($order->getProduct() as $product) {
                                $total += $product->getPrice() * $product->amount ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold"><?= $product->getName() ?></div>
                                        <?= $product->getPrice() ?> x <?= $product->amount ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                    <div class="col">
                        <div class="h5"><strong>Waktu :</strong></div>
                        <p><?= $order->getTime() ?></p>
                        <div class="h5"><strong>Lokasi :</strong></div>
                        <p><?= $order->getLocation() ?></p>
                        <div class="h5"><strong>Status :</strong></div>
                        <p>Success</p>
                        <div class="h5"><strong>Total Harga :</strong></div>
                        <p>Rp. <?= $total ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
if (count($orders) == 0) {
    echo '<a href="index.php?key=product" style="width: 100%">
        <img id="cartEmpty" src="assets/empty-cart.png" alt="emptyCart"></a>';
    echo '<br><p id="cartText">Yahhh!! Kamu belum memiliki orderan</p>';
}
?>