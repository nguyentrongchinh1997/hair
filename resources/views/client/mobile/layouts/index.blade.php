		@include('client.mobile.layouts.header')
		@yield('content')
		@include('client.mobile.layouts.footer')
			<!-- Swiper JS -->
  <script src="{{ asset('/swiper/js/swiper.min.js') }}"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
      scrollbar: {
        el: '.swiper-scrollbar',
        hide: true,
      },
    });
  </script>
	</body>

</html>
