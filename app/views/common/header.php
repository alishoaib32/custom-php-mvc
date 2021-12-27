<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boozt | Dashboard</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">

    <!-- endinject -->
    <link rel="shortcut icon" href="https://etsitecdn.theentertainerme.com/favicon.ico">
    <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
    <link rel="stylesheet" href="<?php echo APP_ASSETS_URL . 'assets/css/boozt/boozt.css?v=' . date('Y-m-d-H-i'); ?>">
    <link href="<?php echo APP_ASSETS_URL . 'assets/css/header.css'; ?> " rel="stylesheet">
    <link rel="stylesheet" href="<?php echo APP_ASSETS_URL . 'assets/css/boozt/responsive.css'; ?>">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.css">

</head>
<body class="sidebar-absolute sidebar-hidden">
<div id="app" class="container-scroller wrapper">
    <header class="fixed-top custom-menu-header">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0 d-flex flex-row">

            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            </div>
            <div class="navbar-menu-wrapper row">
                <?php require_once 'top_menu.php' ?>
            </div>
        </nav>
    </header>