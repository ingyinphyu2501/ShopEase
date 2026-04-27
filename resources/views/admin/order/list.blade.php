@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="{{ route('adminOrderList') }}" method="get">
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
            <div class="col-6">

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fa-solid fa-triangle-exclamation me-3"></i></strong> You can click order code to see order details.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            </div>
        </div>
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="bg-primary text-white">Date</th>
                        <th class="bg-primary text-white">Order Code</th>
                        <th class="bg-primary text-white">Customer Name</th>
                        <th class="bg-primary text-white">Order Status</th>
                        <th class="bg-primary text-white"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orderList as $item)
                        <tr>
                            <td>{{ $item->created_at->format('j-F-Y') }}</td>
                            <td><a href="{{ route('adminOrderDetails', $item->order_code) }}" class="orderCode">{{ $item->order_code }}</a></td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <select name="orderStatus" id="" class="form-select orderStatus">
                                    <option value="0" @if ($item->status == 0) selected @endif>Pending</option>
                                    <option value="1" @if ($item->status == 1) selected @endif>Accept</option>
                                    <option value="2" @if ($item->status == 2) selected @endif>Reject</option>
                                </select>

                            </td>
                            <td>
                                @if ($item->status == 0)
                                    <i class="fa-solid fa-spinner text-warning"></i>
                                @elseif ($item->status == 1)
                                    <i class="fa-solid fa-check text-success"></i>
                                @else
                                    <i class="fa-solid fa-xmark text-danger"></i>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            $('.orderStatus').change(function() {
                status = $(this).val();
                orderCode = $(this).parents('tr').find('.orderCode').text();

                $.ajax({
                    type : 'get',
                    url : '/admin/order/status/change',
                    data : { 'status' : status, 'orderCode' : orderCode },
                    dataType : 'json',
                    success : function(res) {
                        res.status == 'success' ? location.reload() : '';
                    }
                })
            })
        })
    </script>
@endsection
