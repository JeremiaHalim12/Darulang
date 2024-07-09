<div class="row mt-4">
    <div class="col">
        <div class="card shadow p-4">
            <div class="h2 fw-bold">Grafik Total Pesanan</div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col">
        <div class="card shadow p-4">
            <div class="h2 fw-bold">Total Users</div>
            <div class="h3 text-end"><?= $totalUsers ?> Users</div>
        </div>
        <div class="card shadow p-4 mt-3">
            <div class="h2 fw-bold">Total Penjualan</div>
            <div class="h3 text-end"><?= $totalOrders ?> Pesanan</div>
        </div>
    </div>
</div>


<div class="h2 mt-4 fw-bold">Daftar Pesanan</div>
<div class="m-auto mt-4">
    <table class="table dataTable" id="example" style="width:100%">
        <thead>
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Name</th>
                <th scope="col">Time</th>
                <th scope="col">Location</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($orders as $item) {
                echo "<tr>";
                echo "<td scope='row'>{$item->getId()}</td>";
                echo "<td id='name-{$item->getId()}'>{$item->getUser()->getName()}</td>";
                echo "<td id='time-{$item->getId()}'>{$item->getTime()}</td>";
                echo "<td id='location-{$item->getId()}'>{$item->getLocation()}</td>";
                echo "<td id='status-{$item->getId()}'>Success</td>";
                echo "<td>";
                echo "<button data-bs-toggle='modal' data-bs-target='#detailModal-{$item->getId()}' class='btn'>
            <i class='fa-solid fa-eye' style='color: #38a3a5'></i>
            </button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php /** @var Order $order */ foreach ($orders as $order) { ?>
    <div class="modal fade" id="detailModal-<?= $order->getId() ?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $priceTotal = 0;
                            /**
                             * @var int $index
                             * @var  Product $item
                             */
                            foreach ($order->getProduct() as $index => $item) {
                                echo '<tr>';
                                echo '<td>' . ($index + 1) . '</td>';
                                echo '<td>' . $item->getName() . '</td>';
                                echo '<td>' . $item->getPrice() . '</td>';
                                echo '<td>' . $item->amount . '</td>';
                                echo '</tr>';
                                $priceTotal += $item->getPrice() * $item->amount;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div>Total Harga : <?= $priceTotal ?></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    let orders = <?= json_encode($countOrders) ?>;
    console.log(orders);
    const labels = [];
    const datas = [];

    $.each(orders, function(key, value) {
        labels.push(value.time);
        datas.push(value.count);
    });

    const data = {
        labels: labels,
        datasets: [{
            label: 'Transaksi',
            borderColor: 'rgb(56, 163, 165)',
            backgroundColor: 'rgb(128, 237, 153, 0.5)',
            borderWidth: 2,
            borderRadius: 15,
            borderSkipped: false,
            data: datas,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
        }
    };
</script>
<script>
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>