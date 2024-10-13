@extends('admin.generic')

@section('title', 'Users')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/admin/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}" />
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-basic table border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Phone</th>
                        <th>Products</th>
                        <th>Created at</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                {{-- <tbody class="table-border-bottom-0">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }}|{{ $user->first_name }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->products->count() }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->ban ? 'banned' : 'active' }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script>
        $(function() {
            var table = $('.datatables-basic').DataTable({
                serverSide: true,
                ajax: {
                    url: "/api/users",
                    type: "GET",
                    data: function(d) {
                        // Pass the selected filter value along with DataTables parameters
                        d.ban = $('#ban-filter').val();
                    }
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "first_name"
                    },
                    {
                        data: "phone_number"
                    },
                    {
                        data: "products_count"
                    },
                    {
                        data: "created_at"
                    },
                    {
                        data: "ban"
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false
                    } // Actions column
                ],
                columnDefs: [{
                        targets: 1,
                        responsivePriority: 1,
                        render: function(data, type, row, meta) {
                            var n = row.avatar,
                                l = row.first_name,
                                r = row.email;
                            return '<div class="d-flex justify-content-start align-items-center user-name">' +
                                '<div class="avatar-wrapper"><div class="avatar me-2">' +
                                (n ? '<img src="' + assetsPath + "img/avatars/" + n +
                                    '" alt="Avatar" class="rounded-circle">' :
                                    '<span class="avatar-initial rounded-circle bg-label-' + [
                                        "success", "danger", "warning", "info", "dark",
                                        "primary", "secondary"
                                    ][Math.floor(6 * Math.random())] + '">' + (n = (((n = (
                                                l = row.first_name).match(/\b\w/g) || [])
                                            .shift() || "") + (n.pop() || ""))
                                        .toUpperCase()) +
                                    "</span>") +
                                '</div></div><div class="d-flex flex-column"><span class="emp_name text-truncate">' +
                                l +
                                '</span><small class="emp_post text-truncate text-muted">' +
                                r + "</small></div></div>";
                        }
                    },
                    {
                        targets: -2,
                        responsivePriority: 2,
                        render: function(data, type, row, meta) {
                            var status = row.ban,
                                statusMap = {
                                    0: {
                                        title: "Active",
                                        class: "bg-label-success"
                                    },
                                    1: {
                                        title: "Banned",
                                        class: "bg-label-danger"
                                    }
                                };
                            return '<span class="badge ' + statusMap[status].class + '">' +
                                statusMap[status].title + '</span>';
                        }
                    },
                    {
                        targets: -1,
                        responsivePriority: 3,
                        title: "Actions",
                        render: function(data, type, row, meta) {
                            var status = row.ban,
                                statusMap = {
                                    0: {
                                        icon: "bx-block"
                                    },
                                    1: {
                                        icon: "bx-check"
                                    }
                                };
                            return '<button class="btn btn-icon toggle-ban" data-id="' + row.id +
                                '"><i class="bx ' + statusMap[status].icon +
                                ' bx-md"></i></button>';
                        }
                    }
                ],
                order: [
                    [0, "asc"]
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t' +
                    '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 5,
                lengthMenu: [5, 10, 25, 50, 75, 100],
                language: {
                    search: "", // Removes the "Search:" label
                    paginate: {
                        next: '<i class="bx bx-chevron-right bx-18px"></i>',
                        previous: '<i class="bx bx-chevron-left bx-18px"></i>'
                    }
                },
                buttons: [
                    // Button configurations here...
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(e) {
                                return "Details of " + e.data().first_name;
                            }
                        }),
                        type: "column",
                        renderer: function(e, t, a) {
                            a = $.map(a, function(e, t) {
                                return "" !== e.title ? '<tr data-dt-row="' + e.rowIndex +
                                    '" data-dt-column="' + e.columnIndex +
                                    '"><td>' + e.title + ":</td> <td>" + e.data + "</td></tr>" :
                                    "";
                            }).join("");
                            return !!a && $('<table class="table"/><tbody />').append(a);
                        }
                    }
                }
            });

            // Append dropdown filter before the search input
            $('.dataTables_filter').prepend(
                '<label>' +
                '<select id="ban-filter" class="form-select">' +
                '<option value="">All Statuses</option>' +
                '<option value="0">Active</option>' +
                '<option value="1">Banned</option>' +
                '</select>' +
                '</label>'
            );

            // Set placeholder text for the search input
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Search...');
            // Add custom class to the search input
            $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
            $('.dataTables_length select[name="users_length"]').removeClass('form-select-sm');

            // Event listener for the dropdown filter
            $('#ban-filter').on('change', function() {
                table.ajax.reload(); // Reload data with the new filter value
            });

            // Handle button click
            $('.datatables-basic').on('click', '.toggle-ban', function() {
                var userId = $(this).data('id');
                if (confirm('Are you sure you want to change status this record?')) {
                    $.ajax({
                        url: '/api/user/' + userId,
                        type: 'POST',
                        data: {
                            _method: 'POST',
                            _token: '{{ csrf_token() }}' // If you need to send a CSRF token
                        },
                        success: function(response) {
                            // Handle success response
                            alert(response.message);
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            // Handle error response
                            alert('An error occurred while accessing the server.');
                        }
                    });
                }
            });
        });
    </script>

@endsection
