@foreach ($employee as $stylist)
    <div class="col-lg-2" style="padding: 0px">
        <input style="display: none;" class="radio-stylist1" id="stylist{{ $stylist->id }}" type="checkbox" value="{{ $stylist->id }}" name="stylist[]">
        <img onclick="optionStylist({{ $stylist->id }})" class="thumnail-stylist avatar-stylist{{ $stylist->id }}" src="{{ asset('/image/default.png') }}" width="100%" style="border-radius: 100px; padding: 5px; border: 4px solid #727272">
    </div>
    <div class="col-lg-10">
        <p>
            {{ mb_strtoupper($stylist->full_name, 'UTF-8') }}
        </p>
    </div>
@endforeach