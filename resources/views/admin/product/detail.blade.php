@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <a href="{{ route('productList') }}" class="btn bg-dark text-white rounded shadow-sm mb-3"><i
                class="fa-solid fa-arrow-left"></i> Back</a>

        <div class="row">
            <div class="col-6 offset-3">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex align-items-center">
                            <img src="{{ asset('productImage/' . $product->image) }}"
                                class="img-fluid rounded-start w-100 h-auto" style="object-fit: cover; height: 100%;"
                                alt="{{ $product->name }}">
                        </div>

                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="card-title">{{ $product->name }}</h4>
                                <p>Category : {{ $product->category_name }}</p>
                                <p>Stock : {{ $product->stock }}</p>
                                <p class="card-text">Price : {{ $product->price }} mmk</p>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text"><small class="text-body-secondary">Last updated :
                                        {{ $product->updated_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
