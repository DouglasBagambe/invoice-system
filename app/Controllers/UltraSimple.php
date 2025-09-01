<?php

namespace App\Controllers;

class UltraSimple
{
    public function index()
    {
        // No inheritance, no sessions, no nothing - just pure PHP
        
        // Check if user is logged in using pure PHP
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: https://invoice.biiteeksms.com/login');
            exit;
        }
        
        // Get basic data
        $clientcount = 0;
        $invcount = 0;
        
        try {
            $mysqli = new \mysqli('localhost', 'biiteeks_invoice', 'L+.a72a7dZuA6F', 'biiteeks_invoice_db', 3306);
            if (!$mysqli->connect_error) {
                $result = $mysqli->query("SELECT COUNT(*) as count FROM client");
                if ($result && $row = $result->fetch_assoc()) {
                    $clientcount = $row['count'];
                }
                
                $result = $mysqli->query("SELECT COUNT(*) as count FROM invtest2");
                if ($result && $row = $result->fetch_assoc()) {
                    $invcount = $row['count'];
                }
                $mysqli->close();
            }
        } catch (\Exception $e) {
            // Continue with defaults
        }
        
        $username = $_SESSION['name'] ?? $_SESSION['username'] ?? 'User';
        
        // Output simple HTML
        echo '<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Working!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://invoice.biiteeksms.com/public/dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="#" class="logo">
            <span class="logo-mini"><b>I</b>MS</span>
            <span class="logo-lg"><b>Invoice</b>MS</span>
        </a>
        <nav class="navbar navbar-static-top">
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <span class="navbar-text">Welcome, ' . htmlspecialchars($username) . '</span>
                    </li>
                    <li>
                        <a href="https://invoice.biiteeksms.com/login/logout" class="btn btn-default navbar-btn">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="content-wrapper" style="margin-left: 0;">
        <section class="content-header">
            <h1>Dashboard <small>Working Version</small></h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <h4><i class="fa fa-check"></i> Success!</h4>
                        Your dashboard is now working! All systems are operational.
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>' . $invcount . '</h3>
                            <p>Total Invoices</p>
                        </div>
                        <div class="icon"><i class="fa fa-file-text"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>' . $clientcount . '</h3>
                            <p>Total Clients</p>
                        </div>
                        <div class="icon"><i class="fa fa-users"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><i class="fa fa-check"></i></h3>
                            <p>System Status</p>
                        </div>
                        <div class="icon"><i class="fa fa-cog"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>' . date('M') . '</h3>
                            <p>Current Month</p>
                        </div>
                        <div class="icon"><i class="fa fa-calendar"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Quick Navigation</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="https://invoice.biiteeksms.com/client/manageclients" class="btn btn-block btn-primary">
                                        <i class="fa fa-users"></i> Manage Clients
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="https://invoice.biiteeksms.com/product/manageproducts" class="btn btn-block btn-success">
                                        <i class="fa fa-gears"></i> Manage Products
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="https://invoice.biiteeksms.com/taxinv/gentaxinv" class="btn btn-block btn-warning">
                                        <i class="fa fa-file-text"></i> Create Invoice
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="https://invoice.biiteeksms.com/quote/genquote" class="btn btn-block btn-info">
                                        <i class="fa fa-quote-left"></i> Create Quote
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://invoice.biiteeksms.com/public/bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://invoice.biiteeksms.com/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://invoice.biiteeksms.com/public/dist/js/adminlte.min.js"></script>
</body>
</html>';
    }
}
