<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMAX Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Base styles for the header */
        .main-header {
            background: #367fa9;
            position: relative;
            height: 50px;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }

        /* Logo styling - improved spacing and typography */
        .logo {
            float: left;
            height: 50px;
            font-size: 20px;
            line-height: 50px;
            text-align: center;
            width: 250px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 300;
            overflow: hidden;
            color: #fff;
            text-decoration: none;
            display: block;
            transition: width 0.3s ease-in-out;
        }

        .logo:hover {
            color: #f0f0f0;
            text-decoration: none;
        }

        .logo-mini {
            display: none;
            font-weight: 600;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .logo-lg {
            display: inline-block;
            font-weight: 300;
            font-size: 18px;
        }

        .logo-lg b {
            font-weight: 600;
            color: #fff;
        }

        .logo-company-type {
            font-size: 12px;
            color: rgba(255,255,255,0.8);
            margin-left: 8px;
            font-weight: 400;
        }

        /* Navbar styling */
        .navbar {
            margin-bottom: 0;
            margin-left: 250px;
            border: none;
            min-height: 50px;
            border-radius: 0;
            background: #3c8dbc;
        }

        .navbar-static-top {
            border: 0;
        }

        .sidebar-toggle {
            float: left;
            color: #fff;
            padding: 15px 15px;
            font-size: 18px;
            line-height: 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(0,0,0,0.1);
            color: #fff;
            text-decoration: none;
        }

        .sidebar-toggle span {
            display: block;
            width: 20px;
            height: 2px;
            background: #fff;
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Navbar custom menu */
        .navbar-custom-menu {
            float: right;
            list-style: none;
        }

        .navbar-nav {
            margin: 0;
            float: left;
        }

        .navbar-nav > li {
            float: left;
            position: relative;
        }

        .navbar-nav > li > a {
            padding: 15px 15px;
            color: #fff;
            line-height: 20px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .navbar-nav > li > a:hover {
            background: rgba(0,0,0,0.1);
            color: #fff;
        }

        /* Notification styles */
        .notifications-menu .label {
            position: absolute;
            top: 9px;
            right: 7px;
            text-align: center;
            font-size: 9px;
            padding: 2px 3px;
            line-height: .9;
        }

        .label-warning {
            background-color: #f39c12;
        }

        /* Dropdown menu styles */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 280px;
            padding: 5px 0;
            margin: 2px 0 0;
            font-size: 14px;
            text-align: left;
            list-style: none;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 6px 12px rgba(0,0,0,.175);
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu .header {
            padding: 7px 20px;
            border-bottom: 1px solid #f4f4f4;
            color: #444;
            font-size: 14px;
            font-weight: 600;
        }

        .dropdown-menu .menu {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 200px;
            overflow: auto;
        }

        .dropdown-menu .menu li a {
            display: block;
            padding: 10px 20px;
            color: #444;
            text-decoration: none;
            white-space: nowrap;
            border-bottom: 1px solid #f4f4f4;
            transition: background-color 0.3s ease;
        }

        .dropdown-menu .menu li a:hover {
            background: #f4f4f4;
        }

        .dropdown-menu .footer {
            background: #f4f4f4;
            padding: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        .dropdown-menu .footer a {
            color: #444;
            text-decoration: none;
            font-weight: 600;
        }

        /* User menu styles */
        .user-image {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            margin-right: 10px;
            margin-top: -2px;
            vertical-align: middle;
        }

        .user-header {
            padding: 20px;
            text-align: center;
            background: #367fa9;
            color: #fff;
        }

        .user-header img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.3);
            margin-bottom: 15px;
        }

        .user-header p {
            margin: 0;
            font-weight: 600;
        }

        .user-header small {
            display: block;
            font-size: 12px;
            opacity: 0.8;
        }

        .user-footer {
            padding: 10px;
            background: #f4f4f4;
            overflow: hidden;
        }

        .pull-left {
            float: left;
        }

        .pull-right {
            float: right;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-default:hover {
            color: #333;
            background-color: #e6e6e6;
            border-color: #adadad;
            text-decoration: none;
        }

        .btn-flat {
            border-radius: 0;
            border: 1px solid #ddd;
        }

        .hidden-xs {
            font-size: 14px;
            font-weight: 400;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            border: 0;
        }

        /* Icon colors */
        .text-aqua { color: #00c0ef; }
        .text-yellow { color: #f39c12; }
        .text-red { color: #dd4b39; }
        .text-green { color: #00a65a; }

        /* Responsive design */
        @media (max-width: 767px) {
            .navbar {
                margin-left: 0;
            }
            
            .logo {
                width: 50px;
            }
            
            .logo-lg {
                display: none;
            }
            
            .logo-mini {
                display: inline-block;
            }
            
            .hidden-xs {
                display: none;
            }
        }

        /* Clearfix */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <!-- Logo - Better organized and spaced -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>EMAX</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <b>EMAX</b> 
                <span class="logo-company-type">Supplies & Logistics</span>
            </span>
        </a>
        
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button - improved design -->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span></span>
                <span></span>
                <span></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="https://via.placeholder.com/25x25" class="user-image" alt="User Image" id="imagePreview3">
                            <span class="hidden-xs">John Doe</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="https://via.placeholder.com/90x90" class="img-circle" alt="User Image" id="imagePreview4">
                                <p>
                                    John Doe - Web Developer
                                    <small>Member since Nov. 2018</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer clearfix">
                                <div class="pull-left">
                                    <a href="/profile/settings" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/login/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar">
                            <i class="fa fa-gears"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <script>
        // Simple dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdown = this.nextElementSibling;
                    const isOpen = dropdown.classList.contains('show');
                    
                    // Close all dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                    
                    // Toggle current dropdown
                    if (!isOpen) {
                        dropdown.classList.add('show');
                    }
                });
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>
</body>
</html>