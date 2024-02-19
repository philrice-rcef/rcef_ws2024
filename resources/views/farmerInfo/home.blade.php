<?php $qr_side = "active"; $qr_home="active"?>

@extends('layouts.index')

@section('styles')
  <link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/iCheck/skins/flat/green.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/daterangepicker.css') }}">
  <link href="public/css/HoldOn.min.css" rel="stylesheet">
  <style>
    .shadow-sm	{box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);}
    .shadow	{box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);}
    .shadow-md	{box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);}
    .shadow-lg	{box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);}
    .shadow-xl	{box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);}
    .shadow-2xl	{box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);}
    .shadow-inner	{box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);}
    .shadow-none	{box-shadow: 0 0 #0000;}

    .x_panel{
        /* background: conic-gradient(from 35deg, #57d98b60, #35945b80); */
        background: #e0e0e0;
        color: black;
        position: absolute;
        border-radius: 2em;
    }


    .x_title{
			margin: 10px;
            border: 1px #6b6b6b;
			box-sizing: border-box;
            background-color: transparent;
            border-radius: 10px;
            padding: 10px;
    }

    .x_title h1{
        font-weight: 900;
    }
    
    #containers{
			margin: 10px;
            border: 1px #6b6b6b;
			box-sizing: border-box;
            border-radius: 10px;
            padding: 10px;
            background-color: #faf5f580;
            backdrop-filter: blur(5px);
    }
    
    /* #databox{
			margin: 10px;
            border: 1px #6b6b6b;
			box-sizing: border-box;
            background-color: #faf5f5;
            border-radius: 10px;
            padding: 10px;

    } */

    
    h4{
        font-weight: 700;
        margin: 0 0 0.4em 0;
        padding: 0;
    }

    hr {
        border: none;
        height: 1px;
        background-color: #6b6b6b;
        margin-top: 0.5px;
        margin-bottom: 10px;
    }

    select{
        border: 1px solid #888;
        border-radius: 0.6em;
        padding: 0.2em;
        font-size: 1.4em;
    }

    .selectors {
    display: inline-block;
    }

    .selector_cards {
        display: inline-block;
        margin-right: 10px;
        margin-left: 10px;
    }

    .submit{
        width: max-content;
        margin-left: 15px;
    }

    .group_selector{
        display: flex;
        gap: 20%;
    }


    .boxes {
            width: 100%;
            height: 100%; 
            padding: 1em 2em;
            border-radius: 30px;
            background: #e0e0e0;
               border: 2px solid #c3c6ce;
                -webkit-transition: 0.5s ease-out;
                transition: 0.5s ease-out;
                overflow: visible;
		}

        .boxes:hover {
        border-color: #3ed655;
        /* -webkit-box-shadow: 10px 5px 18px 0 rgba(255, 255, 255, 0.877);
        box-shadow: 10px 5px 18px 0 rgba(255, 255, 255, 0.877); */
        }
		.col-md-6 {
			width: 50%;
			float: left;
            margin-top: 10px;

		}
		/* .row {
			clear: both;
			display: flex;
			flex-wrap: wrap;
			margin: 0 -10px;
		} */

        .shadow {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .btn {
            display: inline-block;
            margin-top: 5px;
            margin-right: 5px;     
        }

        #row {
        display: none;
        }

    #countProv,#countMun,#KPK,#FB,
    #male1,#male2,#male3,
    #female1,#female2,#female3{
        font-weight: bold;
    }


        

  </style>
@endsection

@section('content')

    <div class="clearfix" id="page">
    
    @include('layouts.message')
    
    <div class="row" id="page2">
        <div class="col-md-12" id="page1">
            <div class="x_panel shadow-2xl">
            <div class="x_title">
                <h1>Farmer Information</h1>
                <div class="clearfix"></div>
            </div>

                <section class="group_selector">
                        <div class="selectors" id="selectors style="display: inline-block;>
                            <div class="regions_container selector_cards" id="containers" style="display: inline-block; margin-right: 10px;">
                            <h4>Region:</h4>
                            <select class="form-select" name="region" id="region" disabled>
                                <option value="default">Select Regions</option>
                                @foreach(array_combine($regionNames, $regionCodes) as $name => $code)
                                <option value="{{$name}}">{{$name}}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="provinces_container selector_cards" id="containers" style="display: inline-block; margin-right: 10px;">
                            <h4>Province:</h4>
                            <select name="provinces" id="provinces" disabled>
                                <option value="default">Select Provinces</option>
                            </select>
                            </div>

                            <div class="municipality_container selector_cards" id="containers" style="display: inline-block;">
                            <h4>Municipality:</h4>
                            <select name="municipality" id="municipality" disabled>
                                <option value="default">Select Municipalities</option>
                            </select>
                            </div>

                            <div class="rsbsa_container selector_cards" id="containers" style="display: inline-block;">
                            <h4>RSBSA Control Number:</h4>
                                <input type="text" id="rsbsa">
                            </div>

                            <div>
                            <button type="button" id='submit' class="btn btn-success submit" disabled>Submit</button> 
                            </div>
                        </div>
                </section>
                    <table
                    class="table table-hover table-striped table-bordered"
                    id="farmers_tbl"
                    >
                    <thead>
                        <th>id</th>
                        <th>is_new</th>
                        <th>claiming_prv</th>
                        <th>rsbsa_control_no</th>
                        <th>rcef_id</th>
                        <th>lastName</th>
                        <th>firstName</th>
                        <th>midName</th>
                        <th>extName</th>
                        <th>fullName</th>
                        <th>birthdate</th>
                        <th>mother_lname</th>
                        <th>mother_fname</th>
                        <th>mother_mname</th>
                        <th>mother_suffix</th>
                        <th>final_area</th>
                        <th>final_claimable</th>
                        <th>is_claimed</th>
                        <th>total_claimed</th>
                        <th>total_claimed_area</th>
                        <th>is_replacement</th>
                        <th>replacement_area</th>
                        <th>replacement_bags</th>
                        <th>replacement_bags_claimed</th>
                        <th>replacement_area_claimed</th>
                        <th>replacement_reason</th>
                        <th>is_ebinhi</th>
                    </thead>
                    <tbody></tbody>
                    </table>
            </div>

        </div>
    </div>
    

    </div>
    

