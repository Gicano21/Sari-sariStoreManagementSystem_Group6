<header class="topbar">
    <div class="brand">SARI-SARI STORE</div>
    <?php if (! empty($isOwnerLoggedIn)): ?>
        <div class="account">
            <span>Welcome, <?= esc($ownerName) ?></span>
            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button class="button secondary small" type="submit">Log out</button>
            </form>
        </div>
    <?php else: ?>
        <a class="button secondary small" href="#owner-access">Owner sign in</a>
    <?php endif ?>
</header>