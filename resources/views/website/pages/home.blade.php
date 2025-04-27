@extends('website.layouts.main', ['title' => 'Dashboard'])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-4">
            @if (auth()->check())
                <div class="col-lg-12">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-header">FORM QUEUE</h5>
                        </div>
                        <div class="table-responsive text-nowrap" style="padding: 0 1.25rem 0 1.25rem;">
                            <table class="table table-bordered" id="app_table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="50px">Tanggal</th>
                                        <th>No Registrasi</th>
                                        <th>Form Name</th>
                                        <th>Requestor</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->check() && auth()->user()->can('apps_fiola'))
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="piechart"></div>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $filter_month = request()->get('filter_month');
                $filter_year = request()->get('filter_year');
                $currentYear = date('Y');
                if ($filter_month && $filter_year) {
                    $bulanIndonesia = [
                        '00' => '',
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ];

                    $bulanIndonesia = $bulanIndonesia[$filter_month];
                } else {
                    $bulanInggris = now()->format('F');
                    $bulanIndonesia = [
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember',
                    ];
                    $filter_year = now()->format('Y');

                    $bulanIndonesia = $bulanIndonesia[$bulanInggris];
                }

                if ($filter_year == '0000') {
                    $filter_year = '';
                }

            @endphp
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/datatables.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/datatables/js/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/exporting.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/export-data.js') }}"></script>
    <script src="{{ asset('vendor/highcharts/accessibility.js') }}"></script>
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
    <script>
        function handleMonthChange() {
            const monthSelect = document.getElementById('filter_month');
            const yearSelect = document.getElementById('filter_year');
            const allYearsOption = yearSelect.querySelector('option[value="0000"]');

            if (monthSelect.value === "00") {
                allYearsOption.disabled = false;
            } else {
                allYearsOption.disabled = true;
                if (yearSelect.value === "0000") {
                    yearSelect.value = "<?php echo $currentYear; ?>";
                }
            }
        }

        function checkURLParams() {
            const urlParams = new URLSearchParams(window.location.search);
            const month = urlParams.get('filter_month');
            const year = urlParams.get('filter_year');
            const monthSelect = document.getElementById('filter_month');
            const yearSelect = document.getElementById('filter_year');
            const allYearsOption = yearSelect.querySelector('option[value="0000"]');

            if (month === '00') {
                allYearsOption.disabled = false;
            } else {
                allYearsOption.disabled = true;
                if (year === '0000') {
                    yearSelect.value = "<?php echo $currentYear; ?>";
                }
            }

            // Set the selected values in the dropdowns based on the URL parameters
            if (month) {
                monthSelect.value = month;
            }
            if (year) {
                yearSelect.value = year;
            }
        }

        // Run the check on page load
        document.addEventListener('DOMContentLoaded', function() {
            checkURLParams();
            handleMonthChange(); // Ensure correct state if values are changed on load
        });
    </script>

    @if (auth()->check())
        <script>
            $(document).ready(function() {
                var table = $('#app_table').DataTable({
                    'lengthChange': true,
                    'processing': true,
                    'serverSide': false,
                    'orderable': true,
                    ajax: {
                        url: "{{ route('website.home_ajax') }}",
                    },
                    columns: [{
                            data: 'created_at',
                            name: 'created_at',
                            render: function(data, type, row) {
                                if (data) {
                                    let date = new Date(data);
                                    let year = date.getFullYear();
                                    let month = (date.getMonth() + 1).toString().padStart(2, '0');
                                    let day = date.getDate().toString().padStart(2, '0');
                                    let hours = date.getHours().toString().padStart(2, '0');
                                    let minutes = date.getMinutes().toString().padStart(2, '0');
                                    let seconds = date.getSeconds().toString().padStart(2, '0');
                                    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                                }
                                return '';
                            }
                        },
                        {
                            data: 'no_reg',
                            name: 'no_reg',
                        },
                        {
                            data: 'title',
                            name: 'title',
                        },
                        {
                            data: 'user_name',
                            name: 'user_name',
                        },
                        {
                            data: 'department_name',
                            name: 'department_name',
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row, meta) {
                                if (data == 'created') {
                                    return `<span class="badge bg-warning" style="font-size: 15px;">Waiting Manager Approve</span>`;
                                } else if (data == 'approved') {
                                    return `<span class="badge bg-success" style="font-size: 15px;">Approved by Manager</span>`;
                                } else if (data == 'rejected') {
                                    return `<span class="badge bg-danger" style="font-size: 15px;">Rejected</span>`;
                                } else {
                                    return `<span class="badge bg-danger" style="font-size: 15px;">${data}</span>`;
                                }
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                // Periksa izin di sisi klien
                                var userCanApprove =
                                    {{ Auth::user()->can('approve_mgr') ? 'true' : 'false' }};
                                var createdBy =
                                    {{ Auth::user()->id }};

                                if (userCanApprove && data.final_status == 'IT Approve') {
                                    return `
                                        <center>
                                            <a href="/${row.form_url}/it_mgr_approval" class="btn btn-primary">
                                                <span class="mdi mdi-open-in-new"></span>
                                            </a>
                                        </center>
                                    `;
                                } else if (userCanApprove && data.final_status == 'created') {
                                    return `
                                        <center>
                                            <a href="/${row.form_url}/manager_approval" class="btn btn-primary">
                                                <span class="mdi mdi-open-in-new"></span>
                                            </a>
                                        </center>
                                    `;
                                } else if (data.created_by == createdBy) {
                                    return `
                                        <center>
                                            <a href="/${row.form_url}/list" class="btn btn-info">
                                                <span class="mdi mdi-eye"></span>
                                            </a>
                                        </center>
                                    `;
                                }
                                return ''; // Tidak menampilkan apa-apa jika tidak punya izin
                            }
                        }
                    ],
                    "order": [0, 'desc'],
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var urlParams = new URLSearchParams(window.location.search);
                var filter_month = urlParams.get('filter_month');
                var filter_year = urlParams.get('filter_year');

                $('#filter_year').val(filter_year);
                $('#filter_month').val(filter_month);

                if (!filter_month && !filter_year) {
                    document.getElementById('filter_month').value = (new Date().getMonth() + 1).toString().padStart(2,
                        '0');
                    document.getElementById('filter_year').value = new Date().getFullYear();
                }
            });
        </script>
    @endif
@endpush
