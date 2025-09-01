<?php
// Pure PHP Dashboard - NO CodeIgniter dependencies
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: https://invoice.biiteeksms.com/login');
    exit;
}

// Database connection (we know this works)
$mysqli = new mysqli('localhost', 'biiteeks_invoice', 'L+.a72a7dZuA6F', 'biiteeks_invoice_db', 3306);

if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// Get basic stats
$clientcount = 0;
$invcount = 0;
$monthturn = 0;

$result = $mysqli->query("SELECT COUNT(*) as count FROM client");
if ($result && $row = $result->fetch_assoc()) {
    $clientcount = $row['count'];
}

$result = $mysqli->query("SELECT COUNT(*) as count FROM invtest2");
if ($result && $row = $result->fetch_assoc()) {
    $invcount = $row['count'];
}

$currentMonth = date('Y-m');
$result = $mysqli->query("SELECT SUM(totalamount) as total FROM invtest2 WHERE DATE_FORMAT(created, '%Y-%m') = '$currentMonth'");
if ($result && $row = $result->fetch_assoc()) {
    $monthturn = $row['total'] ?? 0;
}

$mysqli->close();

// Get user info
$username = $_SESSION['username'] ?? 'User';
$name = $_SESSION['name'] ?? 'User';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard - Invoice Management System</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Header -->
    <header class="main-header">
        <a href="#" class="logo">
            <span class="logo-mini"><b>I</b>MS</span>
            <span class="logo-lg"><b>Invoice</b>MS</span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="https://invoice.biiteeksms.com/public/dist/img/uploads/default.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= htmlspecialchars($name) ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="https://invoice.biiteeksms.com/login/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="https://invoice.biiteeksms.com/public/dist/img/uploads/default.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?= htmlspecialchars($name) ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active">
                    <a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li><a href="/client/manageclients"><i class="fa fa-users"></i> <span>Manage Clients</span></a></li>
                <li><a href="/product/manageproducts"><i class="fa fa-gears"></i> <span>Products</span></a></li>
                <li><a href="/quote/genquote"><i class="fa fa-file-text"></i> <span>Quotations</span></a></li>
                <li><a href="/taxinv/gentaxinv"><i class="fa fa-file-invoice"></i> <span>Tax Invoices</span></a></li>
                <li><a href="/login/logout"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
            </ul>
        </section>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Dashboard <small>Control panel</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <section class="content">
            <!-- Stats boxes -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?= $invcount ?></h3>
                            <p>Total Invoices</p>
                        </div>
                        <div class="icon"><i class="ion ion-bag"></i></div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?= $clientcount ?></h3>
                            <p>Total Clients</p>
                        </div>
                        <div class="icon"><i class="ion ion-person-add"></i></div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?= number_format($monthturn, 2) ?></h3>
                            <p>Monthly Turnover</p>
                        </div>
                        <div class="icon"><i class="ion ion-pie-graph"></i></div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?= date('M Y') ?></h3>
                            <p>Current Period</p>
                        </div>
                        <div class="icon"><i class="ion ion-calendar"></i></div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Welcome to Your Dashboard</h3>
                        </div>
                        <div class="box-body">
                            <p>✅ <strong>Dashboard is now working!</strong></p>
                            <p>You have successfully logged in and can access your dashboard.</p>
                            <p>Database connection: <span class="text-green"><strong>Active</strong></span></p>
                            <p>Session: <span class="text-green"><strong>Valid</strong></span></p>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Clients</span>
                                            <span class="info-box-number"><?= $clientcount ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green"><i class="fa fa-file-text"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Invoices</span>
                                            <span class="info-box-number"><?= $invcount ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Monthly Revenue</span>
                                            <span class="info-box-number">₹<?= number_format($monthturn, 2) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs"><b>Version</b> 2.4.0</div>
        <strong>Copyright &copy; 2020-2025 Invoice Management System.</strong> All rights reserved.
    </footer>
</div>

<script src="https://invoice.biiteeksms.com/public/bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://invoice.biiteeksms.com/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://invoice.biiteeksms.com/public/dist/js/adminlte.min.js"></script>
</body>
</html>
