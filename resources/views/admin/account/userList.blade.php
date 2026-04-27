@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('accountAdminList') }}"> <button class=" btn btn-sm btn-secondary  "> Admin List</button> </a>
            <div class="">
                <form action="{{ route('accountUserList') }}" method="get">
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
            <div class="col">
                @if (count($users) != 0)
                    <table class="table table-hover shadow-sm text-center">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">Profile</th>
                                <th class="bg-primary text-white">Name</th>
                                <th class="bg-primary text-white">Email</th>
                                <th class="bg-primary text-white">Address</th>
                                <th class="bg-primary text-white">Phone</th>
                                <th class="bg-primary text-white">Role</th>
                                <th class="bg-primary text-white">Created Date</th>
                                <th class="bg-primary text-white"> Platform</th>
                                <th class="bg-primary text-white"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->profile != null ? asset('profile/' . $item->profile) : asset('default/default-profile.jpeg') }}"
                                            class="w-25 img-thumbnail rounded" alt="">
                                    </td>
                                    <td>{{ $item->name ?? $item->nickname }}</td>
                                    <td>{{ $item->email }} </td>
                                    <td>{!! $item->address ?? '<i class="fa-solid fa-circle-xmark text-danger opacity-50"></i>' !!}</td>
                                    <td>{!! $item->phone ?? '<i class="fa-solid fa-circle-xmark text-danger opacity-50"></i>' !!}</td>
                                    <td><span
                                            class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $item->role }}</span>
                                    </td>

                                    <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                    <td>
                                        @if ($item->provider == 'simple')
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        @endif
                                        @if ($item->provider == 'google')
                                            <i class="fa-brands fa-google"></i>
                                        @endif
                                        @if ($item->provider == 'github')
                                            <i class="fa-brands fa-github"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <button onclick="confirmDelete({{$item->id}})" class="btn btn-sm btn-outline-danger"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <h3 class="text-muted text-center m-5">There is no data...</h3>
                @endif


                <span class=" d-flex justify-content-end">{{ $users->links() }}</span>

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
                        location.href = '/admin/account/user/delete/' + $id;
                    }, 1000);
                }
            });

        }
    </script>
@endsection
