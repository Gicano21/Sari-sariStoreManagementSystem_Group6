<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($this->renderSection('title') ?: 'Inventory') ?> | Sari-sari Store</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <?= $this->include('partial/storeOwner_navbar') ?>
    <?= $this->renderSection('content') ?>
    <?= $this->include('partial/storeOwner_footer') ?>
</body>
</html>