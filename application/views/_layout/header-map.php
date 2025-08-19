<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?= base_url('assets/'); ?>img/logo/logo.png" rel="icon">
    <title><?= $this->config->item('appname'); ?> - <?= $title; ?></title>
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>vendor/datatables/responsive.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>vendor/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css">

    <link href="<?= base_url('assets/'); ?>css/ruang-admin.min.css" rel="stylesheet">

    <!-- Leaflet Map Section -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #footerMap {
            height: 300px;
            width: 100%;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
    <!-- Leaflet.draw CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />


</head>

<body id="page-top">
    <div id="wrapper">
