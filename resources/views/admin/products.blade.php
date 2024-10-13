@extends('admin.generic')

@section('title', 'Dashboard')

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
        <div class="row pt-6 px-6">
            <div class="col-md-4">
                <select id="status-filter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value=">=">Active</option>
                    <option value="<">Inactive</option>
                </select>
            </div>
            <div class="col-md-4">
                <select id="category-filter" class="form-select">
                    <option value="">All Categories</option>
                    <!-- Add categories dynamically or manually -->
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select id="type-filter" class="form-select">
                    <option value="">All Types</option>
                    <option value="close">Close</option>
                    <option value="open">Open</option>
                </select>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table id="products" class="datatables-basic table border-top">
                <thead>
                    <tr>
                        <th></th>
                        <th><input type="checkbox" class="form-check-input"></th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Current Price</th>
                        <th>Timeleft</th>
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
                    url: "/api/products",
                    type: "GET",
                    data: function(d) {
                        // Pass the selected filter value along with DataTables parameters
                        d.status = $('#status-filter').val();
                        d.category = $('#category-filter').val();
                        d.type = $('#type-filter').val();
                    }
                },
                columns: [{
                        data: null,
                    }, {
                        data: "id",
                    }, {
                        data: "name"
                    },
                    {
                        data: "category.name"
                    },
                    {
                        data: "auction.type"
                    },
                    {
                        data: "total_bid_amount"
                    },
                    {
                        data: "end_time"
                    }
                ],
                columnDefs: [{
                        className: "control",
                        targets: 0,
                        responsivePriority: 1,
                        render: function(data, type, row, meta) {
                            return "";
                        }
                    }, {
                        targets: 1,
                        orderable: false,
                        searchable: false,
                        responsivePriority: 3,
                        checkboxes: {
                            selectAllRender: '<input type="checkbox" class="form-check-input">'
                        },
                        render: function() {
                            return '<input type="checkbox" class="dt-checkboxes form-check-input">'
                        }
                    },
                    {
                        targets: 2,
                        responsivePriority: 1,
                        render: function(data, type, row, meta) {
                            var n = row.images[0].image_url,
                                l = row.name,
                                r = row.name;
                            return '<div class="d-flex justify-content-start align-items-center user-name">' +
                                '<div class="avatar-wrapper"><div class="avatar me-2">' +
                                (n ? '<img src="../../storage/' + n +
                                    '" alt="Avatar" class="rounded-circle">' :
                                    '<span class="avatar-initial bg-label-' + [
                                        "success", "danger", "warning", "info", "dark",
                                        "primary", "secondary"
                                    ][Math.floor(6 * Math.random())] + '">' + (n = (((n = (
                                                l = row.name).match(/\b\w/g) || [])
                                            .shift() || "") + (n.pop() || ""))
                                        .toUpperCase()) +
                                    "</span>") +
                                '</div></div><div class="d-flex flex-column"><span class="emp_name text-truncate">' +
                                l +
                                "</span></div></div>";
                        }
                    },
                    {
                        targets: 4,
                        responsivePriority: 2,
                        render: function(data, type, row, meta) {
                            var type = row.auction_type,
                                typeMap = {
                                    'close': {
                                        title: "Open Bid",
                                        class: "bg-label-success"
                                    },
                                    'open': {
                                        title: "Close Bid",
                                        class: "bg-label-secondary"
                                    }
                                };
                            return '<span class="badge ' + typeMap[type].class + '">' +
                                typeMap[type].title + '</span>';
                        }
                    },
                    {
                        targets: -1,
                        responsivePriority: 2,
                        render: function(data, type, row, meta) {
                            return `
                                    <div class="countdown text-danger"
                                        data-end-time="${row.end_time}">
                                        <span>${row.end_time}</span>
                                    </div>`;
                        }
                    }
                ],
                drawCallback: function() {
                    initializeCountdowns(); // Call countdown initialization
                },
                order: [
                    [1, "asc"]
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
                                return "Details of " + e.data().name;
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

            // Append delete button to the filter section
            $('.dataTables_filter').append(
                `
                <button id="delete-products" class="ms-2 btn btn-danger" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="bx bx-trash bx-sm me-sm-2"></i> <span class="d-none d-sm-inline-block">Delete Product</span></span></button>`
            );

            // Event listener for the delete button
            $('#delete-products').on('click', function() {
                // Get the selected rows data using DataTable's API
                var selectedRows = table.column(1).checkboxes.selected();

                // Extract the IDs from the selected rows
                var idsToDelete = [];
                $.each(selectedRows, function(index, rowId) {
                    idsToDelete.push(rowId);
                });

                // Check if any rows are selected
                if (idsToDelete.length === 0) {
                    alert('Please select at least one product to delete.');
                    return;
                }

                // Confirm before deleting
                if (!confirm('Are you sure you want to delete the selected products?')) {
                    return;
                }

                // AJAX request to delete the selected items
                $.ajax({
                    url: '/api/products/delete',
                    type: 'POST',
                    data: {
                        ids: idsToDelete
                    },
                    success: function(response) {
                        // Reload the DataTable after successful deletion
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while deleting the products: ' + error);
                    }
                });
            });

            // Filter change handler to reload data
            $('#status-filter, #category-filter, #type-filter').on('change', function() {
                table.ajax.reload();
            });

            // Set placeholder text for the search input
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Search...');
            // Add custom class to the search input
            $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
            $('.dataTables_length select[name="users_length"]').removeClass('form-select-sm');
        });

        // Countdown Initialization Function
        function initializeCountdowns() {
            var countdowns = document.querySelectorAll('.countdown');

            countdowns.forEach(function(countdown) {
                var endTime = new Date(countdown.dataset.endTime).getTime();

                function updateCountdown() {
                    var now = new Date().getTime();
                    var timeRemaining = endTime - now;

                    if (timeRemaining <= 0) {
                        countdown.innerHTML = "Auction Ended";
                        return;
                    }

                    var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    var formattedCountdown = days.toString().padStart(2, '0') + ':' +
                        hours.toString().padStart(2, '0') + ':' +
                        minutes.toString().padStart(2, '0') + ':' +
                        seconds.toString().padStart(2, '0');

                    countdown.innerHTML = formattedCountdown;

                    setTimeout(updateCountdown, 1000);
                }

                updateCountdown();
            });
        }
    </script>
@endsection
