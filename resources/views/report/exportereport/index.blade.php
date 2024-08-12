@extends('adminlte::page')

@section('title', 'የላክዎች ክፍያ | Dashboard')

@section('content_header')
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-lg-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/dashboard" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Exporter Report</span>
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
					<h3 class="mb-0;ml:5"><span style="font-family: serif;color:black;weight:bolder"><strong>የላክዎች ክፍያ</strong></span></h3>
                </div>

                <div class="card-body pt-1" >

                        <form method="post" id="sample_form" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group" style="display: flex; align-items: center;">
                                <label style="display: inline-block; margin-right: 3px;">From: </label>
                                <input type="date" name="starting_date" id="starting_date" class="form-control" style="margin-right: 6px;" />

                                <label style="display: inline-block; margin-left: 3px;">To: </label>
                                <input type="date" name="end_date" id="end_date" class="form-control" style="margin-left: 10px;" />
   
   

                                <label style="display: inline-block; margin-left: 5px;">Khat: </label>
                                <select style="display: inline-block; margin-left: 5px;" name="khat_id" id="khat_id" class="form-control">
                                <option value=" ">-- Select Khat --</option>
                                    @foreach (App\Models\material_management\Khat::orderBy('name')->where('status','1')->get() as $key => $value)   
                                        <option value="{{$value->id}}">
                                            {{$value->name}}
                                        </option>  
                                    @endforeach 
                                    <option value="all">All</option>
                                </select>
                            </div>

                            <div class="form-group" style="display: flex; align-items: center;">
                                
                                <div id="starting_error" style="display: none; width: 33%; margin-left:42px;">Please select  starting date</div>
                                <div id="end_error" style="display: none; width: 33%; margin-left:42px;">Please select  end date</div>
                                <div id="khat_error" style="display: none; width: 33%; margin-left:80px;">Please select a Khat</div>
                                
                            </div>
                            
                            <div class="form-group" style="display: flex; justify-content: flex-end;">
                            <button id="submit_btn" type="button" class="btn btn-primary">Generate Report</button>
                            </div>
                        </form>
                        <br><br>
                        <div id="exporter_report_table">
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
                
                var StartingDate = $('#starting_date').val();
                var EndDate = $('#end_date').val();
                var KhatData = $('#khat_id').val();

        if (StartingDate == "" || KhatData == "" || EndDate == ""){
                        if (StartingDate === "") {
                        $("#starting_error").css({
                            "display": "inline-block",
                            "color": "red",
                            "font-size": "12px"
                        });
                        }
                        if (EndDate === "") {
                        $("#end_error").css({
                            "display": "inline-block",
                            "color": "red",
                            "font-size": "12px"
                        });
                        }
                        if (KhatData === "") {
                            $("#khat_error").css({
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
                    url: '/report/exportereport/create',
                    type: 'POST',
                    data: {
                        starting_date: StartingDate,
                        end_date: EndDate,
                        khat_id: KhatData,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#sample_form').hide();
                        
                        if ('text' in response) {
                        $('#exporter_report_table').append('<p>' + response.text + '</p>');
                        // $('#branch_report_table').append(response.button_html);
                        
                        } else {
                        // $('#branch_report_table').append(response.input_html);
                        $('#exporter_report_table').append(response.table_html); 
    
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