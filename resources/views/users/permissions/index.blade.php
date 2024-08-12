@extends('adminlte::page')

@section('title', 'Permissions | Dashboard')

@section('content_header')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/dashboard" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Permissions</span>
                </div>
                <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="content">

    <div class="row">
        <div class="col-12 table-responsive">
            <div class="card">
                <div class="pl-3 card-header" style='background-color:whitesmoke' >
                    <button type="button" name="create_record" id="create_record" class="float-right btn btn-sm btn-primary mr-3"><i class="bi bi-plus-square"></i> Add Permission</button>
                    <h3 class="mb-0;ml:5"><span style="font-family: serif;color:black;weight:bolder"><strong>Permissions List</strong></span></h3>
                </div>

                <div class="card-body pt-1" >

                    <div class='row mb-2'>
                        <div class='col-5'>
                            <table style='width:120px'>
                                <tr>
                                    <td class='pt-1'><label>Show</label></td>
                                    <td class='pt-1'><label>:</label></td>
                                    <td>
                                        <select id='dataTableSize' class='custom-select custom-select-sm form-control form-control-sm'>
                                            <option value='3'>3</option>
                                            <option value='5'>5</option>
                                            <option value='10' selected>10</option>
                                            <option value='25'>25</option>
                                            <option value='50'>50</option>
                                            <option value='100'>100</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class='col-7 pr-3 '>
                            <table style='width:200px;float:right'>
                                <tr>
                                    <td class='pt-1'><label>Search</label></td>
                                    <td class='pt-1'><label> :</label></td>
                                    <td>
                                        <input type="search" id='dataTableSearch' class="form-control form-control-sm" placeholder="input search key..." style="width:150px">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                
                    <div class='row table-responsive'>
                        <table style='width:100%'  class=" table table-bordered table-condensed mytable table-striped permission_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th width="350px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header" style="background-color: lightgray; text-align: center;">
                <h5 class="modal-title" id="ModalLabel" style="color: white;">Add New Permission</h5>
                <button type="button" id="closeButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border: 1px solid black;"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <span id="form_result"></span>
                <div class="form-group">
                    <label for='name' class='form-label'>Name : <span class='text-danger'>*</span></label>
                    <input type="text" name="name" id="name" class="form-control" />
                </div>
                
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="hidden" name="hidden_id" id="hidden_id" />
            </div>
            <div class="modal-footer">
                <button type="button" id="closeButton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-info" />
            </div>
        </form>  
        </div>
        </div>
    </div>


    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
                <button type="button" id="closeButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeButton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
            </div>
        </form>  
        </div>
        </div>
    </div>

    <div class="modal fade" id="attributeModal" tabindex="-1" role="dialog" aria-labelledby="attributeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: lightgray; text-align: center;">
                    <h5 class="modal-title" id="attributeModalLabel" style="color: white;">Permission Details</h5>
                    <button type="button" id="closebutton" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border: 1px solid black;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="attributeDetails0"></div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" id="closebutton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>



   
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
   
@stop

@section('js')

   

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('.permission_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('permission.view_permission') }}",
            
            columns: [
                {data: 'number', name: 'number'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $(".dataTables_filter").remove();
        $(".dataTables_length").remove();
        dataTableSearch = $('.permission_table').DataTable();  
        $('#dataTableSearch').keyup(function(){
            dataTableSearch.search($(this).val()).draw() ;
        })
        $('#dataTableSize').change(function(){
            dataTableSearch.page.len($(this).val()).draw() ;
        })

        dataTableSearch.page.len(5).draw() ;
    
        $('#create_record').click(function(){
            $('.modal-title').text('Add New Permission');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#form_result').html('');
    
            $('#formModal').modal('show');
        });
    
        $('#sample_form').on('submit', function(event){
            event.preventDefault(); 
            var action_url = '';
    
            if($('#action').val() == 'Add')
            {
                action_url = "{{ route('permission.store_permission') }}";
            }
    
            if($('#action').val() == 'Edit')
            {
                action_url = "{{ route('permission.update_permission') }}";
            }
            
    
            $.ajax({
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: action_url,
                data:$(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    console.log('success: '+data);
                    var html = '';
                    if(data.errors)
                    {
                        html = '<div class="alert alert-danger">';
                        for(var count = 0; count < data.errors.length; count++)
                        {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if(data.success)
                    {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#sample_form')[0].reset();
                        $('#permission_table').DataTable().ajax.reload();
                        
                    }
                    $('#form_result').html(html);
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });
    
        $(document).on('click', '.edit', function(event){
            event.preventDefault(); 
            var id = $(this).attr('id'); 
            $('#form_result').html('');
    
            
    
            $.ajax({
                url :"/users/permission/edit/"+id+"/",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType:"json",
                
                success:function(data)
                {
                    console.log('success: '+data);
                    $('#name').val(data.result.name);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Permission');
                    $('#action_button').val('Update');
                    $('#action').val('Edit'); 
                    $('#formModal').modal('show');
                    
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            })
        });


        $(document).on('click', '#closeButton', function(event){
        event.preventDefault(); 
        $('#formModal').modal('hide');
        $('#confirmModal').modal('hide');
        location.reload();
        });
        $(document).on('click', '#closebutton', function(event){
            event.preventDefault(); 
            $('#attributeModal').modal('hide');
            
        });
        $('#formModal').on('hidden.bs.modal', function () {
        location.reload(); // Reload the page
        });
        $('#confirmModal').on('hidden.bs.modal', function () {
        location.reload(); // Reload the page
        });

        
        $(document).on('click', '.detail', function() {
            var id = $(this).attr('id');// Replace with the desired ID

            $.ajax({
                url :"/users/permission/show/"+id+"/",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var attribute = response.attribute;
                    
                
                    // Populate the modal with attribute data
                    $('#attributeDetails0').html('<p>'+'<strong> Name:</strong>'+'<br>' + attribute.name + '</p>');
                   
                    // Show the modal
                    $('#attributeModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle the error
                    console.log(error);
                }
            });
        });
        

        $(document).on('change', '.status', function() {
                var checkbox = $(this);
                var id = checkbox.data('id');// Replace with the desired ID

            $.ajax({
                url :"",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                data: { id: id },
                success: function(response) {
                    
                    
                },
                error: function(xhr, status, error) {
                        // Handle the error
                        console.log(error);
                }
            });
        });
        
        var permission_id;
    
        $(document).on('click', '.delete', function(){
            permission_id = $(this).attr('id');
            $('.modal-title').text('Delete Permission');
            $('#confirmModal').modal('show');
        });
    
        $('#ok_button').click(function(){
            $.ajax({
                url:"/users/permission/delete/"+permission_id,
                beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                },
                success:function(data)
                {
                    setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#permission_table').DataTable().ajax.reload();
                    alert('Data Deleted');
                    }, 2000);
                    
                }
            })
        });

    
    });
</script>
    
    

    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop