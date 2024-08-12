@extends('adminlte::page')

@section('title', 'Cigarates Hisabi | Dashboard')

@section('content_header')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/dashboard" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Cigarates Hisabi</span>
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
                    <button type="button" name="create_record" id="create_record" class="float-right btn btn-sm btn-primary mr-3"><i class="bi bi-plus-square"></i> Add Cigarates Hisabi</button>
					<h3 class="mb-0;ml:5"><span style="font-family: serif;color:black;weight:bolder"><strong>የሲጋራ ሕሳብ</strong></span></h3>
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
                        <table style='width:100%'  class=" table table-bordered table-condensed mytable table-striped dailyworkcigarates_table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Branch</th>
                                    <th>Cigarate Type</th>
                                    <th>Total</th>
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
                <h5 class="modal-title" id="ModalLabel" style="color: white;">Add New Cigarates Hisabi</h5>
                <button type="button" id="closeButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border: 1px solid black;"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <span id="form_result"></span>
                
                @role('admin')
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
                @endrole
                <div class="form-group">
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
                    <label>Addis Yeweta : <span style="color: red;">&#10033;</span></label>
                    <input type="text" name="yetekefete_cigarates" id="yetekefete_cigarates" class="form-control" />
                </div>              
                <div class="form-group">
                    <label>Yalew Packet : <span style="color: red;">&#10033;</span></label>
                    <input type="text" name="yadere_packet" id="yadere_packet" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Yalew Half : <span style="color: red;">&#10033;</span></label>
                    <input type="text" name="yadere_half" id="yadere_half" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Date : <span style="color: red;">&#10033;</span></label>
                    <input type="date" name="date" id="date" class="form-control" />
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
                    <h5 class="modal-title" id="attributeModalLabel" style="color: white;">Cigarates Hisabi Details</h5>
                    <button type="button" id="closebutton" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; border: 1px solid black;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="attributeDetails0"></div>
                    <div id="attributeDetails1"></div>
                    <div id="attributeDetails2"></div>
                    <div id="attributeDetails3"></div>
                    <div id="attributeDetails4"></div>
                    <div id="attributeDetails5"></div>
                    <div id="attributeDetails6"></div>
                    <div id="attributeDetails7"></div>
                    <div id="attributeDetails8"></div>
                    
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
    var table = $('.dailyworkcigarates_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dailyworkcigarates.view_dailyworkcigarates') }}",
        
        columns: [
            {data: 'number', name: 'number'},
            {data: 'branch_id', name: 'branch_id'},
            {data: 'cigarates_id', name: 'cigarates_id'},
            {data: 'total_cigarates', name: 'total_cigarates'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $(".dataTables_filter").remove();
    $(".dataTables_length").remove();
    dataTableSearch = $('.dailyworkcigarates_table').DataTable();  
    $('#dataTableSearch').keyup(function(){
        dataTableSearch.search($(this).val()).draw() ;
    })
    $('#dataTableSize').change(function(){
        dataTableSearch.page.len($(this).val()).draw() ;
    })

    dataTableSearch.page.len(5).draw() ;

    
 
    $('#create_record').click(function(){
        $('.modal-title').text('Add New Cigarates Hisabi');
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
            action_url = "{{ route('dailyworkcigarates.store_dailyworkcigarates') }}";
        }
 
        if($('#action').val() == 'Edit')
        {
            action_url = "{{ route('dailyworkcigarates.update_dailyworkcigarates') }}";
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
                    $('#dailyworkcigarates_table').DataTable().ajax.reload();
                    
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
            url :"/dailywork/dailyworkcigarates/edit/"+id+"/",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(data)
            {
                console.log('success: '+data);
                $('#branch_id').val(data.result.branch_id);
                $('#cigarates_id').val(data.result.cigarates_id);
                $('#yetekefete_cigarates').val(data.result.yetekefete_cigarates);
                $('#yadere_packet').val(data.result.yadere_packet);
                $('#yadere_half').val(data.result.yadere_half);
                $('#date').val(data.result.date);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Cigarates Hisabi');
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
            url :"/dailywork/dailyworkcigarates/show/"+id+"/",
            type: "GET",
            dataType: "json",
            success: function(response) {
                var attribute = response.attribute;
                var branchname = response.branchname;
                var cigaratesname = response.cigaratesname;
                
                
                // Populate the modal with attribute data
                $('#attributeDetails0').html('<p>'+'<strong> Branch:</strong>'+'<br>' + branchname + '</p>');
                $('#attributeDetails1').html('<p>'+'<strong> Cigarates:</strong>'+'<br>' + cigaratesname + '</p>');
                $('#attributeDetails2').html('<p>'+'<strong> Yetekefete Cigarates:</strong>'+'<br>' + attribute.yetekefete_cigarates + '</p>');
                $('#attributeDetails3').html('<p>'+'<strong> Total Cigarates:</strong>'+'<br>' + attribute.total_cigarates + '</p>');        
                $('#attributeDetails4').html('<p>'+'<strong> Yalew Packet:</strong>'+'<br>' + attribute.yadere_packet + '</p>');
                $('#attributeDetails5').html('<p>'+'<strong> Yalew Half:</strong>'+'<br>' + attribute.yadere_half + '</p>');
                
                $('#attributeDetails6').html('<p>'+'<strong> Yeteshete Cigarates:</strong>'+'<br>' + attribute.yeteshete_cigarates + '</p>');
                $('#attributeDetails7').html('<p>'+'<strong> Birr:</strong>'+'<br>' + attribute.birr + '</p>');
                $('#attributeDetails8').html('<p>'+'<strong> Date:</strong>'+'<br>' + attribute.date + '</p>');
                
                
                              
                // Show the modal
                $('#attributeModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle the error
                console.log(error);
            }
        });
    });

   

    
    var dailyworkcigarates_id;
 
    $(document).on('click', '.delete', function(){
        dailyworkcigarates_id = $(this).attr('id');
        $('.modal-title').text('Delete Cigarates Hisabi');
        $('#confirmModal').modal('show');
    });
 
    $('#ok_button').click(function(){
        $.ajax({
            url:"/dailywork/dailyworkcigarates/delete/"+dailyworkcigarates_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#dailyworkcigarates_table').DataTable().ajax.reload();
                alert('data deleted successfully');
                }, 2000);
                
            }
        })
    });

    // $('#lela_branch_yetelake').on('change', function() {
    //     var selectedValue = $(this).val();
    //     var wedebranchIdWrapper = $('#wede_branch_id_wrapper');
    //     var yetelakeTypewrapper = $('#yetelake_type_wrapper');
    //     var yetelakeAmountwrapper = $('#yetelake_amount_wrapper');

    //     if (selectedValue === 'yes') {
    //         wedebranchIdWrapper.show();
    //         yetelakeTypewrapper.show();
    //         yetelakeAmountwrapper.show();
    //     } else if(selectedValue === 'no') {
    //         wedebranchIdWrapper.hide();
    //         yetelakeTypewrapper.hide();
    //         yetelakeAmountwrapper.hide();
    //     }
    // });

    

    

   
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