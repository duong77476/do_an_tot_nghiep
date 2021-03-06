<?php
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin')}}" class="brand-link">
        <img src="{{asset('public/backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">BC PHONE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('public/backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{$admin}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                @hasRole(['Admin'])
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Qu???n l?? h??? th???ng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('view-admin-users')}}" class="nav-link">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Ng?????i d??ng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasRole

                @hasRole(['Admin','Qu???n l?? b??n h??ng','Qu???n l?? kho'])
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh m???c
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-header">Kho v???n</li>
                        <li class="nav-item">
                            <a href="{{route('all-nha-cung-cap')}}" class="nav-link">
                                <i class="fa fa-address-book nav-icon"></i>
                                <p>Nh?? cung c???p</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('fee-ship')}}" class="nav-link">
                                <i class="fa fa-money-bill-alt nav-icon"></i>
                                <p>Ph?? v???n chuy???n</p>
                            </a>
                        </li>
                        <li class="nav-header">S???n ph???m</li>
                        <li class="nav-item">
                            <a href="{{route('all-nganh-hang')}}" class="nav-link">
                                <i class="fa fa-tag nav-icon"></i>
                                <p>Ng??nh h??ng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-category')}}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Lo???i ph??n lo???i</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-category-product')}}" class="nav-link">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>Ph??n lo???i s???n ph???m</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-brand')}}" class="nav-link">
                                <i class="fas fa-apple-alt nav-icon"></i>
                                <p>Th????ng hi???u s???n ph???m</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-product')}}" class="nav-link">
                                <i class="fas fa-mobile-alt nav-icon"></i>
                                <p>S???n ph???m</p>
                            </a>
                        </li>
                        <li class="nav-header">Asset</li>
                        <li class="nav-item">
                            <a href="{{route('all-slider')}}" class="nav-link">
                                <i class="fas fa-image nav-icon"></i>
                                <p>Slider-Banner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-video')}}" class="nav-link">
                                <i class="fas fa-video nav-icon"></i>
                                <p>Video</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-coupon')}}" class="nav-link">
                                <i class="fas fa-gift nav-icon"></i>
                                <p>M?? gi???m gi??</p>
                            </a>
                        </li>
                        <li class="nav-header">Kh??ch h??ng</li>
                        <li class="nav-item">
                            <a href="{{route('all-customer')}}" class="nav-link">
                                <i class="fas fa-comment nav-icon"></i>
                                <p>Kh??ch h??ng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-comment')}}" class="nav-link">
                                <i class="fas fa-comment nav-icon"></i>
                                <p>B??nh lu???n</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-rating')}}" class="nav-link">
                                <i class="fas fa-star nav-icon"></i>
                                <p>????nh gi?? s???n ph???m</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasRole

                @hasRole(['Admin','Qu???n l?? b??n h??ng'])
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Qu???n l?? b??n h??ng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('all-customer-order')}}" class="nav-link">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>????n h??ng</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasRole

                @hasRole(['Admin','Qu???n l?? kho'])
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fa fa-barcode"></i>
                        <p>
                            Qu???n l?? kho
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('all-phieu-nhap')}}" class="nav-link">
                                <i class="fa fa-file nav-icon"></i>
                                <p>Phi???u nh???p</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-phieu-xuat')}}" class="nav-link">
                                <i class="fa fa-file-alt nav-icon"></i>
                                <p>Phi???u xu???t</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-ton-kho')}}" class="nav-link">
                                <i class="fa fa-store-alt-slash nav-icon"></i>
                                <p>T???n kho</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasRole

                @hasRole(['Admin','Qu???n l?? c??ng n???'])
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fa fa-money-check"></i>
                        <p>
                            Qu???n l?? c??ng n???
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('all-cong-no-ncc')}}" class="nav-link">
                                <i class="fa fa-money-bill-wave nav-icon"></i>
                                <p>C??ng n??? nh?? cung c???p</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-thanh-toan-cong-no')}}" class="nav-link">
                                <i class="fa fa-money-bill nav-icon"></i>
                                <p>Thanh to??n c??ng n???</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasRole

                @hasRole(['Admin','B??o c??o th???ng k??','Qu???n l?? b??n h??ng','Qu???n l?? c??ng n???','Qu???n l?? kho'])
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fa fa-newspaper"></i>
                        <p>
                            B??o c??o th???ng k??
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('statistic-order')}}" class="nav-link">
                                <i class="fa fa-book nav-icon"></i>
                                <p>Th???ng k?? ????n h??ng, doanh s???</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('statistic-product-post')}}" class="nav-link">
                                <i class="fa fa-book-open nav-icon"></i>
                                <p>Th???ng k?? s???n ph???m, b??i vi???t</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('statistic-xuat-nhap-ton')}}" class="nav-link">
                                <i class="fa fa-book-reader nav-icon"></i>
                                <p>Th???ng k?? xu???t nh???p t???n</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasRole

                @hasRole(['Admin','Qu???n l?? marketing'])
                <li class="nav-header">Marketing</li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-choose">
                        <i class="nav-icon fa fa-newspaper"></i>
                        <p>
                            Qu???n l?? b??i vi???t
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('all-post-type')}}" class="nav-link">
                                <i class="fa fa-book nav-icon"></i>
                                <p>Danh m???c b??i vi???t</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('all-post')}}" class="nav-link">
                                <i class="fa fa-book-open nav-icon"></i>
                                <p>B??i vi???t</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('sendportal.dashboard')}}" class="nav-link">
                        <i class="nav-icon fa fa-mail-bulk"></i>
                        <p>
                            Email Marketing
                        </p>
                    </a>
                </li>
                @endhasRole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

@section('pagescript')
    {{--Script ????? m?? khi click v??o m???t m???c ??? sidebar--}}
    <script type="text/javascript">
        $(document).ready(function (){
            $('.nav-choose').click(function (){
                var menu_open = $(this).closest("li").attr("class");
                if(menu_open==="nav-item")
                    $(this).addClass('active');
                else{
                    $(this).removeClass('active');
                }
            })
            $(document).on('blur','.nav-choose',function (){
                $(this).removeClass('active');
            })

        })
    </script>
@endsection
