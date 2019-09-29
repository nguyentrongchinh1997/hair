    </body>
    <!-- thư hiện lightpick -->
    

    <!-- end -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/admin/admin.js') }}"></script>

<!-- select-search -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-vi_VN.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<!-- end -->
    <script src="{{ asset('/js/bootstrap/js/bootstrap.min.js') }}"></script>
    @if(Request::is('admin/chi-tieu/danh-sach'))
    <script async src="{{ asset('/js/datepicker/js/button.js') }}"></script>
    <script src="{{ asset('/js/datepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('/js/datepicker/js/lightpick.js') }}"></script>
    <script type="text/javascript">
    	/*Lightpick*/
			$(function(){
			    var picker = new Lightpick({
			        field: document.getElementById('demo-2'),
			        singleDate: false,
			        onSelect: function(start, end){
			            var str = '';
			            str += start ? start.format('Do MMMM YYYY') + ' to ' : '';
			            str += end ? end.format('Do MMMM YYYY') : '...';
			            // document.getElementById('result-2').innerHTML = str;
			        }
			    }); 
			})

			/*end*/
    </script>
    @endif

</html>