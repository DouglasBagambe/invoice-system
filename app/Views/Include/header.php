<style>
    :root {
        --primary-blue: #3c8dbc;
        --primary-blue-dark: #367fa9;
        --secondary-blue: #2e6da4;
        --accent-blue: #5cb3cc;
        --text-dark: #333;
        --text-light: #666;
        --bg-light: #f8f9fa;
        --border-light: #e3e6f0;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
        --shadow-lg: 0 8px 32px rgba(0,0,0,0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Modern Header Design */
    .main-header {
        background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
        border-bottom: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        height: 60px;
        transition: var(--transition);
    }

    .main-header:hover {
        box-shadow: var(--shadow-md);
    }

    .main-header .navbar {
        background: transparent;
        border: none;
        box-shadow: none;
        margin: 0;
        border-radius: 0;
        min-height: 60px;
        padding: 0;
        margin-left: 230px;
    }

    /* Enhanced Logo Section */
    .main-header .logo {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
        border: none;
        height: 60px;
        line-height: 60px;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
        width: 230px;
        z-index: 1040;
    }

    .main-header .logo::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.6s ease;
        z-index: 0;
    }

    .main-header .logo:hover::before {
        left: 100%;
    }

    .main-header .logo:hover {
        background: linear-gradient(135deg, var(--primary-blue-dark) 0%, var(--secondary-blue) 100%);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .logo-text {
        color: white;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .main-header .logo .logo-mini,
    .main-header .logo .logo-lg { 
        position: relative; 
        z-index: 1; 
    }

    .main-header .logo .logo-mini { display: none; }
    .main-header .logo .logo-lg { display: inline-block; }
    .sidebar-mini.sidebar-collapse .main-header .logo .logo-mini { display: inline-block; }
    .sidebar-mini.sidebar-collapse .main-header .logo .logo-lg { display: none; }
    .sidebar-mini.sidebar-collapse .main-header .logo { width: 50px; }
    .sidebar-mini.sidebar-collapse .main-header .navbar { margin-left: 50px; }

    /* Modern Sidebar Toggle */
    .sidebar-toggle {
        background: transparent !important;
        color: var(--text-dark) !important;
        border: none !important;
        width: 48px;
        height: 60px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: var(--transition) !important;
        border-radius: 0 !important;
    }

    .sidebar-toggle::before {
        content: '';
        position: absolute;
        inset: 8px;
        border-radius: 8px;
        background: transparent;
        transition: var(--transition);
    }

    .sidebar-toggle:hover::before {
        background: var(--bg-light);
    }

    .sidebar-toggle:hover {
        color: var(--primary-blue) !important;
        transform: scale(1.05);
    }

    .sidebar-toggle i { 
        font-size: 14px; 
        line-height: 1; 
    }

    .sidebar-toggle:focus {
        outline: 2px solid var(--primary-blue);
        outline-offset: 2px;
    }

    /* Enhanced User Menu */
    .navbar-custom-menu {
        margin: 0;
        height: 60px;
        display: flex;
        align-items: center;
    }

    .user-menu {
        position: relative;
    }
    
    .user-menu > a {
        padding: 0 20px !important;
        height: 60px !important;
        display: flex !important;
        align-items: center !important;
        color: var(--text-dark) !important;
        transition: var(--transition) !important;
        border-radius: 0 !important;
        position: relative;
        overflow: hidden;
    }

    .user-menu > a::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--bg-light);
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s ease;
    }

    .user-menu > a:hover::before {
        transform: scaleX(1);
        transform-origin: left;
    }

    .user-menu > a:hover {
        background: transparent !important;
        color: var(--primary-blue) !important;
    }

    .user-menu-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-header {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        box-shadow: 0 2px 8px rgba(60, 141, 188, 0.2);
    }

    .user-info-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-name-display {
        font-weight: 600;
        font-size: 14px;
        line-height: 1;
        margin-bottom: 2px;
    }

    .user-status {
        font-size: 11px;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dropdown-caret {
        font-size: 10px;
        margin-left: 8px;
        transition: transform 0.3s ease;
    }

    .user-menu.open .dropdown-caret {
        transform: rotate(180deg);
    }

    /* Ultra-Modern Dropdown */
    .user-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 320px;
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-light);
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        margin-top: 8px;
        z-index: 9999;
    }

    .user-dropdown.show {
        opacity: 1;
        transform: translateY(0) scale(1);
        visibility: visible;
    }

    .dropdown-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
        padding: 24px 20px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dropdown-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="1.5" fill="rgba(255,255,255,0.08)"/><circle cx="60" cy="30" r="0.8" fill="rgba(255,255,255,0.12)"/></svg>');
        opacity: 0.6;
    }

    .dropdown-user-info {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .dropdown-avatar {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        border: 2px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
    }

    .dropdown-user-details h4 {
        margin: 0 0 4px;
        font-weight: 600;
        font-size: 18px;
    }
    
    .dropdown-user-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 13px;
    }

    .dropdown-menu-items {
        padding: 12px 0;
    }

    .dropdown-menu-item {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        color: var(--text-dark);
        text-decoration: none;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .dropdown-menu-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary-blue);
        transform: scaleY(0);
        transition: var(--transition);
    }

    .dropdown-menu-item:hover::before {
        transform: scaleY(1);
    }

    .dropdown-menu-item:hover {
        background: var(--bg-light);
        color: var(--primary-blue);
        padding-left: 28px;
    }

    .dropdown-menu-item i {
        width: 20px;
        margin-right: 16px;
        font-size: 16px;
        color: var(--text-light);
        transition: var(--transition);
    }
    
    .dropdown-menu-item:hover i {
        color: var(--primary-blue);
        transform: scale(1.1);
    }
    
    .dropdown-divider {
        height: 1px;
        background: var(--border-light);
        margin: 8px 20px;
    }
    
    .dropdown-menu-item.logout {
        margin-top: 8px;
        border-top: 1px solid var(--border-light);
        color: #dc3545;
    }

    .dropdown-menu-item.logout:hover {
        background: #fff5f5;
        color: #dc3545;
    }

    .dropdown-menu-item.logout i {
        color: #dc3545;
    }

    /* Content spacing */
    .content-wrapper {
        margin-top: 60px;
        padding: 16px 20px;
        border-left: 1px solid var(--border-light);
        min-height: calc(100vh - 60px);
        background: #fff;
    }

    /* Animation */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .user-menu:hover .user-avatar-header {
        animation: pulse 2s infinite;
    }

    /* Focus States */
    .dropdown-menu-item:focus {
        outline: 2px solid var(--primary-blue);
        outline-offset: -2px;
    }

    .user-menu > a:focus {
        outline: 2px solid var(--primary-blue);
        outline-offset: 2px;
    }

    /* Responsive Design */
    @media (max-width: 767px) {
        .main-header .logo .logo-lg {
            display: none;
        }

        .user-info-header {
            display: none;
        }

        .user-dropdown {
            width: 280px;
            right: -10px;
        }
    }
</style>

<header class="main-header" role="banner">
    <!-- Enhanced Logo -->
    <a href="<?= base_url('/dashboard'); ?>" class="logo" aria-label="EMAX Supplies & Logistics Home">
        <span class="logo-mini"><b>E</b></span>
        <span class="logo-sm logo-text"><b>EMAX</b></span>
    </a>
    
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Modern Sidebar Toggle -->
        <!-- <button type="button" class="sidebar-toggle" data-toggle="push-menu" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button> -->

        <!-- Enhanced User Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="user-menu-content">
                            <div class="user-avatar-header">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="user-info-header">
                                <div class="user-name-display"><?= safe_esc(safe_session_get('name', 'User')); ?></div>
                                <div class="user-status">Online</div>
                            </div>
                            <i class="fa fa-caret-down dropdown-caret"></i>
                        </div>
                    </a>
                    
                    <!-- Ultra-Modern Dropdown -->
                    <div class="user-dropdown">
                        <div class="dropdown-header">
                            <div class="dropdown-user-info">
                                <div class="dropdown-avatar">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="dropdown-user-details">
                                    <h4><?= safe_esc(safe_session_get('name', 'User')); ?></h4>
                                    <p>System Administrator</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dropdown-menu-items">
                            <!-- Commented out menu items for future use
                            <a href="<?= base_url('/profile'); ?>" class="dropdown-menu-item">
                                <i class="fa fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="<?= base_url('/account'); ?>" class="dropdown-menu-item">
                                <i class="fa fa-cog"></i>
                                <span>Account Settings</span>
                            </a>
                            <a href="<?= base_url('/preferences'); ?>" class="dropdown-menu-item">
                                <i class="fa fa-bell"></i>
                                <span>Notifications</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('/help'); ?>" class="dropdown-menu-item">
                                <i class="fa fa-question-circle"></i>
                                <span>Help & Support</span>
                            </a>
                            <a href="<?= base_url('/security'); ?>" class="dropdown-menu-item">
                                <i class="fa fa-shield"></i>
                                <span>Security</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            -->
                            
                            <!-- Active logout item -->
                            <a href="<?= base_url('/login/logout'); ?>" class="dropdown-menu-item logout">
                                <i class="fa fa-power-off"></i>
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- <script>
$(document).ready(function() {
    // Enhanced sidebar state management
    const SIDEBAR_STATE_KEY = 'emax.sidebar.collapsed';
    const $body = $('body');
    const $sidebarToggle = $('.sidebar-toggle');
    
    // Apply sidebar state from storage
    function applySidebarState() {
        const collapsed = localStorage.getItem(SIDEBAR_STATE_KEY) === 'true';
        $body.toggleClass('sidebar-collapse', collapsed);
        $sidebarToggle.attr('aria-expanded', (!collapsed).toString());
    }
    
    applySidebarState();
    
    // Enhanced sidebar toggle
    $sidebarToggle.on('click', function(e) {
        e.preventDefault();
        const willCollapse = !$body.hasClass('sidebar-collapse');
        
        $body.toggleClass('sidebar-collapse');
        localStorage.setItem(SIDEBAR_STATE_KEY, willCollapse.toString());
        $(this).attr('aria-expanded', (!willCollapse).toString());
    });
    
    // Ultra-smooth dropdown functionality
    let dropdownTimeout;
    
    $('.user-menu .dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $menu = $(this).closest('.user-menu');
        const $dropdown = $menu.find('.user-dropdown');
        const isOpen = $dropdown.hasClass('show');
        
        // Close all dropdowns first
        $('.user-dropdown').removeClass('show');
        $('.user-menu').removeClass('open');
        
        if (!isOpen) {
            setTimeout(() => {
                $dropdown.addClass('show');
                $menu.addClass('open');
            }, 10);
        }
    });
    
    // Enhanced hover effects
    $('.user-menu').on('mouseenter', function() {
        clearTimeout(dropdownTimeout);
        const $dropdown = $(this).find('.user-dropdown');
        const $menu = $(this);
        
        setTimeout(() => {
            if ($menu.is(':hover')) {
                $dropdown.addClass('show');
                $menu.addClass('open');
            }
        }, 100);
    }).on('mouseleave', function() {
        const $dropdown = $(this).find('.user-dropdown');
        const $menu = $(this);
        
        dropdownTimeout = setTimeout(() => {
            $dropdown.removeClass('show');
            $menu.removeClass('open');
        }, 150);
    });
    
    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.user-menu').length) {
            $('.user-dropdown').removeClass('show');
            $('.user-menu').removeClass('open');
        }
    });
    
    // Keyboard navigation
    $('.dropdown-toggle').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $(this).trigger('click');
        }
        if (e.key === 'Escape') {
            $('.user-dropdown').removeClass('show');
            $('.user-menu').removeClass('open');
        }
    });
    
    // Smooth menu item interactions
    $('.dropdown-menu-item').on('mouseenter', function() {
        $(this).css('transform', 'translateX(4px)');
    }).on('mouseleave', function() {
        $(this).css('transform', 'translateX(0)');
    });
    
    // Performance optimization: debounced resize handler
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            $('.user-dropdown').removeClass('show');
            $('.user-menu').removeClass('open');
        }, 250);
    });
});
</script> -->