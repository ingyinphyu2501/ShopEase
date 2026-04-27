@extends('admin.layouts.master')

@section('content')
    <a href="{{ route('productList') }}" class="btn bg-dark text-white rounded shadow-sm mb-3"><i class="fa-solid fa-arrow-left"></i> Back</a>

    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 card p-3 shadow-sm rounded">
                <form action="{{ route('productUpdate') }}" method="post" enctype="multipart/form-data">

                    @csrf
                    <input type="hidden" name="oldPhoto" value="{{ $product->image }}">
                    <input type="hidden" name="productId" value="{{ $product->id }}">

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-center">
                                <img class="img-profile mb-1 w-25 rounded" id="output" src="">
                            </div>
                            <input type="file" name="image" id="" accept="image/*" class="form-control mt-1 @error('image') is-invalid @enderror" onchange="loadFile(event)">
                            @error('image')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name',$product->name) }}" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Name...">
                                        @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="categoryId" id="" class="form-control @error('categoryId') is-invalid @enderror">
                                        <option value="">Choose Category...</option>
                                        @foreach ( $categories as $item )
                                            <option value="{{ $item->id }}" @if( $item->id == $product->category_id ) selected @endif>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categoryId')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="text" name="price" value="{{ old('price',$product->price) }}" class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Enter Price...">
                                        @error('price')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="text" name="stock" value="{{ old('stock',$product->stock) }}" class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter Stock...">
                                        @error('stock')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter Description...">{{ old('description',$product->description) }}</textarea>
                                @error('description')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Update Product" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection
