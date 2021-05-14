@extends(backpack_view('blank'))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-6">
                <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none">
                    <div id="crudTable_filter" class="dataTables_filter">
                        <label><input type="search" class="form-control" placeholder="Search..." aria-controls="crudTable"
                                onblur="search()" id="search_value"></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">CLASS</th>
                        <th scope="col">SUBJECT</th>
                        <th scope="col">QUESTION</th>
                        <th scope="col">SCORE</th>
                    </tr>
                </thead>
                <tbody id="table_content">

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('after_scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function search() {
            var search_value = document.getElementById('search_value').value
            var url = "{{ route('search.getdata') }}"
            if(search_value !== ''){
                axios.post(url, {
                    search: search_value
                }).then(function(response){
                    var html = ''
                    if(response.data.length > 0){
                        response.data.forEach(element => {
                            html += 
                            `
                            <tr>
                                <td>
                                    ${element._source.id}
                                </td>
                                <td>
                                    ${element._source.class_id}
                                </td>
                                <td>
                                    ${element._source.category_id}
                                </td>
                                <td>
                                    ${element.highlight.content[0]}
                                </td>
                                <td>
                                    ${element._score}
                                </td>
                            </tr>
                            `
                            
                        })
                    }
                    
                    document.getElementById('table_content').innerHTML = html;
                })
            }
            else{
                document.getElementById('table_content').innerHTML = '';
            }
        }

    </script>
@endsection
