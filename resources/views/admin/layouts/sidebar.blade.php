<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->guard('admin')->user()->image) }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Xin chào, {{ auth()->guard('admin')->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile.index') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Hồ sơ cá nhân
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                    this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">JobList Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Bảng điều khiển</li>

            <li class="{{ setSidebarActive(['admin.dashboard']) }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Tổng
                        quan</span></a>
            </li>

            <li class="menu-header">Chức năng</li>

            @if (canAccess(['order index']))
                <li class="{{ setSidebarActive(['admin.orders.*']) }}"><a class="nav-link"
                        href="{{ route('admin.orders.index') }}"><i class="fas fa-cart-plus"></i> <span>Đơn hàng</span></a>
                </li>
            @endif

            @if (canAccess(['job category create', 'job category update', 'job category delete']))
                <li class="{{ setSidebarActive(['admin.job-categories.*']) }}"><a class="nav-link"
                        href="{{ route('admin.job-categories.index') }}"><i class="fas fa-list"></i> <span>Danh mục việc làm</span></a></li>
            @endif

            @if (canAccess(['job create', 'job update', 'job delete']))
                <li class="{{ setSidebarActive(['admin.jobs.*']) }}"><a class="nav-link"
                        href="{{ route('admin.jobs.index') }}"><i class="fas fa-briefcase"></i> <span>Bài đăng việc
                            làm</span></a>
                </li>
            @endif
            @if (canAccess(['company index']))
                <li class="{{ setSidebarActive(['admin.companies.*']) }}">
                    <a class="nav-link" href="{{ route('admin.companies.index') }}">
                        <i class="fas fa-building"></i> <span>Danh sách công ty</span>
                    </a>
                </li>
            @endif

            @if (canAccess(['job role']))
                <li class="{{ setSidebarActive(['admin.job-roles.*']) }}"><a class="nav-link"
                        href="{{ route('admin.job-roles.index') }}"><i class="fas fa-user-md"></i> <span>Vai trò công
                            việc</span></a></li>
            @endif

            @if (canAccess(['job attributes']))
                        <li class="dropdown {{ setSidebarActive([
                    'admin.industry-types.*',
                    'admin.organization-types.*',
                    'admin.languages.*',
                    'admin.professions.*',
                    'admin.skills.*',
                    'admin.educations.*',
                    'admin.job-types.*',
                    'admin.salary-types.*',
                    'admin.tags.*',
                    'admin.job-experiences.*'
                ]) }}">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                                <span>Thuộc tính</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ setSidebarActive(['admin.industry-types.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.industry-types.index') }}">Ngành nghề</a></li>
                                <li class="{{ setSidebarActive(['admin.organization-types.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.organization-types.index') }}">Loại tổ chức</a></li>
                                <li class="{{ setSidebarActive(['admin.languages.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.languages.index') }}">Ngôn ngữ</a></li>
                                <li class="{{ setSidebarActive(['admin.professions.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.professions.index') }}">Chuyên môn</a></li>
                                <li class="{{ setSidebarActive(['admin.skills.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.skills.index') }}">Kỹ năng</a></li>
                                <li class="{{ setSidebarActive(['admin.educations.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.educations.index') }}">Trình độ học vấn</a></li>
                                <li class="{{ setSidebarActive(['admin.job-types.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.job-types.index') }}">Loại công việc</a></li>
                                <li class="{{ setSidebarActive(['admin.salary-types.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.salary-types.index') }}">Hình thức lương</a></li>
                                <li class="{{ setSidebarActive(['admin.tags.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.tags.index') }}">Thẻ</a></li>
                                <li class="{{ setSidebarActive(['admin.job-experiences.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.job-experiences.index') }}">Kinh nghiệm</a></li>
                            </ul>
                        </li>
            @endif

            @if (canAccess(['job locations']))
                <li class="dropdown {{ setSidebarActive(['admin.countries.*', 'admin.states.*', 'admin.cities.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-map"></i>
                        <span>Khu vực</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.countries.*']) }}"><a class="nav-link"
                                href="{{ route('admin.countries.index') }}">Quốc gia</a></li>
                        <li class="{{ setSidebarActive(['admin.states.*']) }}"><a class="nav-link"
                                href="{{ route('admin.states.index') }}">Tỉnh/Thành phố</a></li>
                        <li class="{{ setSidebarActive(['admin.cities.*']) }}"><a class="nav-link"
                                href="{{ route('admin.cities.index') }}">Thành phố</a></li>
                    </ul>
                </li>
            @endif

            @if (canAccess(['sections']))
                        <li class="dropdown {{ setSidebarActive([
                    'admin.hero.index',
                    'admin.why-choose-us.index',
                    'admin.learn-more.*',
                    'admin.counter.*',
                    'admin.job-location.*',
                    'admin.reviews.*',
                ]) }}">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-puzzle-piece"></i>
                                <span>Phần giao diện</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ setSidebarActive(['admin.hero.index']) }}"><a class="nav-link"
                                        href="{{ route('admin.hero.index') }}">Trang chính</a></li>
                                <li class="{{ setSidebarActive(['admin.why-choose-us.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.why-choose-us.index') }}">Lý do chọn chúng tôi</a></li>
                                <li class="{{ setSidebarActive(['admin.learn-more.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.learn-more.index') }}">Tìm hiểu thêm</a></li>
                                <li class="{{ setSidebarActive(['admin.counter.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.counter.index') }}">Bộ đếm</a></li>
                                <li class="{{ setSidebarActive(['admin.job-location.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.job-location.index') }}">Địa điểm việc làm</a></li>
                                <li class="{{ setSidebarActive(['admin.reviews.*']) }}"><a class="nav-link"
                                        href="{{ route('admin.reviews.index') }}">Đánh giá</a></li>
                            </ul>
                        </li>
            @endif

            @if (canAccess(['site pages']))
                <li class="dropdown {{ setSidebarActive(['admin.about-us.*', 'admin.page-builder.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file"></i>
                        <span>Trang nội dung</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.about-us.*']) }}"><a class="nav-link"
                                href="{{ route('admin.about-us.index') }}">Giới thiệu</a></li>
                        <li class="{{ setSidebarActive(['admin.page-builder.*']) }}"><a class="nav-link"
                                href="{{ route('admin.page-builder.index') }}">Trình tạo trang</a></li>
                    </ul>
                </li>
            @endif

            @if (canAccess(['site footer']))
                <li class="dropdown {{ setSidebarActive(['admin.footer.*', 'admin.social-icon.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shoe-prints"></i>
                        <span>Chân trang</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.footer.*']) }}"><a class="nav-link"
                                href="{{ route('admin.footer.index') }}">Chi tiết chân trang</a></li>
                        <li class="{{ setSidebarActive(['admin.social-icon.*']) }}"><a class="nav-link"
                                href="{{ route('admin.social-icon.index') }}">Biểu tượng mạng xã hội</a></li>
                    </ul>
                </li>
            @endif

            @if (canAccess(['blogs']))
                <li class="{{ setSidebarActive(['admin.blogs.*']) }}"><a class="nav-link"
                        href="{{ route('admin.blogs.index') }}"><i class="fab fa-blogger-b"></i> <span>Bài viết</span></a>
                </li>
            @endif

            @if (canAccess(['price plan']))
                <li class="{{ setSidebarActive(['admin.plans.*']) }}"><a class="nav-link"
                        href="{{ route('admin.plans.index') }}"><i class="fas fa-box"></i> <span>Gói giá</span></a></li>
            @endif

            @if (canAccess(['news letter']))
                <li class="{{ setSidebarActive(['admin.newsletter.*']) }}"><a class="nav-link"
                        href="{{ route('admin.newsletter.index') }}"><i class="fas fa-mail-bulk"></i>
                        <span>Bản tin</span></a></li>
            @endif

            @if (canAccess(['menu builder']))
                <li class="{{ setSidebarActive(['admin.menu-builder.*']) }}"><a class="nav-link"
                        href="{{ route('admin.menu-builder.index') }}"><i class="fas fa-shapes"></i> <span>Trình tạo
                            menu</span></a></li>
            @endif

            @if (canAccess(['access management']))
                <li class="dropdown {{ setSidebarActive(['admin.role-user.*', 'admin.role.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-shield"></i>
                        <span>Phân quyền</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.role-user.*']) }}"><a class="nav-link"
                                href="{{ route('admin.role-user.index') }}">Người dùng & Vai trò</a></li>
                        <li class="{{ setSidebarActive(['admin.role.*']) }}"><a class="nav-link"
                                href="{{ route('admin.role.index') }}">Vai trò</a></li>
                    </ul>
                </li>
            @endif

            @if (canAccess(['payment settings']))
                <li class="{{ setSidebarActive(['admin.payment-settings.index']) }}"><a class="nav-link"
                        href="{{ route('admin.payment-settings.index') }}"><i class="fas fa-wrench"></i> <span>Cài đặt thanh
                            toán</span></a></li>
            @endif

            @if (canAccess(['site settings']))
                <li class="{{ setSidebarActive(['admin.site-settings.index']) }}"><a class="nav-link"
                        href="{{ route('admin.site-settings.index') }}"><i class="fas fa-cog"></i> <span>Cài đặt trang
                            web</span></a></li>
            @endif

            @if (canAccess(['database clear']))
                <li class="{{ setSidebarActive(['admin.clear-database.index']) }}"><a class="nav-link"
                        href="{{ route('admin.clear-database.index') }}"><i class="fas fa-skull-crossbones"></i> <span>Xóa
                            dữ liệu hệ thống</span></a></li>
            @endif
        </ul>
    </aside>
</div>