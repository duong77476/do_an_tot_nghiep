<head>
    @include('frontend.head')
</head><!--/head-->

<body>
<header id="header"><!--header-->
    @include('frontend.header')
</header><!--/header-->

<section id="form"><!--form-->
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {!! session()->get('message') !!}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
        <div class="row">
            <div class="col-sm-9">
                <div class="login-form"><!--login form-->
                    <h2>Điền email khôi phục mật khẩu</h2>
                    <form action="{{route('request-pass')}}" method="post">
                        @csrf
                        <input type="text" name="email" placeholder="Nhập email..." />
                        <button type="submit" class="btn btn-default">Xác nhận</button>
                    </form>
                </div><!--/login form-->
            </div>
        </div>
    </div>
</section><!--/form-->

<footer id="footer"><!--Footer-->
    @include('frontend.footer')
</footer><!--/Footer-->



</body>
