@php $stt = 0; @endphp
@foreach ($customer as $customer)
    @foreach ($customer->bill as $bill)
        @if ($bill->order->date == $date)
        <tr style="cursor: pointer;" value="{{ $bill->id }}" class="list-bill" id="bill{{ $bill->id }}"> 
            <script type="text/javascript">
                $(document).ready(function(){
                    $('.list-bill').click(function() {
                        $('.list-bill').removeClass('active');
                        $(this).addClass('active');
                        var billId = $(this).attr('value');
                        if (billId != '') {
                            $.get('admin/hoa-don/chi-tiet/' + billId, function(data){
                              $('.right').html(data);
                          });
                        }
                      });
                })
            </script>       
            <td>{{ ++$stt }}</td>  
            <td>
                {{ $bill->customer->phone }}
            </td>
            <td>
                {{ 
                    ($bill->customer->full_name == '') ? 'Chưa điền thông tin' : $bill->customer->full_name 
                }}
            </td>              
            <td>
                {{ $bill->order->employee->full_name }}
            </td>
            <td>
                @if ($bill->status == config('config.order.status.check-in'))
                    <span style="color: red">Chưa thanh toán</span>
                @else
                    <span style="color: green">Đã thanh toán</span>
                @endif
            </td>
        </tr>
        @endif
    @endforeach
@endforeach
 
