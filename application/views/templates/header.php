<!DOCTYPE html>
<html lang="id">
<head>
    <title>AIK Pegawai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Header Mobile */
        .app-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: #fff;
            padding: 10px 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,.15);
        }

        .app-header .logo {
            width: 50px;
            height: 50px;
            background: #fff;
            border-radius: 50%;
            /* padding: 1px; */
        }

        .app-title {
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
        }

        .app-subtitle {
            font-size: 11px;
            opacity: .85;
        }

        .btn-logout {
            font-size: 12px;
            padding: 5px 10px;
        }

        .btn-logout:hover {
            background: rgba(255,255,255,.3);
            color: #fff;
        }
    </style>
    <style>
        .app-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #ffffff;
            border-top: 1px solid #e5e5e5;
            padding: 8px 0;
            font-size: 12px;
            z-index: 1000;
        }

        body {
            padding-bottom: 55px; /* supaya konten tidak ketutup footer */
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
</head>
<body>

<!-- HEADER -->
<div class="app-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">

            <!-- Logo + Text -->
            <div class="d-flex align-items-start">
                <img src="<?= base_url('assets/img/logo.png') ?>" class="logo mr-2">
                <div>
                    <div class="app-title">AIK PEGAWAI</div>
                    <div class="app-subtitle">RS PKU Muhammadiyah Karanganyar</div>
                </div>
            </div>

            <!-- Logout -->
            <a href="<?= site_url('login/logout') ?>" class="btn btn-danger btn-logout ">
                <i class="fas fa-sign-out-alt"></i>
            </a>

        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container mt-3">