@endsection()

@push('scripts')
    <script src=" {{ asset('public/js/jquery.inputmask.bundle.js') }} "></script>
    <script src=" {{ asset('public/js/select2.min.js') }} "></script>
    <script src=" {{ asset('public/js/parsely.js') }} "></script>
    <script src=" {{ asset('public/assets/iCheck/icheck.min.js') }} "></script>
    <script src=" {{ asset('public/js/daterangepicker.js') }} "></script>
    <!-- <script src=" {{ asset('public/js/highcharts.js') }} "></script> -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="public/js/HoldOn.min.js"></script>

    <script> 

        $('#region').select2();
        $('#provinces').select2();
        $('#municipality').select2();
        var toBeReplaced = [];
        var table = $('#farmers_tbl').DataTable();

        $(window).on('load', function() {
        $('#region').removeAttr('disabled');
        $('#provinces').removeAttr('disabled');
        $('#municipality').removeAttr('disabled');
        $('#submit').removeAttr('disabled');
        $('#tagReplacement').removeAttr('disabled');
        
         });


        $('#region').on('change', () => {
            $reg = $('#region').val();

            var options = {
                theme:"sk-rect",
                message:'Please wait.',
                backgroundColor:"#494f5f",
                textColor:"white"
            };

            HoldOn.open(options);
            $.ajax({ 
                type: 'POST',
                url: "{{ route('farmerInfoProvinces') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    reg: $reg
                },
                success: function(data){
                    HoldOn.close();

                    $('#provinces option:gt(0)').remove();
                    $('#municipality option:gt(0)').remove();
                    for(i = 0; i < data.length; i++){
                        $("#provinces").append('<option value="' + data[i].province + '">' + data[i].province + '</option>');
                    }
                    
                }
            });
        });

        $('#provinces').change(() => {
            $('#municipality').val('default').trigger('change');
            $prov = $('#provinces').val();
            
            var options = {
                theme:"sk-rect",
                message:'Please wait.',
                backgroundColor:"#494f5f",
                textColor:"white"
            };

            HoldOn.open(options);

            $.ajax({ 
                type: 'POST',
                url: "{{ route('farmerInfoMunicipalities') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    prov: $prov
                },
                success: function(data){
                    HoldOn.close();
                    $('#municipality option:gt(0)').remove();
                    for(i = 0; i < data.length; i++){
                        $("#municipality").append('<option value="' + data[i].municipality + '">' + data[i].municipality + '</option>');
                    }data
                }
            });


        });



        $('#submit').on('click', () =>{
            $reg = $('#region').val();
            $prov = $('#provinces').val();
            $muni = $('#municipality').val();
            $rsbsa = $('#rsbsa').val();

            toBeReplaced = [];

            if($reg == 'default')
            {
                alert('Please select region.');
            }
            else if($prov == 'default')
            {
                alert('Please select province.');
            }
            else if($muni == 'default')
            {
                alert('Please select municipality.');
            }
            else{
                $("#farmers_tbl").DataTable().clear();
                $("#farmers_tbl").DataTable({
                bDestroy: true,
                autoWidth: false,
                searchHighlight: true,
                processing: true,
                serverSide: true,
                orderMulti: true,
                order: [],
                ajax: {
                    url: "{{ route('getFarmerInfo') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                    _token: "{{ csrf_token() }}",
                    reg : $reg,
                    prov : $prov,
                    muni : $muni,
                    rsbsa: $rsbsa
                    },
                },
                columns: [
                    {data : "id"},
                    {data : "is_new"},
                    {data : "claiming_prv"},
                    {data : "rsbsa_control_no"},
                    {data : "rcef_id"},
                    {data : "lastName"},
                    {data : "firstName"},
                    {data : "midName"},
                    {data : "extName"},
                    {data : "fullName"},
                    {data : "birthdate"},
                    {data : "mother_lname"},
                    {data : "mother_fname"},
                    {data : "mother_mname"},
                    {data : "mother_suffix"},
                    {data : "final_area"},
                    {data : "final_claimable"},
                    {data : "is_claimed"},
                    {data : "total_claimed"},
                    {data : "total_claimed_area"},
                    {data : "is_replacement"},
                    {data : "replacement_area"},
                    {data : "replacement_bags"},
                    {data : "replacement_bags_claimed"},
                    {data : "replacement_area_claimed"},
                    {data : "replacement_reason"},
                    {data : "is_ebinhi"},
                ],
                });
            }

        });


        
       
        </script>
@endpush
