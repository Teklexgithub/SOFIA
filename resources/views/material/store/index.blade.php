@extends('adminlte::page')

@section('title', 'Store | Dashboard')

@section('content_header')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/dashboard" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Stores</span>
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
                    <button type="button" name="create_record" id="create_record" class="float-right btn btn-sm btn-primary mr-3"><i class="bi bi-plus-square"></i> Add Store</button>
					<h3 class="mb-0;ml:5"><span style="font-family: serif;color:black;weight:bolder"><strong>Stores List</strong></span></h3>
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
                        <table style='width:100%'  class=" table table-bordered table-condensed mytable table-striped store_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Branch</th>
                                    <th>Material Type</th>
                                    <th>Material Name</th>
                                    <th width="300px">Action</th>
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
                <h5 class="modal-title" id="ModalLabel" style="color: white;">Add New Store</h5>
                <button type="button" id="closeButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border: 1px solid black;"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <span id="form_result"></span>
                
                <div class="form-group">
                <label>Branch : <span style="color: red;">&#10033;</span></label>
                <select name="branch_id" id="branch_id" class="form-control">
                    <option value=" ">-- Select Branch --</option>
                    @foreach (App\Models\address_management\Branch::orderBy('name')->get() as $key => $value)   
                        <option value="{{$value->id}}">
                            {{$value->name}}
                        </option>  
                    @endforeach
                </select>
                </div>
                <div class="form-group">
                <label for="material_type">Material Type : <span style="color: red;">&#10033;</span></label></br>
                <select name="material_type" id="material_type" class="form-control">
                    <option value="">-- select Material type --</option>
                    <option value="soft_drink">Soft Drink</option>
                    <option value="cigarates">Cigarates</option> 
                </select>
                </div>

                <div class="form-group" id="soft_drink_id_wrapper" style="display: none;">
                <label>Soft drink : <span style="color: red;">&#10033;</span></label>
                <select name="soft_drink_id" id="soft_drink_id" class="form-control">
                    <option value=" ">-- Select Soft drink --</option>
                    @foreach (App\Models\material_management\Softdrink::orderBy('name')->where('status','1')->get() as $key => $value)   
                        <option value="{{$value->id}}">
                            {{$value->name}}
                        </option>  
                    @endforeach
                </select>
                </div>

                <div class="form-group" id="cigarates_id_wrapper" style="display: none;">
                <label>Cigarates : <span style="color: red;">&#10033;</span></label>
                <select name="cigarates_id" id="cigarates_id" class="form-control">
                    <option value=" ">-- Select Cigarates --</option>
                    @foreach (App\Models\material_management\Cigarates::orderBy('name')->where('status','1')->get() as $key => $value)   
                        <option value="{{$value->id}}">
                            {{$value->name}}
                        </option>  
                    @endforeach
                </select>
                </div>
               
                <div class="form-group">
                    <label>Amount : <span style="color: red;">&#10033;</span></label>
                    <input type="text" name="number" id="number" class="form-control" />
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
                <button type="button" id="closeButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border: 1px solid black;"></button>
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
                    <h5 class="modal-title" id="attributeModalLabel" style="color: white;">Store Details</h5>
                    <button type="button" id="closebutton" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border: 1px solid black;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="attributeDetails0"></div>
                    <div id="attributeDetails1"></div>
                    <div id="attributeDetails2"></div>
                    <div id="attributeDetails3"></div>
                    
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
    var table = $('.store_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('store.view_store') }}",
        
        columns: [
            {data: 'number', name: 'number'},
            {data: 'branch_id', name: 'branch_id'},
            {data: 'material_type', name: 'material_type'},
            {data: 'beverage', name: 'beverage'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $(".dataTables_filter").remove();
    $(".dataTables_length").remove();
    dataTableSearch = $('.store_table').DataTable();  
    $('#dataTableSearch').keyup(function(){
        dataTableSearch.search($(this).val()).draw() ;
    })
    $('#dataTableSize').change(function(){
        dataTableSearch.page.len($(this).val()).draw() ;
    })

    dataTableSearch.page.len(5).draw() ;

    
 
    $('#create_record').click(function(){
        $('.modal-title').text('Add New Store');
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
            action_url = "{{ route('store.store_store') }}";
        }
 
        if($('#action').val() == 'Edit')
        {
            action_url = "{{ route('store.update_store') }}";
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
                    $('#store_table').DataTable().ajax.reload();
                    
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
            url :"/material/store/edit/"+id+"/",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(data)
            {
                console.log('success: '+data);
                $('#branch_id').val(data.result.branch_id);
                $('#material_type').val(data.result.material_type);
                $('#soft_drink_id').val(data.result.soft_drink_id);
                $('#cigarates_id').val(data.result.cigarates_id);
                $('#number').val(data.result.number);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Store');
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
            url :"/material/store/show/"+id+"/",
            type: "GET",
            dataType: "json",
            success: function(response) {
                var attribute = response.attribute;
                var branchname = response.branchname;
                var Materialname = response.Materialname;
                var cigaratename = response.cigaratename;
                
                // Populate the modal with attribute data
                $('#attributeDetails0').html('<p>'+'<strong> Branch:</strong>'+'<br>' + branchname + '</p>');
                $('#attributeDetails1').html('<p>'+'<strong> Material Type:</strong>'+'<br>' + attribute.material_type + '</p>');
                $('#attributeDetails2').html('<p>'+'<strong> Material Name:</strong>'+'<br>' + Materialname + '</p>');        
                $('#attributeDetails3').html('<p>'+'<strong> Amount:</strong>'+'<br>' + attribute.number + '</p>');
                              
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
                location.reload();
                
            },
            error: function(xhr, status, error) {
                    // Handle the error
                    console.log(error);
              }
        });
    });
    

    
    var store_id;
 
    $(document).on('click', '.delete', function(){
        store_id = $(this).attr('id');
        $('.modal-title').text('Delete Store');
        $('#confirmModal').modal('show');
    });
 
    $('#ok_button').click(function(){
        $.ajax({
            url:"/material/store/delete/"+store_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#store_table').DataTable().ajax.reload();
                alert('data deleted successfully');
                }, 2000);
                
            }
        })
    });

    $('#material_type').on('change', function() {
        var selectedValue = $(this).val();
        var softdrinkIdWrapper = $('#soft_drink_id_wrapper');
        var cigaratesIdWrapper = $('#cigarates_id_wrapper');

        if (selectedValue === 'soft_drink') {
            softdrinkIdWrapper.show();
        } else if(selectedValue === 'cigarates') {
            cigaratesIdWrapper.show();
        }
    });

    

    

   
});
</script>

