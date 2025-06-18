<div class="bg-white rounded-2xl shadow p-4 text-center w-[220px] relative @if($fruit->is_premium) border-2 border-yellow-500 @endif">
    {{-- Giảm giá badge --}}
    @if ($fruit->is_on_sale)
        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">Giảm giá</span>
    @endif

    {{-- Hình ảnh --}}
    <img src="{{ $fruit->image_url ?? '/images/default-fruit.jpg' }}" alt="{{ $fruit->name }}"
         class="w-full h-32 object-contain mb-4">

    {{-- Tên --}}
    <h3 class="font-semibold text-lg">{{ $fruit->name }}</h3>

    {{-- Giá --}}
    @if ($fruit->is_on_sale && $fruit->original_price)
        <div class="text-gray-500 line-through text-sm">{{ number_format($fruit->original_price, 0, ',', '.') }} ₫</div>
    @endif
    <div class="text-green-700 font-bold text-lg">{{ number_format($fruit->price, 0, ',', '.') }} ₫</div>

    {{-- Label hữu cơ --}}
    @if ($fruit->is_organic)
        <div class="mt-2 text-sm text-green-600 font-medium">Hữu cơ</div>
    @endif
</div>
