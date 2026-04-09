<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <a class="sidebar-brand" href="/">
                                <span class="sidebar-brand-text align-middle">
                                    Dashboard
                                </span>
                                <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                                    <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                                    <path d="M20 12L12 16L4 12"></path>
                                    <path d="M20 16L12 20L4 16"></path>
                                </svg>
                            </a>

                            <div class="sidebar-user">
                                <div class="d-flex justify-content-center">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo $user->avatar ? UPLOADS_PATH . '/avatars/' . $user->avatar : ASSETS_PATH . '/admin/img/user-avatar.png'; ?>" class="avatar img-fluid rounded me-1" alt="Charles Hall">
                                    </div>
                                    <div class="flex-grow-1 ps-2">
                                        <a class="sidebar-user-title" href="#" data-bs-toggle="dropdown">
                                            <?php echo $user->username ?>
                                        </a>

                                        <div class="sidebar-user-subtitle">Admin</div>
                                    </div>
                                </div>
                            </div>

                            <ul class="sidebar-nav">
                                <li class="sidebar-header">
                                    Pages
                                </li>

                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>">
                                        <i class="fa-solid fa-chart-line dash-icon"></i>
                                        <span class="align-middle">Dashboard</span>
                                    </a>
                                </li>

                                <li class="sidebar-header">
                                    CMS
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>pages">
                                        <i class="far fa-fw fa-question-circle dash-icon"></i>
                                        <span class="align-middle">Pages</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>widgets">
                                        <i class="far fa-fw fa-question-circle dash-icon"></i>
                                        <span class="align-middle">Widgets</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>blog-articles">
                                        <i class="fa fa-fw fa-bullhorn dash-icon"></i>
                                        <span class="align-middle">Blog</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>faqs">
                                        <i class="far fa-fw fa-question-circle dash-icon"></i>
                                        <span class="align-middle">FAQs</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>enquiries">
                                        <i class="fas fa-fw fa-envelope dash-icon"></i>
                                        <span class="align-middle">Enquiries</span>
                                    </a>
                                </li>

                                <li class="sidebar-header d-none">
                                    <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Commerce
                                    </a>
                                </li>
                                <div class="collapse d-none" id="collapseExample">
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="<?php echo DIRADMIN; ?>orders">
                                            <i class="fas fa-fw fa-truck dash-icon"></i>
                                            <span class="align-middle">Orders</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="<?php echo DIRADMIN; ?>invoices">
                                            <i class="fas fa-fw fa-file-invoice-dollar dash-icon"></i>
                                            <span class="align-middle">Invoices</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="<?php echo DIRADMIN; ?>payments">
                                            <i class="far fa-fw fa-money-bill-alt dash-icon"></i>
                                            <span class="align-middle">Payments</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="<?php echo DIRADMIN; ?>purchases">
                                            <i class="far fa-fw fa-list-alt dash-icon"></i>
                                            <span class="align-middle">Purchases</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a data-bs-target="#inventory" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                                            <i class="fas fa-fw fa-store dash-icon"></i>
                                            <span class="align-middle">Inventory</span>
                                        </a>
                                        <ul id="inventory" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo DIRADMIN; ?>inventory-items"><i class="fas faw fa-shopping-bag dash-icon"></i>Inventory Items</a></li>
                                            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo DIRADMIN; ?>inventory-categories"><i class="far fa-fw fa-list-alt dash-icon"></i>Inventory Categories</a></li>
                                        </ul>
                                    </li>
                                </div>


                                <li class="sidebar-header d-none">
                                    Mass Communication
                                </li>
                                <li class="sidebar-item d-none">
                                    <a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                                        <i class="far fa-fw fa-comments dash-icon"></i>
                                        <span class="align-middle">SMS</span>
                                    </a>
                                    <ul id="ui" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                        <!-- <li class="sidebar-item"><a class="sidebar-link" href="<?php echo DIRADMIN; ?>sms">Overview</a></li> -->
                                        <li class="sidebar-item"><a class="sidebar-link" href="<?php echo DIRADMIN; ?>sms-sent">Sent</a></li>
                                        <li class="sidebar-item"><a class="sidebar-link" href="<?php echo DIRADMIN; ?>sms-templates">Templates</a></li>
                                        <li class="sidebar-item"><a class="sidebar-link" href="<?php echo DIRADMIN; ?>sms-subscribers">Subscribers</a></li>
                                    </ul>
                                </li>
                                

                                <li class="sidebar-header">
                                    Administration
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>users">
                                        <i class="fas fa-fw fa-users-cog dash-icon"></i>
                                        <span class="align-middle">Users</span>
                                    </a>
                                </li>
                                <!-- <li class="sidebar-item">
                                    <a class="sidebar-link" href="<?php echo DIRADMIN; ?>settings">
                                        <i class="fas fa-fw fa-cog dash-icon"></i>
                                        <span class="align-middle">Settings</span>
                                    </a>
                                </li> -->
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 1326px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="height: 92px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div>
</nav>