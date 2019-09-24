        @if (auth('customers')->check())
        <footer>
            <div class="container">
                <div class="row">
                    <ul>
                        <a href="{{ route('mobile.home') }}">
                            <li>
                                <i style="@if(Request::is('mobile/trang-chu'))@php echo 'color: #fff;';@endphp@endif" class="fas fa-home"></i>
                                <p style="@if(Request::is('mobile/trang-chu'))@php echo 'color: #fff;';@endphp@endif">Home</p>
                            </li>
                        </a>
                        <a href="{{ route('mobile.history') }}">
                            <li>
                                <i style="@if(Request::is('mobile/lich-su'))@php echo 'color: #fff;';@endphp@endif" class="fas fa-history"></i>
                                <p style="@if(Request::is('mobile/lich-su'))@php echo 'color: #fff;';@endphp@endif">
                                    Lịch sử
                                </p>
                            </li>
                        </a>
                        <a href="{{ route('mobile.card') }}">
                            <li>
                                <i style="@if(Request::is('mobile/the'))@php echo 'color: #fff;';@endphp@endif" class="far fa-credit-card"></i>
                                <p style="@if(Request::is('mobile/the'))@php echo 'color: #fff;';@endphp@endif">
                                    Thẻ 
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
