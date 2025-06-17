@extends('layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">🍓 Danh sách hoa quả</h1>
    </div>

    <form method="GET" class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 px-4 max-w-4xl mx-auto">
        {{-- Lọc theo loại --}}
        <div>
            <label class="block mb-1 font-medium">Loại:</label>
            <select name="type" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">-- Tất cả --</option>
                <option value="apple" {{ request('type') == 'apple' ? 'selected' : '' }}>Táo</option>
                <option value="mango" {{ request('type') == 'mango' ? 'selected' : '' }}>Xoài</option>
                <option value="banana" {{ request('type') == 'banana' ? 'selected' : '' }}>Chuối</option>
            </select>
        </div>

        {{-- Lọc theo giá --}}
        <div>
            <label class="block mb-1 font-medium">Giá từ:</label>
            <input type="number" name="min_price" value="{{ request('min_price') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">đến:</label>
            <input type="number" name="max_price" value="{{ request('max_price') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        {{-- Các tùy chọn lọc đặc biệt --}}
        <div class="col-span-1 md:col-span-3 flex items-center space-x-4">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="sale" {{ request()->has('sale') ? 'checked' : '' }}
                class="rounded border-gray-300">
                <span>Giảm giá</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="premium" {{ request()->has('premium') ? 'checked' : '' }}
                class="rounded border-gray-300">
                <span>Cao cấp</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="organic" {{ request()->has('organic') ? 'checked' : '' }}
                class="rounded border-gray-300">
                <span>Hữu cơ</span>
            </label>

            <button type="submit"
                    class="ml-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                Lọc
            </button>
        </div>
    </form>

    <div class="flex flex-wrap gap-6 justify-center">
        @foreach ($fruits as $fruitHtml)
            {!! $fruitHtml !!}
        @endforeach
    </div>
@endsection
