
@foreach ($employee as $stylist)
<div class="row" style="width: 100%; padding: 10px 10px; border-bottom: 1px solid #f3f2f2;">
    <div class="col-2 col-lg-2" style="padding: 0px">
        <input style="display: none;" class="radio-skinner" id="skinner{{ $stylist->id }}" type="checkbox" value="{{ $stylist->id }}" name="stylist[]">
        <img onclick="optionSkinner({{ $stylist->id }})" class="avatar-skinner avatar-skinner{{ $stylist->id }}" src="@if ($stylist->image != '') {{ asset('/upload/images/employee/' . $stylist->image) }} @else {{ asset('/image/item1.png') }} @endif" width="100%" style="border-radius: 100px">
    </div>
    <div class="col-10 col-lg-10">
        <p style="margin-top: 15px; margin-bottom: 0px; font-weight: bold;">
            {{ mb_strtoupper($stylist->full_name, 'UTF-8') }}
        </p>
    </div>
</div>
@endforeach