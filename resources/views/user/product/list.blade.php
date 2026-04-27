@extends('user.layouts.master')

@section('content')
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Our Products</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill @if(!request('categoryId')) active @endif" href="{{ url('user/home') }}">
                                    <span class="text-dark" style="width: 130px;">All Products</span>
                                </a>
                            </li>

                            @foreach ($categories as $item)
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill @if(request('categoryId') == $item->id) active @endif" href="{{ url('user/home?categoryId='. $item->id) }}">
                                        <span class="text-dark" style="width: 130px;">{{ $item->name }}</span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-3">
                                <div class="form">
                                    <form action="{{ route('userHome') }}" method="get">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                                                placeholder="Enter Search Key...">
                                            <button type="submit" class=" btn"> <i
                                                    class="fa-solid fa-magnifying-glass"></i> </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <form action="{{ route('userHome') }}" method="get">
                                            @csrf
                                            <input type="text" name="minPrice" value="{{ request('minPrice') }}"
                                                placeholder="Minimum Price..." class=" form-control my-2">
                                            <input type="text" name="maxPrice" value="{{ request('maxPrice') }}"
                                                placeholder="Maximun Price..." class=" form-control my-2">
                                            <input type="submit" value="Search" class=" btn btn-success my-2 w-100">
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form action="{{ route('userHome') }}" method="get">
                                            @csrf
                                            <select name="sortingType" class="form-control w-100 bg-white mt-3">
                                                <option value="name,asc">Alpha : A - Z</option>
                                                <option value="name,desc">Alpha : Z - A</option>
                                                <option value="price,desc">Price : High - Low</option>
                                                <option value="price,asc">Price : Low - High</option>
                                                <option value="created_at,desc">Date : Latest</option>
                                            </select>

                                            <input type="submit" value="Sort" class=" btn btn-success my-3 w-100">
                                        </form>
                                    </div>
                                </div>

                                <a href="{{ route('userHome') }}" class="btn btn-danger my-3 w-100">Clear</a>

                            </div>
                            <div class="col-9">
                                <div class="row g-4">

                                    @if (count($products) != 0)
                                        @foreach ($products as $item)
                                            <div class="col-4">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <a href="{{ route('userProductDetails', $item->id) }}"><img
                                                                src="{{ asset('productImage/' . $item->image) }}"
                                                                style="height: 250px" class="img-fluid w-100 rounded-top"
                                                                alt=""></a>
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                        style="top: 10px; left: 10px;">{{ $item->category_name }}</div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4>{{ $item->name }}</h4>
                                                        <p>{{ Str::words($item->description, 10) }}</p>
                                                        <div class="d-flex justify-content-center flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">{{ $item->price }} mmk
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h3 class="text-muted text-center m-5">There is no product...</h3>
                                    @endif



                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
