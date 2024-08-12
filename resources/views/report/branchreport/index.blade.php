@extends('adminlte::page')

@section('title', 'Branch Report | Dashboard')

@section('content_header')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/dashboard" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Branch Report</span>
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
					<h3 class="mb-0;ml:5"><span style="font-family: serif;color:black;weight:bolder"><strong>የቅሪንጫፍ ሕሳብ</strong></span></h3>
                </div>

                <div class="card-body pt-1" >

                        <form method="post" id="sample_form" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group" style="display: flex; align-items: center;">
                                <label style="display: inline-block; margin-right: 5px;">Date: </label>
                                <input type="date" name="date" id="date" class="form-control" style="margin-right: 10px;" />
   
                            
                                @role('admin')
                                <label style="display: inline-block; margin-left: 5px;">Branch: </label>
                                <select style="display: inline-block; margin-left: 5px;" name="branch_id" id="branch_id" class="form-control">
                                <option value=" ">-- Select Branch --</option>
                                    @foreach (App\Models\address_management\Branch::orderBy('name')->where('status','1')->get() as $key => $value)   
                                        <option value="{{$value->id}}">
                                            {{$value->name}}
                                        </option>  
                                    @endforeach 
                                    <option value="all">All</option>
                                </select>
                                @endrole
                            </div>

                            <div class="form-group" style="display: flex; align-items: center;">
                                
                                <div id="date_error" style="display: none; width: 33%; margin-left:42px;">Please select  date</div>
                                <div id="branch_error" style="display: none; width: 33%; margin-left:80px;">Please select a branch</div>
                                
                            </div>
                            
                            <div class="form-group" style="display: flex; justify-content: flex-end;">
                            <button id="submit_btn" type="button" class="btn btn-primary">Generate Report</button>
                            </div>
                        </form>
                        <br><br>
                        <div id="branch_report_table">
                            <!-- Table content will be populated here -->
                        </div>

                    
                
                   


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
    var script = document.createElement('script');
    script.src = 'https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js';
    document.head.appendChild(script);
    
        $(document).ready(function(){
            // Submit form on button click
            $('#submit_btn').click(function(e) {
                e.preventDefault();
                
                var Date = $('#date').val();
                var BranchData = $('#branch_id').val();

        if (Date == "" || BranchData == ""){
                        if (Date === "") {
                        $("#date_error").css({
                            "display": "inline-block",
                            "color": "red",
                            "font-size": "12px"
                        });
                        }
                        if (BranchData === "") {
                            $("#branch_error").css({
                            "display": "inline-block",
                            "color": "red",
                            "font-size": "12px"
                            });
                    
                        } 

                    

                }else 
                {
                    // Generate report logic
                    // Add your code here to handle report generation
                    $.ajax({
                    url: '/report/branchreport/create',
                    type: 'POST',
                    data: {
                        date: Date,
                        branch_id: BranchData,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#sample_form').hide();
                        
                        if ('text' in response) {
                        $('#branch_report_table').append('<p>' + response.text + '</p>');
                        // $('#branch_report_table').append(response.button_html);
                        
                        } else {
                        // $('#branch_report_table').append(response.input_html);
                        $('#branch_report_table').append(response.table_html); 
    
                        }
                        
                        
                        
                    },
                    error: function(xhr) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                    });

                }

                
                




            });



        });




    function goBack() {
    
    location.reload();

    
    }

    
        
    </script>



   

    

    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop