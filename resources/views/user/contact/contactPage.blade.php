@extends('user.layouts.master')

@section('content')
    <div class="" style="margin-top: 150px">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('userContactCreate') }}" method="post" class="p-3 rounded">
                            @csrf
                            <input type="text" name="name" value="{{ Auth::user()->name ?? Auth::user()->nickname }}"
                                class="mb-3 form-control" disabled>

                            <input type="text" name="title" value="{{ old('title') }}"
                                class="mb-3 form-control @error('title') is-invalid @enderror" placeholder="Title...">
                            @error('title')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror


                            <textarea name="message" cols="30" rows="10" placeholder="Message..." class="mb-3 form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                            <div class=" d-flex justify-content-center">
                                <input type="submit" value="Send" class="btn btn-primary w-25">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
