@php $stt = 0; @endphp

@foreach ($orderList as $order)
    @foreach ($order->order as $o)
        
        <tr style="cursor: pointer;" value="{{ $o->id }}" class="list-order" id="order{{ $o->id }}">
            <script type="text/javascript">
                $(document).ready(function(){
                    $('.list-order').click(function() {
                        $('.list-order').removeClass('active');
                        $(this).addClass('active');
                        var orderId = $(this).attr('value');
                        $.get('admin/dat-lich/chi-tiet/' + orderId, function(data){
                          $('.right').html(data);
                        });
                    });
                })
                    
            </script>
            <td>
                {{ ++$stt }}
            </td>
            
            <td>
                {{ $o->customer->phone }}
            </td>
            <td style="font-weight: bold;">
                {{ 
                    ($o->customer->full_name == '') ? 'Chưa điền thông tin' : $o->customer->full_name 
                }}
            </td>
            <td>
                {{ $o->time->time }}
            </td>
        </tr>
    @endforeach
@endforeach



