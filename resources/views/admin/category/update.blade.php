@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('categoryList') }}" class="btn bg-dark text-white rounded shadow-sm mb-3"><i class="fa-solid fa-arrow-left"></i> Back</a>

    <div class="">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('categoryUpdate',$category->id) }}" method="post" class="p-3 rounded">
                            @csrf
                            <input type="text" name="categoryName" value="{{ old('categoryName',$category->name) }}"
                                class=" form-control @error('categoryName') is-invalid @enderror"
                                placeholder="Category Name...">
                            @error('categoryName')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                            <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
