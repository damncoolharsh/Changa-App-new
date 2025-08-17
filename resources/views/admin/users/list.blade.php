@extends('layouts/main')

@section('title', 'Dashboard')

@section('content')

    <style>
        
    </style>

    <body class="bg-theme bg-theme1">
        <div id="wrapper">

            @include('panels/sidebar')
            @include('panels/navbar')


            <div class="content-wrapper">
                <div class="container-fluid">

                    <!--Start Custromer Content-->
                    <section id="customer-list">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h5>Customer Listing <span class="float-right"><a href="{{ route('create.user') }}"
                                            class="btn btn-primary">Create</a></span></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="bulk-delete-form" action="{{ route('bulk.delete.users') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-danger" id="bulk-delete-btn" style="display: none;">Delete Selected</button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"><input type="checkbox" id="select-all-users"></th>
                                                            <th scope="col">Sr. No.</th>
                                                            <th scope="col">Customer ID</th>
                                                            {{-- <th scope="col">Created Date</th> --}}
                                                            <th scope="col">Customer Name</th>
                                                            <th scope="col">Email Address</th>
                                                            <th scope="col">Phone Number</th>
                                                            <th scope="col">User Name</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($users as $key=> $user)
                                                            <tr>
                                                                <td><input type="checkbox" class="user-checkbox" name="selected_users[]" value="{{ $user->id }}"></td>
                                                                <th scope="row">{{$key+1}}</th>
                                                                <td>{{ $user->customer_id }}</td>
                                                                {{-- <td>{{ $user->created_at }}</td> --}}
                                                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>{{ $user->phone }}</td>
                                                                <td>{{ $user->username }}</td>
                                                                <td>
                                                                    <a href="{{ route('show.user', $user->id) }}"
                                                                        class="btn btn-success">View</a>
                                                                    <a href="{{ route('edit.user', $user->id) }}"
                                                                        class="btn btn-warning">Edit</a>
                                                                    {{-- <a href="JavaScript:void(0)"
                                                                        class="btn btn-danger openModal" type="button"
                                                                        data-toggle="modal" data-target="#exampleModalCenter"
                                                                        data-url="{{ route('modal.user', $user->id) }}">Delete</a> --}}

                                                                <a class="delete-data btn btn-danger"
                                                                    href="javascript:void(0);"
                                                                    data-url={{ route('delete.user', $user->id) }}
                                                                    data-title="Are you sure?"
                                                                    data-body="Customer will be deleted!"
                                                                    data-icon="warning"
                                                                    data-success="Customer successfully deleted!"
                                                                    data-cancel="Customer is safe!"
                                                                    title="Delete">Delete</i>
                                                                </a>

                                                                <div style="position: relative;" data-table=""
                                                                    data-id="{{ $user->id }}"
                                                                    data-status="{{ $user->active }}"
                                                                    class="switch delete-data "
                                                                    data-url="{{ route('status.user', ['id' => $user->id, 'status' => $user->active]) }}"
                                                                    data-title="Are you sure to change status?"
                                                                    data-icon="warning"
                                                                    data-success="Status successfully updated!"
                                                                    data-cancel="Status did not changed!" title="Update">

                                                                    <label>

                                                                        <input class="status"
                                                                            id="togle-{{ $user->id }}"
                                                                            {{ $user->active == '1' ? 'checked' : '' }}
                                                                            type="checkbox">

                                                                        <span class="lever slider round"></span>

                                                                    </label>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                            {{ $users->links('pagination::bootstrap-4') }}
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                    <!--End Custromer Content-->

                    <!--start overlay-->
                    <div class="overlay toggle-menu"></div>
                    <!--end overlay-->

                </div>
                <!-- End container-fluid-->

            </div>

            <!--Start Back To Top Button-->
            <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
            <!--End Back To Top Button-->

            {{-- @include('modals/delete_users')     --}}

        </div>


    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#select-all-users').on('change', function() {
                    $('.user-checkbox').prop('checked', $(this).prop('checked'));
                    toggleBulkDeleteButton();
                });

                $('.user-checkbox').on('change', function() {
                    toggleBulkDeleteButton();
                });

                function toggleBulkDeleteButton() {
                    if ($('.user-checkbox:checked').length > 0) {
                        $('#bulk-delete-btn').show();
                    } else {
                        $('#bulk-delete-btn').hide();
                    }
                }

                // Initial check on page load
                toggleBulkDeleteButton();

                $('#bulk-delete-form').on('submit', function(e) {
                    e.preventDefault();
                    var form = $(this);
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete selected users!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST', // Laravel's @method('DELETE') will handle this
                                data: form.serialize(),
                                success: function(response) {
                                    if (response.status === 1) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.message,
                                            'success'
                                        ).then(() => {
                                            // Remove deleted rows from the table
                                            $('input.user-checkbox:checked').each(function() {
                                                $(this).closest('tr').remove();
                                            });
                                            // Hide the bulk delete button if no checkboxes are selected
                                            toggleBulkDeleteButton();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            response.message,
                                            'error'
                                        );
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred during deletion.',
                                        'error'
                                    );
                                }
                            });
                        }
                    })
                });
            });
        </script>
    @endsection
