@props(['status'])

@php
    $status = (int) $status;
@endphp

@if($status === 1)
    <span class="badge light badge-success">
        <i class="fa fa-check text-success me-1"></i>
        Onaylandı
    </span>
@elseif($status === 2)
    <span class="badge light badge-warning">
        <i class="fa fa-circle text-warning me-1"></i>
        Onay Bekliyor
    </span>
@elseif($status === 3)
    <span class="badge light badge-danger">
        <i class="fa fa-ban text-danger me-1"></i>
        Reddedildi
    </span>
@else
    <span class="badge light badge-secondary">
        Bilinmiyor
    </span>
@endif
