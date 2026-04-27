@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment Method</h1>
        </div>


        <div class="">
            <div class="row mb-2">
                <div class="col-4 offset-8">
                    <div class="">
                        <form action="{{ route('paymentList') }}" method="get">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="searchKey" value="{{ request('searchKey') }}"
                                    class=" form-control" placeholder="Enter Search Key...">
                                <button type="submit" class=" btn bg-dark text-white"> <i
                                        class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('paymentCreate') }}" method="post" class="p-3 rounded">
                                @csrf
                                <input type="text" name="accountType" value="{{ old('accountType') }}"
                                    class=" form-control mb-3 @error('accountType') is-invalid @enderror"
                                    placeholder="Account Type...">
                                @error('accountType')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="text" name="accountName" value="{{ old('accountName') }}"
                                    class=" form-control mb-3 @error('accountName') is-invalid @enderror"
                                    placeholder="Account Name...">
                                @error('accountName')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="text" name="accountNumber" value="{{ old('accountNumber') }}"
                                    class=" form-control @error('accountNumber') is-invalid @enderror"
                                    placeholder="Account Number...">
                                @error('accountNumber')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col ">

                    @if (count($payments) != 0)
                        <table class="table table-hover shadow-sm text-center">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-white">ID</th>
                                    <th class="bg-primary text-white">Type</th>
                                    <th class="bg-primary text-white">Name</th>
                                    <th class="bg-primary text-white">Number</th>
                                    <th class="bg-primary text-white"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($payments as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->account_name }}</td>
                                        <td>{{ $item->account_number }}</td>
                                        <td>
                                            <a href="{{ route('paymentEdit', $item->id) }}"
                                                class="btn btn-sm btn-outline-secondary"> <i
                                                    class="fa-solid fa-pen-to-square"></i> </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $item->id }})"> <i
                                                    class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                        <h3 class="text-muted text-center m-5">There is no data...</h3>
                    @endif


                    <span class=" d-flex justify-content-end">{{ $payments->links() }}</span>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js-script')
    <script>
        function confirmDelete($id) {
            Swal.fire({
                title: "Are you sure to delete this item?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/admin/payment/delete/' + $id;
                    }, 1000);
                }
            });

        }
    </script>
@endsection
