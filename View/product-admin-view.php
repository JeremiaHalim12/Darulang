<div class="m-auto row">
    <div class="col">
        <h2>Add Product</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="name" class="form-label">Name</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama product" autofocus required>
            </div>
            <label for="price" class="form-label">Harga</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="price" name="price" placeholder="Harga product" required>
            </div>
            <label for="stock" class="form-label">Stok</label>
            <div class="input-group mb-3">
                <input type="number" min="0" class="form-control" id="stock" name="stock" placeholder="Stok product" required>
            </div>
            <label for="image" class="form-label">Image</label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg, image/png">
            </div>
            <label for="category" class="form-label">Category</label>
            <div class="input-group mb-3">
                <select name="category" id="category" class="form-select">
                    <?php
                    foreach ($categories as $category) {
                        echo '<option value="' . $category->getId() . '">' . $category->getName() . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="d-grid gap-2 d-md-block text-center">
                <button type="submit" name="submitProduct" class="btn btn-success">Submit</button>
                <button type="reset" name="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>
    <div class="col">
        <h2>Add Category</h2>
        <form action="" method="post">
            <label for="name" class="form-label">Name</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Kategori" autofocus required>
            </div>
            <div class="d-grid gap-2 d-md-block text-center">
                <button type="submit" name="submitCategory" class="btn btn-success">Submit</button>
                <button type="reset" name="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>
</div>

<div class="m-auto">
    <table class="table dataTable" id="example" style="width:100%">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Image</th>
                <th scope="col">Category</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($product as $item) {
                echo "<tr>";
                echo "<td scope='row'>{$item->getId()}</td>";
                echo "<td id='name-{$item->getId()}'>{$item->getName()}</td>";
                echo "<td id='price-{$item->getId()}'>{$item->getPrice()}</td>";
                echo "<td id='stock-{$item->getId()}'>{$item->getStock()}</td>";
                echo "<td><img src='Uploads/" . $item->getImage() . "' style='max-width: 50px'></td>";
                echo "<td class='{$item->getCategory()->getId()}' id='category-{$item->getId()}'>{$item->getCategory()->getName()}</td>";
                echo "<td>";
                echo "<button data-bs-toggle='modal' data-bs-target='#exampleModal' onclick='updateProduct({$item->getId()})' class='btn btn-warning'>
            <i class='fa-solid fa-edit'></i>
            </button>";
                echo "<button onclick='deleteProduct({$item->getId()})' class='btn btn-danger ms-2'>
            <i class='fa-solid fa-trash'></i>
            </button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="idUpdate" id="idUpdate">
                <div class="modal-body">
                    <label for="name" class="form-label">Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="nameUpdate" name="nameUpdate" placeholder="Nama product" autofocus required>
                    </div>
                    <label for="price" class="form-label">Harga</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="priceUpdate" name="priceUpdate" placeholder="Harga product" required>
                    </div>
                    <label for="stock" class="form-label">Stok</label>
                    <div class="input-group mb-3">
                        <input type="number" min="0" class="form-control" id="stockUpdate" name="stockUpdate" placeholder="Stok product" required>
                    </div>
                    <label for="image" class="form-label">Image</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="imageUpdate" name="imageUpdate" accept="image/jpeg, image/png">
                    </div>
                    <label for="category" class="form-label">Category</label>
                    <div class="input-group mb-3">
                        <select name="categoryUpdate" id="categoryUpdate" class="form-select">
                            <?php
                            foreach ($categories as $category) {
                                echo '<option value="' . $category->getId() . '">' . $category->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submitUpdate" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteProduct(id) {
        if (confirm("Are you sure?")) {
            window.location.href = "index.php?key=productManagement&delete-confirm=yes&id=" + id;
        }
    }

    function updateProduct(id) {
        let name = $("#name-" + id).text();
        let price = $("#price-" + id).text();
        let stock = $("#stock-" + id).text();
        let category = $("#category-" + id).attr("class");

        $("#idUpdate").val(id);
        $("#nameUpdate").val(name);
        $("#priceUpdate").val(price);
        $("#stockUpdate").val(stock);
        $("#categoryUpdate").val(category);
    }
</script>