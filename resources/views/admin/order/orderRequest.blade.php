@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Order Requests</h1>
        </div>
        <a href="{{ route('adminDashboard') }}" class="btn bg-dark text-white rounded shadow-sm mb-3"><i class="fa-solid fa-arrow-left"></i> Back</a>

        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="{{ route('adminOrderRequest') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="bg-primary text-white">Date</th>
                        <th class="bg-primary text-white">Order Code</th>
                        <th class="bg-primary text-white">Customer Name</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orderRequest as $item)
                        <tr>
                            <td>{{ $item->created_at->format('j-F-Y') }}</td>
                            <td>{{ $item->order_code }}</td>
                            <td>{{ $item->name }}</td>


                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
