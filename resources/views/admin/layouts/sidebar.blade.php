<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">


        @php
            $notifications = \App\Models\OrderPlacedNotification::where('seen', 1)->latest()->take(5)->get();
            $unseenMessages = \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0])->count();
        @endphp

        @if (auth()->user()->id === 1)
            <li class="dropdown dropdown-list-toggle"><a href="{{ route('admin.chat.index') }}"
                class="nav-link nav-link-lg message_envelop {{ $unseenMessages > 0 ? 'beep' : '' }}"><i
                    class="far fa-envelope"></i></a>
            </li>
        @endif

        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg notification_beep {{ $notifications === 0 ? 'beep' : '' }}"><i
                    class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="{{ route('admin.clear-notification') }}">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons rt_notification">
                    @foreach ($notifications as $notification)
                        <a href="{{ route('admin.order.view', $notification->order_id) }}" class="dropdown-item">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {!! $notification->message !!}
                                <div class="time">{{ date('h:i A | d-F-Y', strtotime($notification->created_at)) }}
                                </div>
                                <div class="time">seen</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('admin.all-orders') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->user()->avatar) }}" style="height: 50px;width:50px;" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('admin.settings') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                {{-- <div class="dropdown-divider"></div> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#"
                        onclick="event.preventDefault();
                    this.closest('form').submit();"
                        class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>

            </div>
        </li> 
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">{{ config('settings.site_name') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="javascript:;">FP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ activateSidebar(['admin.dashboard']) }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Starter</li>

            <li class="{{ activateSidebar(['admin.slider.*']) }}"><a class="nav-link" href="{{ route('admin.slider.index') }}"><i class="fas fa-images"></i></i><span>Slider</span></a></li>

            <li class="{{ activateSidebar(['admin.daily-offer.*']) }}"><a class="nav-link" href="{{ route('admin.daily-offer.index') }}"><i class="fas fa-business-time"></i></i><span>Daily Offer</span></a></li>

            <li class="dropdown {{ activateSidebar([
                'admin.all-orders',
                'admin.pending-orders',
                'admin.processing-orders',
                'admin.delivered-orders',
                'admin.declined-orders'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i>
                    <span>Manage Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ activateSidebar(['admin.all-orders']) }}"><a class="nav-link" href="{{ route('admin.all-orders') }}">All Orders</a></li>
                    <li class="{{ activateSidebar(['admin.pending-orders']) }}"><a class="nav-link" href="{{ route('admin.pending-orders') }}">Pending Orders</a></li>
                    <li class="{{ activateSidebar(['admin.processing-orders']) }}"><a class="nav-link" href="{{ route('admin.processing-orders') }}">Processing Orders</a></li>
                    <li class="{{ activateSidebar(['admin.delivered-orders']) }}"><a class="nav-link" href="{{ route('admin.delivered-orders') }}">Delivered Orders</a></li>
                    <li class="{{ activateSidebar(['admin.declined-orders']) }}"><a class="nav-link" href="{{ route('admin.declined-orders') }}">Declined Orders</a></li>
                </ul>
            </li>

            <li class="dropdown {{ activateSidebar(['admin.category.*', 'admin.product.*', 'admin.product-review.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i>
                    <span>Manage Products</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ activateSidebar(['admin.category.*']) }}"><a class="nav-link" href="{{ route('admin.category.index') }}">Product Categories</a></li>
                    <li class="{{ activateSidebar(['admin.product.*']) }}"><a class="nav-link" href="{{ route('admin.product.index') }}">Products</a></li>
                    <li class="{{ activateSidebar(['admin.product-review.*']) }}"><a class="nav-link" href="{{ route('admin.product-review.index') }}">Product Reviews</a></li>
                </ul>
            </li>

            <li class="dropdown {{ activateSidebar(['admin.coupon.*', 'admin.delivery-area.*', 'admin.payment-settings.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-store"></i>
                    <span>Manage Ecommerce</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ activateSidebar(['admin.coupon.*']) }}"><a class="nav-link" href="{{ route('admin.coupon.index') }}">Coupon</a></li>
                    <li class="{{ activateSidebar(['admin.delivery-area.*']) }}"><a class="nav-link" href="{{ route('admin.delivery-area.index') }}">Delivery Areas</a></li>
                    <li class="{{ activateSidebar(['admin.payment-settings.*']) }}"><a class="nav-link" href="{{ route('admin.payment-settings.index') }}">Payment Gateways</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ activateSidebar(['admin.reservation-time.*', 'admin.reservation.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chair"></i>
                    <span>Manage Reservation</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ activateSidebar(['admin.reservation-time.*']) }}"><a class="nav-link" href="{{ route('admin.reservation-time.index') }}">Reservation Time</a></li>
                    <li class="{{ activateSidebar(['admin.reservation.*']) }}"><a class="nav-link" href="{{ route('admin.reservation.index') }}">Reservation</a></li>
                </li>
                </ul>
            </li>

            @if (auth()->user()->id === 1)
                <li class="{{ activateSidebar(['admin.chat.*']) }}"><a class="nav-link" href="{{ route('admin.chat.index') }}"><i class="fas fa-comment-dots"></i></i><span>Messages</span></a></li>
            @endif

            <li class="{{ activateSidebar(['admin.contact.*']) }}"><a class="nav-link" href="{{ route('admin.contact.index') }}"><i class="fas fa-id-card-alt"></i><span>Contact</span></a></li>

            <li class="dropdown {{ activateSidebar(['admin.blogs-category.*', 'admin.blogs.*', 'admin.blogs.comments.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fab fa-blogger-b"></i></i>
                    <span>Blog</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ activateSidebar(['admin.blogs-category.*']) }}"><a class="nav-link" href="{{ route('admin.blogs-category.index') }}">Category</a></li>
                    <li class="{{ activateSidebar(['admin.blogs.*']) }}"><a class="nav-link" href="{{ route('admin.blogs.index') }}">Blog</a></li>
                    <li class="{{ activateSidebar(['admin.blogs-comments.*']) }}"><a class="nav-link" href="{{ route('admin.blogs.comments.index') }}">Comment</a></li>
                </li>
                </ul>
            </li>

            <li class="dropdown {{ activateSidebar([
                'admin.why-choose-us.*',
                'admin.banner-slider.*',
                'admin.chef-team.*',
                'admin.app-download.*',
                'admin.testimonial.*',
                'admin.counter.*'
            ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-puzzle-piece"></i>
                    <span>Manage Sections</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ activateSidebar(['admin.why-choose-us.*']) }}"><a class="nav-link" href="{{ route('admin.why-choose-us.index') }}">Why Choose Us</a></li>
                    <li class="{{ activateSidebar(['admin.banner-slider.*']) }}"><a class="nav-link" href="{{ route('admin.banner-slider.index') }}">Banner Slider</a></li>
                    <li class="{{ activateSidebar(['admin.chef-team.*']) }}"><a class="nav-link" href="{{ route('admin.chef-team.index') }}">Chef Team</a></li>
                    <li class="{{ activateSidebar(['admin.app-download.*']) }}"><a class="nav-link" href="{{ route('admin.app-download.index') }}">App Download</a></li>
                    <li class="{{ activateSidebar(['admin.testimonial.*']) }}"><a class="nav-link" href="{{ route('admin.testimonial.index') }}">Testimonial</a></li>
                    <li class="{{ activateSidebar(['admin.counter.*']) }}"><a class="nav-link" href="{{ route('admin.counter.index') }}">Counter</a></li>
                </ul>
            </li>

            <li class="dropdown {{ activateSidebar(['admin.custom-page-builder.*', 'admin.about-page.*', 'admin.privacy-policy.*', 'admin.terms&condition.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file-alt"></i></i>
                    <span>Pages</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ activateSidebar(['admin.custom-page-builder.*']) }}"><a class="nav-link" href="{{ route('admin.custom-page-builder.index') }}">Custom Page</a></li>
                    <li class="{{ activateSidebar(['admin.about-page.*']) }}"><a class="nav-link" href="{{ route('admin.about-page.index') }}">About Page</a></li>
                    <li class="{{ activateSidebar(['admin.privacy-policy.*']) }}"><a class="nav-link" href="{{ route('admin.privacy-policy.index') }}">Privacy Policy</a></li>
                    <li class="{{ activateSidebar(['admin.terms&condition.*']) }}"><a class="nav-link" href="{{ route('admin.terms&condition.index') }}">Terms & Conditions</a></li>
                </li>
                </ul>
            </li>

            <li class="{{ activateSidebar(['admin.newsletter-subscribers.*']) }}"><a class="nav-link" href="{{ route('admin.newsletter-subscribers.index') }}"><i class="far fa-newspaper"></i></i><span>Newsletter</span></a></li>

            <li class="{{ activateSidebar(['admin.social-links.*']) }}"><a class="nav-link" href="{{ route('admin.social-links.index') }}"><i class="fas fa-link"></i></i><span>Social Link</span></a></li>

            <li class="{{ activateSidebar(['admin.footer-info.*']) }}"><a class="nav-link" href="{{ route('admin.footer-info.index') }}"><i class="fas fa-shoe-prints"></i><span>Footer Info</span></a></li>
            </li>

            <li class="{{ activateSidebar(['admin.menu-builder.*']) }}"><a class="nav-link" href="{{ route('admin.menu-builder.index') }}"><i class="fas fa-gopuram"></i></i><span>Menu Builder</span></a></li>

            <li class="{{ activateSidebar(['admin.admin-management.*']) }}"><a class="nav-link" href="{{ route('admin.admin-management.index') }}"><i class="fas fa-user-shield"></i></i><span>Admin Management</span></a></li>

            <li class="{{ activateSidebar(['admin.settings']) }}"><a class="nav-link" href="{{ route('admin.settings') }}"><i class="fas fa-cogs"></i></i><span>Settings</span></a></li>

            <li class="{{ activateSidebar(['admin.clear-database.*']) }}"><a class="nav-link" href="{{ route('admin.clear-database.index') }}"><i class="fas fa-trash"></i></i><span>Clear Database</span></a></li>

        </ul>

    </aside>
</div>
