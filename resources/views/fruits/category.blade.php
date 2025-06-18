@extends('layouts.app')

@section('content')
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-green-800">
            {{ $type === 'sale' ? '🔥 Giảm giá' : ($type === 'premium' ? '🌟 Cao cấp' : '🍀 Hữu cơ') }}
        </h1>
    </div>

    <div class="flex flex-wrap gap-6 justify-center px-4">
        @forelse ($fruits as $fruit)
            @include('fruits.partials.card', ['fruit' => $fruit])
        @empty
            <p>Không có sản phẩm nào trong nhóm này.</p>
        @endforelse
    </div>

    <div class="mt-6 flex justify-center">
        {{ $fruits->links() }}
    </div>
@endsection
