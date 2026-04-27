@extends('admin.layouts.master')

@section('content')
    <a href="{{ route('paymentList') }}" class="btn bg-dark text-white rounded shadow-sm mb-3"><i class="fa-solid fa-arrow-left"></i> Back</a>

    <div class="">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('paymentUpdate',$payment->id) }}" method="post" class="p-3 rounded">
                                @csrf
                                <input type="text" name="accountType" value="{{ old('accountType',$payment->type) }}" class=" form-control mb-3 @error('accountType') is-invalid @enderror"
                                    placeholder="Account Type...">
                                @error('accountType')
                                   <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="text" name="accountName" value="{{ old('accountName',$payment->account_name) }}" class=" form-control mb-3 @error('accountName') is-invalid @enderror"
                                    placeholder="Account Name...">
                                @error('accountName')
                                   <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="text" name="accountNumber" value="{{ old('accountNumber',$payment->account_number) }}" class=" form-control @error('accountNumber') is-invalid @enderror"
                                    placeholder="Account Number...">
                                @error('accountNumber')
                                   <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
