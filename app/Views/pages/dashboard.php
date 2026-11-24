<?= $this->extend('layout/storeOwner_layout') ?>

<?= $this->section('title') ?>Inventory<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="page">
    <section class="heading">
        <div>
            <h1>Inventory</h1>
            <p class="subtitle">
                <?= $isOwnerLoggedIn
                    ? 'Manage the products and stock in your store.'
                    : 'Browse the products and stock in the store.' ?>
            </p>
        </div>
    </section>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert success" role="status"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert error" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif ?>
    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <?php if ($errors): ?>
        <div class="alert error" role="alert">
            <strong>Please correct the following:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <?php if (! $isOwnerLoggedIn): ?>
        <section class="panel" id="owner-access" aria-labelledby="owner-access-heading">
            <div class="panel-heading">
                <div>
                    <h2 id="owner-access-heading">Store owner access</h2>
                    <span class="muted">Create an owner account, then sign in to manage products.</span>
                </div>
            </div>
            <div class="access-grid">
                <form class="access-form" action="<?= site_url('storeOwner/login') ?>" method="post">
                    <?= csrf_field() ?>
                    <h2>Sign in</h2>
                    <label for="login-username">Username</label>
                    <input id="login-username" name="username" value="<?= esc(old('username')) ?>" autocomplete="username" required>
                    <label for="login-password">Password</label>
                    <input id="login-password" name="password" type="password" autocomplete="current-password" required>
                    <button class="button" type="submit">Sign in</button>
                </form>
                <form class="access-form" action="<?= site_url('storeOwner/register') ?>" method="post">
                    <?= csrf_field() ?>
                    <h2>Create account</h2>
                    <label for="register-name">Full name</label>
                    <input id="register-name" name="name" value="<?= esc(old('name')) ?>" maxlength="255" autocomplete="name" required>
                    <label for="register-username">Username</label>
                    <input id="register-username" name="username" value="<?= esc(old('username')) ?>" minlength="3" maxlength="100" autocomplete="username" required>
                    <label for="register-email">Email</label>
                    <input id="register-email" name="email" type="email" value="<?= esc(old('email')) ?>" maxlength="255" autocomplete="email" required>
                    <label for="register-password">Password (at least 8 characters)</label>
                    <input id="register-password" name="password" type="password" minlength="8" maxlength="255" autocomplete="new-password" required>
                    <label for="register-password-confirm">Confirm password</label>
                    <input id="register-password-confirm" name="password_confirm" type="password" minlength="8" maxlength="255" autocomplete="new-password" required>
                    <button class="button" type="submit">Create account</button>
                </form>
            </div>
        </section>
    <?php endif ?>

    <section class="stats" aria-label="Inventory summary">
        <div class="stat">
            <span class="stat-label">Products</span>
            <span class="stat-value"><?= esc($productCount) ?></span>
        </div>
        <div class="stat">
            <span class="stat-label">Units in stock</span>
            <span class="stat-value"><?= esc($stockCount) ?></span>
        </div>
    </section>

    <?php if ($isOwnerLoggedIn): ?>
        <section class="panel" aria-labelledby="add-product-heading">
            <div class="panel-heading">
                <div>
                    <h2 id="add-product-heading">Add a product</h2>
                    <span class="muted">Enter the product details to add it to your inventory.</span>
                </div>
            </div>
            <form action="<?= site_url('products') ?>" method="post" class="form-grid">
                <?= csrf_field() ?>
                <div>
                    <label for="product_name">Product name</label>
                    <input id="product_name" name="product_name" maxlength="255" required>
                </div>
                <div>
                    <label for="category">Category</label>
                    <input id="category" name="category" maxlength="255" required>
                </div>
                <div>
                    <label for="unit_price">Unit price</label>
                    <input id="unit_price" name="unit_price" type="number" min="0" step="0.01" required>
                </div>
                <div>
                    <label for="stock_quantity">Stock quantity</label>
                    <input id="stock_quantity" name="stock_quantity" type="number" min="0" step="1" required>
                </div>
                <button class="button" type="submit">Add product</button>
            </form>
        </section>
    <?php endif ?>

    <section class="panel" aria-labelledby="products-heading">
        <div class="panel-heading">
            <div>
                <h2 id="products-heading">Products</h2>
                <span class="muted">
                    <?= $isOwnerLoggedIn
                        ? 'Edit product details or remove products with no sales history.'
                        : 'Sign in as a store owner to manage inventory.' ?>
                </span>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Unit price</th>
                        <th>Stock</th>
                        <?php if ($isOwnerLoggedIn): ?><th>Actions</th><?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="product-name"><?= esc($product['product_name']) ?></td>
                                <td><?= esc($product['category']) ?></td>
                                <td>$<?= number_format((float) $product['unit_price'], 2) ?></td>
                                <td><span class="stock-pill<?= (int) $product['stock_quantity'] < 10 ? ' low' : '' ?>"><?= esc($product['stock_quantity']) ?> units</span></td>
                                <?php if ($isOwnerLoggedIn): ?>
                                    <td>
                                        <div class="actions">
                                            <details>
                                                <summary>Edit</summary>
                                                <form class="edit-form" action="<?= site_url('products/' . $product['product_id'] . '/update') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <strong>Edit product</strong>
                                                    <label for="name-<?= esc($product['product_id']) ?>">Product name</label>
                                                    <input id="name-<?= esc($product['product_id']) ?>" name="product_name" value="<?= esc($product['product_name']) ?>" maxlength="255" required>
                                                    <label for="category-<?= esc($product['product_id']) ?>">Category</label>
                                                    <input id="category-<?= esc($product['product_id']) ?>" name="category" value="<?= esc($product['category']) ?>" maxlength="255" required>
                                                    <label for="price-<?= esc($product['product_id']) ?>">Unit price</label>
                                                    <input id="price-<?= esc($product['product_id']) ?>" name="unit_price" type="number" min="0" step="0.01" value="<?= esc($product['unit_price']) ?>" required>
                                                    <label for="stock-<?= esc($product['product_id']) ?>">Stock quantity</label>
                                                    <input id="stock-<?= esc($product['product_id']) ?>" name="stock_quantity" type="number" min="0" step="1" value="<?= esc($product['stock_quantity']) ?>" required>
                                                    <button class="button" type="submit">Save changes</button>
                                                </form>
                                            </details>
                                            <form action="<?= site_url('products/' . $product['product_id'] . '/delete') ?>" method="post" onsubmit="return confirm('Delete this product? Products with sales history cannot be deleted.');">
                                                <?= csrf_field() ?>
                                                <button class="button danger small" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr><td class="empty" colspan="<?= $isOwnerLoggedIn ? 5 : 4 ?>">No products yet.<?php if ($isOwnerLoggedIn): ?> Use the form above to add your first product.<?php endif ?></td></tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?= $this->endSection() ?>