<script>
        $(document).ready(function () {
  

            /*------------------------------------------
            --------------------------------------------
            Region Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#region-dropdown').on('change', function () {
                var idCountry = this.value;
                $("#zone-dropdown").html('');
                $.ajax({
                    url: "{{url('get-zone-by-region')}}",
                    type: "POST",
                    data: {
                        region_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#zone-dropdown').html('<option value="">-- Select zone --</option>');
                        $.each(result.zone, function (key, value) {
                            $("#zone-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#woreda-dropdown').html('<option value="">-- Select Woreda --</option>');
                    }
                });
            });
  
            /*------------------------------------------
            --------------------------------------------
            Zone Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#zone-dropdown').on('change', function () {
                var idState = this.value;
                $("#woreda-dropdown").html('');
                $.ajax({
                    url: "{{url('get-woreda-by-zone')}}",
                    type: "POST",
                    data: {
                        zone_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#woreda-dropdown').html('<option value="">-- Select woreda --</option>');
                        $.each(res.woreda, function (key, value) {
                            $("#woreda-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });


            $('#woreda-dropdown').on('change', function () {
                var idCity = this.value;
                $("#kebele-dropdown").html('');
                $.ajax({
                    url: "{{url('get-kebele-by-woreda')}}",
                    type: "POST",
                    data: {
                        woreda_id: idCity,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#kebele-dropdown').html('<option value="">-- Select Kebele --</option>');
                        $.each(res.kebele, function (key, value) {
                            $("#kebele-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
  
        });
</script>


   

    

    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop