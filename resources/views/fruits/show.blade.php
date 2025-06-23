@extends('layouts.app')

@section('content')
@php
    use App\DesignPatterns\Decorator\BasicFruitDisplay;
    use App\DesignPatterns\Decorator\SaleBadgeDecorator;
    use App\DesignPatterns\Decorator\OrganicFruitDecorator;

    $display = new BasicFruitDisplay($fruit);
    $display = new SaleBadgeDecorator($display);
    $display = new OrganicFruitDecorator($display);
@endphp
<div class="container mt-5">
    <div class="row">
        <div class="col-md-5">
            <img src="{{ $fruit->image ? asset('images/fruits/'.$fruit->image) : asset('images/fruits/'.$fruit->image) }}" alt="{{ $fruit->name }}" class="img-fluid rounded" style="max-height:350px;">
        </div>
        <div class="col-md-7">
            {!! $display->render() !!}
            <form action="{{ route('cart.add', $fruit->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg mt-2 add-to-cart-btn" @if($fruit->stock < 1) disabled @endif>
                    @if($fruit->stock < 1) Hết hàng @else Thêm vào giỏ @endif
                </button>
            </form>
            <a href="{{ url()->previous() }}" class="btn btn-link mt-3">&laquo; Quay lại</a>
        </div>
    </div>
</div>
@endsection
