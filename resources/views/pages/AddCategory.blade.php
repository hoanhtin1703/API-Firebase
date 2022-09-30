@extends('layouts.Home')
@section('content')
    <div class="container">
        <div class="row">

            <h2>ADD Category</h2>
            <div class="col-lg-6">
                <form action="" method="post" id="Add-Category" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category_Name</label>
                        <input type="text" name="category_name" class="form-control category_name">
                        <input type="file" name="image" placeholder="Choose image"
                        id="image">
                        <input type="hidden" id="cate">
                    </div>

                    <a href="javascript:void(0)" id="save-btn" class="btn btn-primary">Save</a>
                </form>
            </div>
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table " id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Column 1</th>
                                <th scope="col" colspan="2">Column 3</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            var table = $('#myTable').DataTable({
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }, ],
                columns: [

                    {
                        data: null,

                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                          
                        }
                    },
                    {
                        data: "category_name"
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return '<button  onclick="return update(' + data +
                                ')" class="btn btn-primary">View</button> </br><button  onclick="return xoa(' +
                                data + ')" class="btn btn-danger">Delete</button>';
                        }
                    },
                ],
            });
            $.ajax({
                method: 'GET',
                url: '{{ url('/api/get_category') }}',
                dataType: 'json',
                success: function(json) {   
                    table.rows.add(json).draw();
                }
            });

            $("#save-btn").click(function(e) {
                // console.log("last id"+id)
                var _token = $('input[name="_token"]').val();
                e.preventDefault();
                // $("#cate").val($('.category_name').val());
                // var category_name = $('#cate').val();
                var formData = new FormData($('form#Add-Category')[0]);
                $.ajax({
                    type: "POST",
                    url: '{{ url('/api/add-category') }}',
                    data: formData,
                    cache: false,
                     contentType: false,
                      processData: false,
                    success: function(data) {
                         
                        $('#myTable').DataTable().clear();
                        $.ajax({
                            method: 'GET',
                            url: '{{ url('/api/get_category') }}',
                            dataType: 'json',
                            success: function(json) {
                                console.log(json.category_name)
                                table.rows.add(json).draw();
                            }
                        });
                        console.log(data)
                    }
                });
            });
        });

        function update(id) {
            alert("sua" + id)
        }
        function xoa(id) {
            alert("xoa" + id)
        }
    </script>
    {{-- <script>
        $(document).ready(function() {
            // getData()
            //   Add Category  

            async function getData() {
                try {
                    const response = await fetch('/api/get_category');
                    if (!response.ok) {
                        const message = 'Error with Status Code: ' + response.status;
                        throw new Error(message);
                    }
                    const data = await response.json();
                    console.log(data);
                    $.map(data, function (elementOrValue, indexOrKey) {
                        console.log(elementOrValue)
                        $.map(elementOrValue, function (elementOrValue1, indexOrKey1) {
                            console.log(elementOrValue1)
                        });
                    });
                } catch (error) {
                    console.log('Error: ' + err);
                }
            }
        });
    </script> --}}
@endpush
