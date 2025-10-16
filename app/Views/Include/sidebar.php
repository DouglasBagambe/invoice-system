<aside id="main-sidebar" class="main-sidebar" role="complementary" aria-label="Navigation Sidebar">
    <section class="sidebar-container">
        <!-- Ultra-Modern Navigation -->
        <nav class="sidebar-nav" role="navigation" aria-label="Primary Navigation">
            
            <!-- Navigation Header -->
            <div class="nav-header">
                <div class="nav-brand">
                    <div class="brand-icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    <div class="brand-text">
                        <h3>Navigation</h3>
                        <p>Main Menu</p>
                    </div>
                </div>
            </div>

            <!-- Primary Menu Items -->
            <div class="nav-section">
                <div class="nav-section-header">
                    <!-- <span>CORE</span> -->
                </div>
                
                <!-- Dashboard -->
                <div class="nav-item <?= set_active('/dashboard') ? 'active' : '' ?>">
                    <a href="<?= base_url('/dashboard'); ?>" class="nav-link" data-tooltip="Dashboard">
                        <div class="nav-icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <span class="nav-text">Dashboard</span>
                        <div class="nav-indicator"></div>
                    </a>
                </div>

                <!-- Commented out core menu items for future use -->
                <!-- <div class="nav-item <?= set_active('/clients') ? 'active' : '' ?>">
                    <a href="<?= base_url('/client/manageclients'); ?>" class="nav-link" data-tooltip="Manage Clients">
                        <div class="nav-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="nav-text">Clients</span>
                        <div class="nav-badge">
                            <span>New</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </div>

                <div class="nav-item <?= set_active('/products') ? 'active' : '' ?>">
                    <a href="<?= base_url('/product/manageproducts'); ?>" class="nav-link" data-tooltip="Product Management">
                        <div class="nav-icon">
                            <i class="fa fa-cube"></i>
                        </div>
                        <span class="nav-text">Products</span>
                        <div class="nav-indicator"></div>
                    </a>
                </div>

                <div class="nav-item <?= set_active('/suppliers') ? 'active' : '' ?>">
                    <a href="<?= base_url('/supplier/managesupplier'); ?>" class="nav-link" data-tooltip="Supplier Management">
                        <div class="nav-icon">
                            <i class="fa fa-truck"></i>
                        </div>
                        <span class="nav-text">Suppliers</span>
                        <div class="nav-indicator"></div>
                    </a>
                </div> -->
            </div>

            <!-- Invoice Management Section -->
            <div class="nav-section">
                <div class="nav-section-header">
                    <!-- <span>INVOICING</span> -->
                </div>
                
                <!-- Create Invoices Group -->
                <div class="nav-item nav-group <?= (set_active('proinv/genproinv') || set_active('taxinv/gentaxinv')) ? 'active expanded' : '' ?>">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Create Invoices" 
                       aria-expanded="<?= (set_active('proinv/genproinv') || set_active('taxinv/gentaxinv')) ? 'true' : 'false' ?>">
                        <div class="nav-icon">
                            <i class="fa fa-plus-circle"></i>
                        </div>
                        <span class="nav-text">Create Invoice</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('proinv/genproinv') ? 'active' : '' ?>">
                            <a href="<?= base_url('/proinv/genproinv'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <span class="nav-sub-text">Create Proforma Invoice</span>
                            </a>
                        </div>
                        <!-- <div class="nav-sub-item <?= set_active('taxinv/gentaxinv') ? 'active' : '' ?>">
                            <a href="<?= base_url('/taxinv/gentaxinv'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-receipt"></i>
                                </div>
                                <span class="nav-sub-text">Tax Invoice</span>
                            </a>
                        </div> -->
                    </div>
                </div>

                <!-- Manage Invoices Group -->
                <div class="nav-item nav-group <?= (set_active('proinv/showprodata') || set_active('taxinv/showtaxdata')) ? 'active expanded' : '' ?>">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Manage Invoices"
                       aria-expanded="<?= (set_active('proinv/showprodata') || set_active('taxinv/showtaxdata')) ? 'true' : 'false' ?>">
                        <div class="nav-icon">
                            <i class="fa fa-folder-open"></i>
                        </div>
                        <span class="nav-text">Manage Invoice</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('proinv/showprodata') ? 'active' : '' ?>">
                            <a href="<?= base_url('/proinv/showprodata'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <span class="nav-sub-text">Proforma List</span>
                            </a>
                        </div>
                        <!-- <div class="nav-sub-item <?= set_active('taxinv/showtaxdata') ? 'active' : '' ?>">
                            <a href="<?= base_url('/taxinv/showtaxdata'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-file-invoice"></i>
                                </div>
                                <span class="nav-sub-text">Tax Invoice List</span>
                            </a>
                        </div> -->
                    </div>
                </div>

                <!-- Commented out additional invoice sections for future use -->
                <!-- <div class="nav-item nav-group">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Quotations">
                        <div class="nav-icon">
                            <i class="fa fa-quote-right"></i>
                        </div>
                        <span class="nav-text">Quotations</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('/quickquote/') ? 'active' : '' ?>">
                            <a href="<?= base_url('/quickquote/'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-bolt"></i>
                                </div>
                                <span class="nav-sub-text">Quick Quote</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('/quote/genquote') ? 'active' : '' ?>">
                            <a href="<?= base_url('/quote/genquote'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-calculator"></i>
                                </div>
                                <span class="nav-sub-text">Generate Quote</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('/quote/showquotedata') ? 'active' : '' ?>">
                            <a href="<?= base_url('/quote/showquotedata'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-list"></i>
                                </div>
                                <span class="nav-sub-text">Quote List</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nav-item nav-group">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Purchases">
                        <div class="nav-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <span class="nav-text">Purchases</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('purchaseinv/genpurchaseinv') ? 'active' : '' ?>">
                            <a href="<?= base_url('/purchaseinv/genpurchaseinv'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-plus"></i>
                                </div>
                                <span class="nav-sub-text">Add Purchase</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('/purchaseinv/showdata') ? 'active' : '' ?>">
                            <a href="<?= base_url('/purchaseinv/showdata'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-list"></i>
                                </div>
                                <span class="nav-sub-text">Purchase List</span>
                            </a>
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Commented out additional sections for future use -->
            <!-- <div class="nav-section">
                <div class="nav-section-header">
                    <span>REPORTING</span>
                </div>

                <div class="nav-item nav-group">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Sales Reports">
                        <div class="nav-icon">
                            <i class="fa fa-chart-bar"></i>
                        </div>
                        <span class="nav-text">Sales Reports</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('taxinv/saleitemreport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/taxinv/saleitemreport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                                <span class="nav-sub-text">Item Sales</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('taxinv/salereport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/taxinv/salereport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-chart-pie"></i>
                                </div>
                                <span class="nav-sub-text">Sales Summary</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nav-item nav-group">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Purchase Reports">
                        <div class="nav-icon">
                            <i class="fa fa-chart-area"></i>
                        </div>
                        <span class="nav-text">Purchase Reports</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('purchaseinv/purchaseitemreport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/purchaseinv/purchaseitemreport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-boxes"></i>
                                </div>
                                <span class="nav-sub-text">Item Purchases</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('purchaseinv/purchasereport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/purchaseinv/purchasereport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-chart-bar"></i>
                                </div>
                                <span class="nav-sub-text">Purchase Summary</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nav-item nav-group">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Quote Reports">
                        <div class="nav-icon">
                            <i class="fa fa-file-chart-line"></i>
                        </div>
                        <span class="nav-text">Quote Reports</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('quickquote/quickquotereport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/quickquote/quickquotereport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-tachometer"></i>
                                </div>
                                <span class="nav-sub-text">Quick Quotes</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('quote/quoteitemreport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/quote/quoteitemreport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-list-check"></i>
                                </div>
                                <span class="nav-sub-text">Quote Items</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('quote/quotereport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/quote/quotereport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                                <span class="nav-sub-text">Quote Analysis</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nav-item nav-group">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Proforma Reports">
                        <div class="nav-icon">
                            <i class="fa fa-file-invoice-dollar"></i>
                        </div>
                        <span class="nav-text">Proforma Reports</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('proinv/proitemreport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/proinv/proitemreport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-cube"></i>
                                </div>
                                <span class="nav-sub-text">Proforma Items</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('proinv/proreport') ? 'active' : '' ?>">
                            <a href="<?= base_url('/proinv/proreport'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-analytics"></i>
                                </div>
                                <span class="nav-sub-text">Proforma Analysis</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-header">
                    <span>MANAGEMENT</span>
                </div>

                <div class="nav-item nav-group">
                    <a href="#" class="nav-link nav-group-toggle" data-tooltip="Accounts">
                        <div class="nav-icon">
                            <i class="fa fa-calculator"></i>
                        </div>
                        <span class="nav-text">Accounts</span>
                        <div class="nav-chevron">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="nav-submenu">
                        <div class="nav-sub-item <?= set_active('/account/manageaccounts') ? 'active' : '' ?>">
                            <a href="<?= base_url('/account/manageaccounts'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <span class="nav-sub-text">Manage Accounts</span>
                            </a>
                        </div>
                        <div class="nav-sub-item <?= set_active('/account/demo') ? 'active' : '' ?>">
                            <a href="<?= base_url('/account/demo'); ?>" class="nav-sub-link">
                                <div class="nav-sub-icon">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                                <span class="nav-sub-text">Account Types</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nav-item <?= set_active('transaction/managetransaction') ? 'active' : '' ?>">
                    <a href="<?= base_url('/transaction/managetransaction'); ?>" class="nav-link" data-tooltip="Transaction Management">
                        <div class="nav-icon">
                            <i class="fa fa-exchange-alt"></i>
                        </div>
                        <span class="nav-text">Transactions</span>
                        <div class="nav-indicator"></div>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-header">
                    <span>EXTERNAL</span>
                </div>

                <div class="nav-item">
                    <a href="https://web.whatsapp.com/" target="_blank" class="nav-link" data-tooltip="WhatsApp Web">
                        <div class="nav-icon">
                            <i class="fa fa-whatsapp"></i>
                        </div>
                        <span class="nav-text">WhatsApp</span>
                        <div class="nav-external">
                            <i class="fa fa-external-link-alt"></i>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-header">
                    <span>SETTINGS</span>
                </div>

                <div class="nav-item <?= set_active('profile/settings') ? 'active' : '' ?>">
                    <a href="<?= base_url('/profile/settings'); ?>" class="nav-link" data-tooltip="System Settings">
                        <div class="nav-icon">
                            <i class="fa fa-cog"></i>
                        </div>
                        <span class="nav-text">Settings</span>
                        <div class="nav-indicator"></div>
                    </a>
                </div>
            </div> -->

            <!-- System Section -->
            <div class="nav-section">
                <div class="nav-section-header">
                    <!-- <span>SYSTEM</span> -->
                </div>
                
                <div class="nav-item logout-item">
                    <a href="<?= base_url('/login/logout'); ?>" class="nav-link" data-tooltip="Sign Out">
                        <div class="nav-icon">
                            <i class="fa fa-power-off"></i>
                        </div>
                        <span class="nav-text">Logout</span>
                        <div class="nav-indicator"></div>
                    </a>
                </div>
            </div>

            <!-- Bottom Spacer -->
            <div class="nav-spacer"></div>
        </nav>
    </section>
</aside>

<style>
    :root {
        --primary-blue: #3c8dbc;
        --primary-blue-dark: #367fa9;
        --secondary-blue: #2e6da4;
        --accent-blue: #5cb3cc;
        --sidebar-bg: #222d32;
        --sidebar-bg-light: #2c3b41;
        --sidebar-bg-lighter: #374850;
        --sidebar-text: #b8c7ce;
        --sidebar-text-active: #fff;
        --sidebar-accent: var(--primary-blue);
        --sidebar-hover: #1e282c;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-fast: all 0.2s ease;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.15);
    }

    /* Main Sidebar Container */
    .main-sidebar {
        background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1a252a 100%);
        width: 230px;
        position: fixed;
        top: 60px;
        left: 0;
        height: calc(100vh - 60px);
        overflow: hidden;
        transition: var(--transition);
        z-index: 1020;
        border-right: 1px solid #1a252a;
        box-shadow: 2px 0 12px rgba(0,0,0,0.1);
    }

    .sidebar-container {
        height: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: thin;
        scrollbar-color: var(--sidebar-bg-light) transparent;
    }

    .sidebar-container::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-container::-webkit-scrollbar-thumb {
        background: var(--sidebar-bg-light);
        border-radius: 4px;
    }

    .sidebar-container::-webkit-scrollbar-thumb:hover {
        background: var(--sidebar-bg-lighter);
    }

    /* Navigation Header */
    .nav-header {
        /* padding: 24px 20px; */
        border-bottom: 1px solid #1a252a;
        background: rgba(0,0,0,0.1);
    }

    .nav-brand {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .brand-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        box-shadow: var(--shadow-sm);
    }

    .brand-text h3 {
        color: var(--sidebar-text-active);
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 4px;
        letter-spacing: 0.5px;
    }

    .brand-text p {
        color: var(--sidebar-text);
        font-size: 12px;
        margin: 0;
        opacity: 0.8;
    }

    /* Navigation Sections */
    .nav-section {
        /* margin-bottom: 8px; */
    }

    .nav-section-header {
        padding: 16px 20px 12px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        margin-bottom: 8px;
    }

    .nav-section-header span {
        color: var(--sidebar-text);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        opacity: 0.7;
    }

    /* Navigation Items */
    .nav-item {
        margin-bottom: 4px;
        position: relative;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        color: var(--sidebar-text) !important;
        text-decoration: none !important;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border-radius: 0;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--sidebar-accent);
        transform: scaleY(0);
        transition: var(--transition);
    }

    .nav-link:hover::before,
    .nav-item.active .nav-link::before {
        transform: scaleY(1);
    }

    .nav-link:hover {
        background: var(--sidebar-hover) !important;
        color: var(--sidebar-text-active) !important;
        padding-left: 28px;
    }

    .nav-item.active .nav-link {
        background: var(--sidebar-hover) !important;
        color: var(--sidebar-text-active) !important;
        padding-left: 28px;
    }

    .nav-icon {
        width: 20px;
        margin-right: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: var(--transition);
    }

    .nav-link:hover .nav-icon,
    .nav-item.active .nav-icon {
        color: var(--sidebar-accent);
        transform: scale(1.1);
    }

    .nav-text {
        flex: 1;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .nav-indicator {
        width: 6px;
        height: 6px;
        background: var(--sidebar-accent);
        border-radius: 50%;
        opacity: 0;
        transform: scale(0);
        transition: var(--transition);
    }

    .nav-item.active .nav-indicator {
        opacity: 1;
        transform: scale(1);
    }

    .nav-badge {
        margin-left: 8px;
    }

    .nav-badge span {
        background: var(--sidebar-accent);
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .nav-external {
        margin-left: 8px;
        opacity: 0.6;
        font-size: 12px;
    }

    /* Navigation Groups */
    .nav-group-toggle {
        cursor: pointer;
    }

    .nav-chevron {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }

    .nav-group.expanded .nav-chevron {
        transform: rotate(180deg);
    }

    .nav-submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, opacity 0.2s ease;
        opacity: 0;
        background: rgba(0,0,0,0.2);
    }

    .nav-group.expanded .nav-submenu {
        max-height: 400px;
        opacity: 1;
    }

    .nav-sub-item {
        position: relative;
    }

    .nav-sub-link {
        display: flex;
        align-items: center;
        padding: 12px 20px 12px 56px;
        color: var(--sidebar-text) !important;
        text-decoration: none !important;
        transition: var(--transition);
        position: relative;
        font-size: 13px;
    }

    .nav-sub-link::before {
        content: '';
        position: absolute;
        left: 44px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--sidebar-accent);
        transform: scaleY(0);
        transition: var(--transition);
    }

    .nav-sub-link:hover::before,
    .nav-sub-item.active .nav-sub-link::before {
        transform: scaleY(1);
    }

    .nav-sub-link:hover {
        background: var(--sidebar-bg-light) !important;
        color: var(--sidebar-text-active) !important;
        padding-left: 60px;
    }

    .nav-sub-item.active .nav-sub-link {
        background: var(--sidebar-bg-light) !important;
        color: var(--sidebar-text-active) !important;
        padding-left: 60px;
    }

    .nav-sub-icon {
        width: 16px;
        margin-right: 12px;
        font-size: 14px;
        opacity: 0.8;
        transition: var(--transition);
    }

    .nav-sub-link:hover .nav-sub-icon,
    .nav-sub-item.active .nav-sub-icon {
        opacity: 1;
        color: var(--sidebar-accent);
    }

    .nav-sub-text {
        font-weight: 400;
    }

    /* Special Items */
    .logout-item .nav-link {
        color: #dc3545 !important;
    }

    .logout-item .nav-link:hover {
        background: rgba(220, 53, 69, 0.1) !important;
        color: #dc3545 !important;
    }

    .logout-item .nav-link::before {
        background: #dc3545;
    }

    .logout-item .nav-icon {
        color: #dc3545 !important;
    }

    /* Collapsed Sidebar Styles */
    .sidebar-collapse .main-sidebar {
        width: 60px;
    }

    .sidebar-collapse .nav-header {
        padding: 20px 10px;
    }

    .sidebar-collapse .brand-text {
        display: none;
    }

    .sidebar-collapse .brand-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }

    .sidebar-collapse .nav-section-header {
        display: none;
    }

    .sidebar-collapse .nav-text {
        display: none;
    }

    .sidebar-collapse .nav-chevron,
    .sidebar-collapse .nav-badge,
    .sidebar-collapse .nav-external,
    .sidebar-collapse .nav-indicator {
        display: none;
    }

    .sidebar-collapse .nav-link {
        justify-content: center;
        padding: 14px 20px;
    }

    .sidebar-collapse .nav-link:hover,
    .sidebar-collapse .nav-item.active .nav-link {
        padding-left: 20px;
    }

    .sidebar-collapse .nav-icon {
        margin-right: 0;
        font-size: 18px;
    }

    .sidebar-collapse .nav-submenu {
        display: none;
    }

    /* Tooltip for collapsed sidebar */
    .sidebar-collapse .nav-link[data-tooltip] {
        position: relative;
    }

    .sidebar-collapse .nav-link[data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 60px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.9);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 9999;
        animation: tooltipSlideIn 0.2s ease;
    }

    .sidebar-collapse .nav-link[data-tooltip]:hover::before {
        content: '';
        position: absolute;
        left: 56px;
        top: 50%;
        transform: translateY(-50%);
        border: 4px solid transparent;
        border-right-color: rgba(0,0,0,0.9);
        z-index: 9999;
    }

    @keyframes tooltipSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50%) translateX(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }
    }

    /* Bottom spacer */
    .nav-spacer {
        height: 40px;
    }

    /* Mobile Responsive */
    @media (max-width: 767px) {
        .main-sidebar {
            transform: translateX(-100%);
        }

        .sidebar-open .main-sidebar {
            transform: translateX(0);
        }
    }

    /* Smooth animations */
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .nav-item {
        animation: fadeInUp 0.3s ease forwards;
    }

    .nav-section:nth-child(1) .nav-item { animation-delay: 0.1s; }
    .nav-section:nth-child(2) .nav-item { animation-delay: 0.2s; }
    .nav-section:nth-child(3) .nav-item { animation-delay: 0.3s; }
</style>

<script>
$(document).ready(function() {
    // Enhanced navigation group toggle
    $('.nav-group-toggle').on('click', function(e) {
        e.preventDefault();
        
        const $group = $(this).closest('.nav-group');
        const $submenu = $group.find('.nav-submenu');
        const isExpanded = $group.hasClass('expanded');
        
        // Close other groups in same section
        $group.siblings('.nav-group').removeClass('expanded').find('.nav-submenu').css('max-height', '0');
        
        // Toggle current group
        if (isExpanded) {
            $group.removeClass('expanded');
            $submenu.css('max-height', '0');
            $(this).attr('aria-expanded', 'false');
        } else {
            $group.addClass('expanded');
            $submenu.css('max-height', $submenu[0].scrollHeight + 'px');
            $(this).attr('aria-expanded', 'true');
        }
    });
    
    // Auto-expand active groups on load
    $('.nav-group').each(function() {
        const $group = $(this);
        const hasActiveItem = $group.find('.nav-sub-item.active').length > 0;
        
        if (hasActiveItem) {
            $group.addClass('expanded');
            const $submenu = $group.find('.nav-submenu');
            $submenu.css('max-height', $submenu[0].scrollHeight + 'px');
            $group.find('.nav-group-toggle').attr('aria-expanded', 'true');
        }
    });
    
    // Enhanced hover effects
    $('.nav-link').on('mouseenter', function() {
        if (!$(this).closest('.nav-item').hasClass('active')) {
            $(this).css('transform', 'translateX(4px)');
        }
    }).on('mouseleave', function() {
        $(this).css('transform', 'translateX(0)');
    });
    
    // Smooth scroll for long menus
    $('.nav-item.active')[0]?.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'nearest' 
    });
    
    // Keyboard navigation
    $('.nav-link').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            if ($(this).hasClass('nav-group-toggle')) {
                $(this).trigger('click');
            } else {
                window.location.href = $(this).attr('href');
            }
        }
    });
    
    // Dynamic tooltip positioning for collapsed sidebar
    if ($('body').hasClass('sidebar-collapse')) {
        $('.nav-link[data-tooltip]').on('mouseenter', function() {
            const $tooltip = $('<div class="nav-tooltip"></div>')
                .text($(this).attr('data-tooltip'))
                .appendTo('body');
                
            const linkRect = this.getBoundingClientRect();
            $tooltip.css({
                position: 'fixed',
                left: linkRect.right + 10,
                top: linkRect.top + (linkRect.height / 2) - ($tooltip.outerHeight() / 2),
                zIndex: 9999
            });
        }).on('mouseleave', function() {
            $('.nav-tooltip').remove();
        });
    }
    
    // Performance optimization: intersection observer for animations
    if (window.IntersectionObserver) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        });
        
        document.querySelectorAll('.nav-item').forEach(item => {
            observer.observe(item);
        });
    }
    
    // Auto-close mobile menu when clicking nav items
    $('.nav-link:not(.nav-group-toggle)').on('click', function() {
        if (window.innerWidth <= 767) {
            $('body').removeClass('sidebar-open');
        }
    });
    
    // Enhanced submenu height calculation
    function updateSubmenuHeight() {
        $('.nav-group.expanded .nav-submenu').each(function() {
            $(this).css('max-height', this.scrollHeight + 'px');
        });
    }
    
    // Recalculate on window resize
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateSubmenuHeight, 250);
    });
});
</script>