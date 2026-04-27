@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Sale Information</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm " id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2 bg-primary text-white">Image</th>
                                <th class="bg-primary text-white">Name</th>
                                <th class="bg-primary text-white">Price</th>
                                <th class="bg-primary text-white">Order Count</th>
                                <th class="bg-primary text-white">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($saleInformation as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('productImage/' . $item->image) }}" class=" w-50 img-thumbnail">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }} mmk</td>
                                    <td>{{ $item->total_count }}</td>
                                    <td>{{ $item->price * $item->total_count }} mmk</td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection
