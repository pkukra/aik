<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login | AIK Pegawai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 15px;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            background: #fff;
            border-radius: 16px;
            padding: 28px 22px;
            box-shadow: 0 10px 25px rgba(0,0,0,.2);
        }

        .login-card h4 {
            font-weight: 700;
            font-size: 20px;
        }

        .login-card small {
            font-size: 13px;
        }

        .login-card .form-control {
            border-radius: 12px;
            height: 48px;
            font-size: 15px;
        }

        .btn-login {
            border-radius: 12px;
            height: 48px;
            font-weight: 600;
            font-size: 15px;
        }

        /* Khusus layar kecil */
        @media (max-width: 360px) {
            .login-card {
                padding: 22px 18px;
            }
            .login-card h4 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="text-center mb-3">
        <img src="<?= base_url('assets/img/logo.png') ?>" 
             alt="Logo RS"
             style="width:72px"
             class="mb-2">

        <h4 class="mb-1">AIK PEGAWAI</h4>
        <small class="text-muted">
            RS PKU Muhammadiyah Karanganyar
        </small>
    </div>

    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-danger text-center py-2">
            <?= $this->session->flashdata('msg') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('login/auth') ?>">
        <div class="form-group">
            <input type="text" name="username" class="form-control" max='3'
                   placeholder="Username" required autofocus>
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control"
                   placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-login btn-block">
            <i class="fas fa-sign-in-alt"></i> Masuk
        </button>
    </form>

    <div class="text-center mt-3">
        <small class="text-muted">
            © <?= date('Y') ?> RS PKU Muhammadiyah Karanganyar
        </small>
    </div>

</div>

</body>
</html>
