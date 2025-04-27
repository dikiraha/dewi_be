@extends('website.layouts.main', ['title' => 'List User'])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="d-flex justify-content-between">
                <h5 class="card-header">List User</h5>
                <a href="{{ route('website.user.create') }}" class="btn btn-success" style="margin: 1.25rem;">Create</a>
            </div>
            <div class="table-responsive text-nowrap" style="padding: 0 1.25rem 0 1.25rem;">
                <table class="table table-bordered" id="app_table" width="100%">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th width="150px">Option</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure want to delete this item?
                    <input type="text" readonly class="form-control-plaintext" id="name_delete">
                    <input type="hidden" id="uuid_delete">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btn-approve-delete">Yes, Delete!</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/datatables.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/datatables/js/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session()->has('success'))
                toastr['success']("{{ Session('success') }}")
            @endif
        })
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#app_table').DataTable({
                'lengthChange': true,
                'processing': true,
                'serverSide': false,
                'orderable': true,
                ajax: {
                    url: "{{ route('website.user.list_ajax') }}",
                },
                columns: [{
                        data: null,
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            var rowIndex = meta.row + meta.settings._iDisplayStart + 1;
                            return rowIndex;
                        },
                        className: "text-center"
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'department',
                        name: 'department',
                    },
                    {
                        data: 'role',
                        name: 'role',
                    },
                    {
                        orderable: false,
                        searchable: false,
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<div class="text-center">
                                        <a href="{{ url('user/edit/') }}/${row.uuid}" class="btn btn-sm btn-primary">Edit</a>
                                        <button class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-uuid="${data.uuid}" data-name="${data.name}">Delete</button>
                                    </div>
                            `;
                        }
                    },
                ],
            });

            $('#app_table').on('click', '.btn-delete', function() {
                var uuid_delete = $(this).data('uuid');
                var name_delete = $(this).data('name');
                var approveButton = document.getElementById('btn-approve-delete');

                approveButton.removeAttribute('disabled');
                approveButton.innerHTML = 'Yes, Delete!';
                $('#uuid_delete').val(uuid_delete)
                $('#name_delete').val(name_delete)
            })

            $('#btn-approve-delete').on('click', function() {
                let uuid_delete = $('#uuid_delete').val();

                $.ajax({
                    url: "{{ route('website.user.destroy') }}",
                    type: "POST",
                    data: {
                        uuid: uuid_delete,
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        toastr.success(response.success);
                        table.ajax.reload();
                        $('#deleteModal').modal('hide')
                    },
                    error: function(xhr, status, error, response) {
                        toastr.error(xhr.responseJSON?.error || 'Failed to delete.');
                        $('#deleteModal').modal('hide')
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var approveButton = document.getElementById('btn-approve-delete');
            var spinner = '<i class="mdi mdi-loading spin"></i>';

            approveButton.addEventListener('click', function() {
                approveButton.setAttribute('disabled', 'true');
                approveButton.innerHTML = spinner + ' Deleting...';
            });
        });
    </script>
@endpush
