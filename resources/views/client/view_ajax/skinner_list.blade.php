@foreach ($employee as $stylist)
<div class="row" style="width: 100%; padding: 10px 10px; border-bottom: 1px solid #e5e5e5;">
    <div class="col-lg-2" style="padding: 0px">
        <input style="display: none;" class="radio-skinner" id="skinner{{ $stylist->id }}" type="checkbox" value="{{ $stylist->id }}" name="stylist[]">
        <img onclick="optionSkinner({{ $stylist->id }})" class="avatar-skinner avatar-skinner{{ $stylist->id }}" src="{{ asset('/image/default.png') }}" width="100%" style="border-radius: 100px; padding: 5px; border: 4px solid #727272">
    </div>
    <div class="col-lg-10">
        <p style="margin-top: 15px; margin-bottom: 0px; font-weight: bold;">
            {{ mb_strtoupper($stylist->full_name, 'UTF-8') }}
        </p>
    </div>
</div>
@endforeach