        @if (auth('employees')->check())
        <footer>
            <div class="container">
                <div class="row">
                    <ul>
                        <a href="{{ route('mobile.employee.home') }}">
                            <li>
                                <i style="@if(Request::is('mobile/nhan-vien/trang-chu'))@php echo 'color: #fff;';@endphp@endif" class="fas fa-home"></i>
                                <p style="@if(Request::is('mobile/nhan-vien/trang-chu'))@php echo 'color: #fff;';@endphp@endif">
                                	Khách yêu cầu
                                </p>
                            </li>
                        </a>
                        <a href="{{ route('mobile.employee.history') }}">
                            <li>
                                <i style="@if(Request::is('mobile/nhan-vien/lich-su'))@php echo 'color: #fff;';@endphp@endif" class="fas fa-history"></i>
                                <p style="@if(Request::is('mobile/nhan-vien/lich-su'))@php echo 'color: #fff;';@endphp@endif">
                                    Lịch sử
                                </p>
                            </li>
                        </a>
                        <a href="mobile/nhan-vien/thu-nhap?today={{ date('Y-m-d') }}">
                            <li>
                                <i style="@if(Request::is('mobile/nhan-vien/thu-nhap'))@php echo 'color: #fff;';@endphp@endif" class="fas fa-dollar-sign"></i>
                                <p style="@if(Request::is('mobile/nhan-vien/thu-nhap'))@php echo 'color: #fff;';@endphp@endif">
                                    Thu nhập
                                </p>
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </footer>
        @endif
    </body>
</html>
