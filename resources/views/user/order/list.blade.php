@extends('user.layouts.master')

@section('content')
    <div class="container vh-100" style="margin-top: 150px">
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ( $orderList as $item )
                       <tr>
                            <td>{{ $item->created_at->format('j-F-Y') }}</td>
                            <td>{{ $item->order_code }}</td>
                            <td>
                                @if ( $item->status == 0 )
                                    <i class="fa-solid fa-spinner btn btn-sm btn-warning rounded shadow-sm me-3"></i><span class="text-warning">Pending</span>
                                @elseif ( $item->status == 1 )
                                    <i class="fa-solid fa-check btn btn-sm btn-success rounded shadow-sm me-3"></i><span class="text-success">Accept</span>
                                @else
                                    <i class="fa-solid fa-xmark btn btn-sm btn-danger rounded shadow-sm me-3"></i><span class="text-danger">Reject</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
