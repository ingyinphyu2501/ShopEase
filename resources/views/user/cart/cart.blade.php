@extends('user.layouts.master')

@section('content')
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($carts as $item)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('productImage/' . $item->image) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                            alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->name }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 price">{{ $item->price }} mmk</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control qty form-control-sm text-center border-0"
                                            value="{{ $item->qty }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total">{{ $item->price * $item->qty }} mmk</p>
                                </td>
                                <td>
                                    <input type="hidden" class="cartId" value="{{ $item->id }}">
                                    <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                    <input type="hidden" class="userId" value="{{ Auth::user()->id }}">
                                    <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0" id="subtotal">{{ $subTotal }} mmk</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Delivery </h5>
                                <div class="">
                                    <p class="mb-0"> 5000 mmk </p>
                                </div>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4 " id="finalTotal">{{ $subTotal + 5000 }} mmk</p>
                        </div>
                        <button id="btn-checkout"
                            class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" @if(count($carts) == 0) disabled @endif
                            type="button">Proceed Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            $('.btn-minus').click(function() {
                qtyCalculation(this);
                finalTotalCalculation();
            });

            $('.btn-plus').click(function() {
                qtyCalculation(this);
                finalTotalCalculation();
            });

            function qtyCalculation(event) {
                parentNode = $(event).parents('tr');
                price = parentNode.find('.price').text().replace('mmk', '');
                qty = parentNode.find('.qty').val();

                parentNode.find('.total').html(`${ price * qty } mmk`);
            }

            function finalTotalCalculation() {
                subTotal = 0;

                $('#productTable tbody tr').each(function(index, item) {
                    subTotal += Number($(item).find('.total').text().replace('mmk', ''));
                });

                $('#subtotal').html(`${subTotal} mmk`);
                $('#finalTotal').html(`${subTotal+5000} mmk`);
            }

            $('.btn-remove').click(function() {
                parentNode = $(this).parents('tr');
                cartId = parentNode.find('.cartId').val();

                deleteData = {
                    'cartId': cartId
                };

                $.ajax({
                    type: 'get',
                    url: '/user/cart/delete',
                    data: deleteData,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : '';
                    }
                });

            })

            $('#btn-checkout').click(function() {
                orderList = [];
                userId = $('.userId').val();
                orderCode = 'CL-POS-' + Math.floor(Math.random() * 1000000);

                $('#productTable tbody tr').each(function(index, row) {
                    productId = $(row).find('.productId').val();
                    qty = $(row).find('.qty').val();
                    finalTotal = $('#finalTotal').text().replace('mmk','');

                    orderList.push({
                        product_id : productId,
                        user_id : userId,
                        count : qty,
                        status : 0,
                        order_code : orderCode,
                        total_amt : finalTotal
                    });
                });

                $.ajax({
                    type : 'get',
                    url : '/user/order/temp',
                    data : Object.assign({}, orderList),
                    dataType : 'json',
                    success : function(res) {
                        res.status == 'success' ? location.href = '/user/order/payment' : location.reload();
                    }
                });
            });

        });
    </script>
@endsection
