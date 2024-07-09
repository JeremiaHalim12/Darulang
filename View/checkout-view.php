<div class="row g-5 mt-4">
    <div class="col-md-5 col-lg-4 order-md-last card">
        <div class="card-body">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-success">Your cart</span>
                <span class="badge bg-success rounded-pill"><?= count($cart->getItemCart()) ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php
                /** @var Cart $cart
                 *  @var CartItem $item
                 */
                $total = 0;
                foreach ($cart->getItemCart() as $item) { ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?= $item->getProduct()->getName() ?></h6>
                            <small class="text-muted"><?= $item->getProduct()->getCategory() ?></small>
                        </div>
                        <span class="text-muted"><?= $item->getProduct()->getPrice() ?> x <?= $item->getAmount() ?></span>
                    </li>
                <?php $total += $item->getProduct()->getPrice() * $item->getAmount();
                } ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (IDR)</span>
                    <strong><?= $total ?></strong>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Informasi Pelanggan</h4>
        <form method="post">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Your name" value="<?= $user->getName() ?>" required>
                </div>

                <div class="col-sm-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="08xx" value="<?= $user->getPhone() ?>" required>
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="location" id="address" class="form-control" placeholder="Your complete address" rows="4"></textarea>
                </div>

                <div class="col-md-5">
                    <label for="time" class="form-label">Date</label>
                    <input type="date" min="<?= date('Y-m-d'); ?>" class="form-select" id="time" name="time" required>
                </div>

            </div>

            <hr class="my-4">

            <button class="w-100 btn btn-success btn-lg" name="checkout" type="submit">Continue</button>
        </form>
    </div>
</div>