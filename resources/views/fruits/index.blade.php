@extends('layouts.app')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-green-700">🍓 Danh sách Hoa Quả</h1>
    </div>

    {{-- Nhóm Giảm Giá --}}
    <section class="mb-12 px-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-red-600">🔥 Giảm giá</h2>
            <a href="{{ route('fruits.category', 'sale') }}" class="text-sm text-blue-500 hover:underline">Xem tất cả</a>
        </div>
        <div class="flex flex-wrap gap-6 justify-center">
            @forelse ($saleFruits as $fruit)
                @include('fruits.partials.card', ['fruit' => $fruit])
            @empty
                <p>Không có sản phẩm nào.</p>
            @endforelse
        </div>
    </section>

    {{-- Nhóm Cao Cấp --}}
    <section class="mb-12 px-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-yellow-600">🌟 Cao cấp</h2>
            <a href="{{ route('fruits.category', 'premium') }}" class="text-sm text-blue-500 hover:underline">Xem tất cả</a>
        </div>
        <div class="flex flex-wrap gap-6 justify-center">
            @forelse ($premiumFruits as $fruit)
                @include('fruits.partials.card', ['fruit' => $fruit])
            @empty
                <p>Không có sản phẩm nào.</p>
            @endforelse
        </div>
    </section>

    {{-- Nhóm Hữu Cơ --}}
    <section class="mb-12 px-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-green-700">🍀 Hữu cơ</h2>
            <a href="{{ route('fruits.category', 'organic') }}" class="text-sm text-blue-500 hover:underline">Xem tất cả</a>
        </div>
        <div class="flex flex-wrap gap-6 justify-center">
            @forelse ($organicFruits as $fruit)
                @include('fruits.partials.card', ['fruit' => $fruit])
            @empty
                <p>Không có sản phẩm nào.</p>
            @endforelse
        </div>
    </section>
@endsection
