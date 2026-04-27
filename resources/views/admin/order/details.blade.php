@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <a href="{{ route('adminOrderList') }}" class="btn bg-dark text-white rounded shadow-sm mb-3"><i
                class="fa-solid fa-arrow-left"></i> Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Name :</div>
                        <div class="col-7">{{ $order[0]->user_name ?? $order[0]->nickname }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Phone :</div>
                        <div class="col-7">{{ $order[0]->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Addr :</div>
                        <div class="col-7">{{ $paymentHistory->address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code :</div>
                        <div class="col-7" id="orderCode">{{ $order[0]->order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7">{{ $order[0]->created_at }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7">
                            {{ $paymentHistory->total_amt }} mmk<br>
                            <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h6 class="m-0 font-weight-bold text-primary">Payment Information</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone :</div>
                        <div class="col-7">{{ $paymentHistory->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7">{{ $paymentHistory->type }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $paymentHistory->created_at }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{ asset('payslipImage/'. $paymentHistory->payslip_image) }}" class=" img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
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
                                <th class="bg-primary text-white">Order Count</th>
                                <th class="bg-primary text-white">Available Stock</th>
                                <th class="bg-primary text-white">Product Price (each)</th>
                                <th class="bg-primary text-white">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ( $order as $item )
                                <tr>
                                    <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                    <input type="hidden" class="productOrderCount" value="{{ $item->count }}">

                                    <td>
                                        <img src="{{ asset('productImage/'. $item->image) }}" class=" w-50 img-thumbnail">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->count }} @if( ($item->count > $item->stock) && $item->status != 1 ) <small class="text-danger">( out of stock )</small> @endif</td>
                                    <td>{{  $item->stock }}</td>
                                    <td>{{ $item->price }} mmk</td>
                                    <td>{{ $item->count * $item->price}} mmk</td>
                                </tr>
                            @endforeach


                        </tbody>

                    </table>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="">
                    @if( $status && $item->status != 1 )
                        <input type="button" id="btn-order-confirm" class="btn btn-success rounded shadow-sm" value="Confirm">
                    @endif
                    <input type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm" value="Reject">
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            $('#btn-order-reject').click(function() {
                orderCode = $('#orderCode').text();

                $.ajax({
                    type : 'get',
                    url : '/admin/order/reject',
                    data : { 'orderCode' : orderCode },
                    dataType : 'json',
                    success : function(res) {
                        res.status == 'success' ? location.href = '/admin/order/list' : loaction.reload();
                    }
                })
            })

            $('#btn-order-confirm').click(function() {
                orderCode = $('#orderCode').text();
                orderList = [];

                $('.table-responsive tbody tr').each(function(index, row) {
                    productId = $(row).find('.productId').val();
                    count = $(row).find('.productOrderCount').val();

                    orderList.push({
                        'orderCode' : orderCode,
                        'productId' : productId,
                        'count' : count
                    });
                })

                $.ajax({
                    type : 'get',
                    url : '/admin/order/confirm',
                    data : Object.assign({}, orderList),
                    dataType : 'json',
                    success : function(res) {
                        res.status == 'success' ? location.href = '/admin/order/list' : location.reload();
                    }
                })


            })

        })
    </script>
@endsection
