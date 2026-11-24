<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Sari-sari Store</title>
    <style>
        :root { --ink:#202b25; --muted:#718078; --green:#176b4a; --green-dark:#10553a; --line:#e4ebe6; }
        * { box-sizing:border-box; }
        body { align-items:center; background:#f4f7f4; color:var(--ink); display:flex; font:15px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif; justify-content:center; margin:0; min-height:100vh; padding:24px; }
        .card { background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 16px 48px #18271d12; max-width:460px; padding:36px; width:100%; }
        .brand { color:var(--green); font-size:13px; font-weight:800; letter-spacing:.08em; }
        h1 { font-size:27px; margin:10px 0 5px; }
        .subtitle { color:var(--muted); margin:0 0 20px; }
        label { display:block; font-size:13px; font-weight:650; margin:15px 0 6px; }
        input { border:1px solid #d5dfd8; border-radius:8px; font:inherit; min-height:44px; padding:10px 12px; width:100%; }
        input:focus { border-color:var(--green); outline:3px solid #176b4a20; }
        button,.back { align-items:center; border:0; border-radius:8px; display:flex; font:inherit; font-weight:700; justify-content:center; min-height:44px; text-decoration:none; width:100%; }
        button { background:var(--green); color:#fff; cursor:pointer; margin-top:22px; }
        button:hover { background:var(--green-dark); }
        .back { background:#eef3ef; color:var(--ink); margin-top:10px; }
        .alert { background:#fff0ef; border-radius:8px; color:#962e2e; margin:0 0 18px; padding:11px 13px; }
        .alert ul { margin:6px 0 0; padding-left:18px; }
    </style>
</head>
<body>
<main class="card">
    <div class="brand">SARI-SARI STORE</div>
    <h1>Create an account</h1>
    <p class="subtitle">Register as a store owner.</p>
    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
    <?php if ($errors): ?>
        <div class="alert" role="alert">
            Please correct the following:
            <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul>
        </div>
    <?php endif ?>
    <form action="<?= site_url('storeOwner/register') ?>" method="post">
        <?= csrf_field() ?>
        <label for="name">Full name</label>
        <input id="name" name="name" value="<?= esc(old('name')) ?>" maxlength="255" autocomplete="name" required autofocus>
        <label for="username">Username</label>
        <input id="username" name="username" value="<?= esc(old('username')) ?>" minlength="3" maxlength="30" autocomplete="username" required>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= esc(old('email')) ?>" maxlength="254" autocomplete="email" required>
        <label for="password">Password (at least 8 characters)</label>
        <input id="password" name="password" type="password" minlength="8" maxlength="255" autocomplete="new-password" required>
        <label for="password_confirm">Confirm password</label>
        <input id="password_confirm" name="password_confirm" type="password" minlength="8" maxlength="255" autocomplete="new-password" required>
        <button type="submit">Create account</button>
    </form>
    <a class="back" href="<?= site_url('login') ?>">Back to sign in</a>
</main>
</body>
</html>
