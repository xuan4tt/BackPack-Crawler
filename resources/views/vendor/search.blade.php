@extends(backpack_view('blank'))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none">
                        <div id="crudTable_filter" class="dataTables_filter"><label><input type="search"
                                    class="form-control" placeholder="Search..." aria-controls="crudTable"></label></div>
                    </div>
                </div>

                <div class="col-sm-12 dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2 dataTable dtr-inline collapsed has-hidden-columns">
                                <thead>
                                    <tr>
                                        <th>
                                            Id
                                        </th>
                                        <th>
                                            Lớp học
                                        </th>
                                        <th>
                                            Môn học
                                        </th>
                                        <th>
                                            Câu hỏi
                                        </th>
                                        <th>
                                            Điểm số
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after_scripts')
    <script>
        alert(1);
    </script>
@endpush
