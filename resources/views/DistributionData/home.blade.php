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
        background: #fff;
        color: black;
        position: absolute;
        border-radius: 2em;
    }


    .x_title{
			margin: 10px;
            border: 1px transparent;
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
            border: 1px transparent;
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
                <h1>Data Warehouse Extractor</h1>
                <div class="clearfix"></div>
            </div>

                <section class="group_selector">
                    <div class="selectors" id="selectors style="display: inline-block;>
                        <div class="season_container selector_cards" id="containers" > 
                            <h4>Season:</h4>
                            <select name="season" id="season" disabled>
                            <option value="default">Select season</option>
                            <option value="2024_ds">Dry Season 2024</option>
                            <option value="2023_ws">Wet Season 2023</option>
                            <option value="2023_ds">Dry Season 2023</option>
                            <option value="2022_ws">Wet Season 2022</option>
                            <option value="2022_ds">Dry Season 2022</option>
                            <option value="2021_ws">Wet Season 2021</option>
                            <option value="2021_ds">Dry Season 2021</option>
                            <option value="2020_ws">Wet Season 2020</option>
                            <option value="2020_ds">Dry Season 2020</option>
                            </select>
                        </div>

                        <div class="regions_container selector_cards" id="containers" style="display: inline-block; margin-right: 10px;">
                        <h4>Region:</h4>
                        <select class="form-select" name="region" id="region" disabled>
                            <option value="default">Select region</option>
                            @foreach(array_combine($regionNames, $regionCodes) as $name => $code)
                            <option value="{{$code}}">{{$name}}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="provinces_container selector_cards" id="containers" style="display: inline-block; margin-right: 10px;">
                        <h4>Province:</h4>
                        <select name="provinces" id="provinces" disabled>
                            <option value="default">All provinces</option>
                        </select>
                        </div>

                        <div class="municipality_container selector_cards" id="containers" style="display: inline-block;">
                        <h4>Municipality:</h4>
                        <select name="municipality" id="municipality" disabled>
                            <option value="default">All municipalities</option>
                        </select>
                        </div>

                        <div class="season_container selector_cards" id="containers" > 
                            <h4>Distribution Type:</h4>
                            <select name="distType" id="distType" disabled>
                            <option value="reg">Conventional</option>
                            <option value="bep">Binhi e-Padala</option>
                            </select>
                        </div>

                        <div>
                        <button type="button" id='submit' class="btn btn-success submit" disabled>Submit</button> 
                        <button type="button" id="reset" class="btn btn-secondary">Reset</button> 
                        <button id="download_btn" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
                        </div>                            
                    </div>
                </section>
                <br>
                <div id="distDatatable" style="display:none">
                        <table
                        class="table table-hover table-striped table-bordered"
                        id="distData_tbl" 
                        >
                        <thead>
                            <th>RSBSA Control No.</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Ext. Name</th>
                            <th>Sex</th>
                            <th>Birthdate</th>
                            <th>Province</th>
                            <th>Municipality</th>
                            <th>Registered Area</th>
                            <th>Claimed Area</th>
                            <th>Bags Claimed</th>
                            <th>Seed Variety</th>
                            <th>Category</th>
                        </thead>
                        <tbody></tbody>
                        </table>
                    </div>
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
        $('#season').select2();
        $('#distType').select2();

        $(window).on('load', function() {
            $('#region').removeAttr('disabled');
            $('#provinces').removeAttr('disabled');
            $('#municipality').removeAttr('disabled');
            $('#season').removeAttr('disabled');
            // $('#distType').removeAttr('disabled');
            $('#submit').removeAttr('disabled');
            $('#reset').removeAttr('disabled');
        });

        $('#season').change(() => {
            $('#region').val('default').trigger('change');
            $('#provinces').val('default').trigger('change');
            $('#municipality').val('default').trigger('change');
            $ssn = $('#season').val();


            if($ssn == "2023_ws"){
                $('#distType').removeAttr('disabled');

            }else{
                $('#distType').val('reg').trigger('change');
                $('#distType').attr('disabled', 'true');
            }


            $('#row').hide();
            $.ajax({ 
                type: 'POST',
                url: "{{ route('getDistributionDataReg') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data){
                    $('#region option:gt(0)').remove();
                    for(i = 0; i < data.length; i++){
                        $("#region").append('<option value="' + data[i].regCode + '">' + data[i].regionName+ '</option>');
                    }
                }
            });
            


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
                url: "{{ route('getDistributionDataPrv') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    reg: $reg,
                },
                success: function(data){
                    HoldOn.close();
                    // console.log(data);
                    $processed = data;
                    $('#provinces option:gt(0)').remove();
                    $('#municipality option:gt(0)').remove();
                    for(i = 0; i < $processed.length; i++){
                        $("#provinces").append('<option value="' + $processed[i].prv_code + '">' + $processed[i].province + '</option>');
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
                url: "{{ route('getDistributionDataMun') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    prov: $prov,
                },
                success: function(data){
                    HoldOn.close();
                    $processedMun = data;
                    $('#municipality option:gt(0)').remove();
                    for(i = 0; i < $processedMun.length; i++){
                        $("#municipality").append('<option value="' + $processedMun[i].prv + '">' + $processedMun[i].municipality + '</option>');
                    }
                }
            });


        });

        let storedData = null;


        $('#submit').on('click', () =>{
            $reg = $('#region').val();
            $prv = $('#provinces').val();
            $mun = $('#municipality').val();
            $ssn = $('#season').val();
            $distType = $('#distType').val();

            var options = {
                theme:"sk-rect",
                message:'Retrieving data. Please wait.',
                backgroundColor:"#494f5f",
                textColor:"white"
            };

            // HoldOn.open(options);
            if($ssn == 'default')
            {
                alert("Please select season");
            }
            else if($reg == 'default')
            {
                alert("Please select region");
            }
            else if($distType == 'default')
            {
                alert("Please select distribution type");
            }
            else
            {
                $("#distDatatable").show();
                $("#distData_tbl").DataTable().clear();
                        $("#distData_tbl").DataTable({
                            bDestroy: true,
                            autoWidth: false,
                            searchHighlight: true,
                            processing: true,
                            serverSide: true,
                            orderMulti: true,
                            order: [],
                            ajax: {
                                url: "{{ route('fetchDistData') }}",
                                dataType: "json",
                                type: "POST",
                                data: {
                                _token: "{{ csrf_token() }}",
                                reg: $reg,
                                prv: $prv,
                                mun: $mun,
                                ssn: $ssn,
                                distType: $distType
                                },
                            },
                            columns: [
                                { data: "ffrs_rsbsa" },
                                { data: "lastName" },
                                { data: "firstName" },
                                { data: "midName" },
                                { data: "extName" },
                                { data: "sex" },
                                { data: "birthdate" },
                                { data: "dist_province_dist" },
                                { data: "dist_municipality_dist" },
                                { data: "registered_area" },
                                { data: "claimed_area" },
                                { data: "bags_claimed" },
                                { data: "variety" },
                                { data: "category" },
                            ],
                        });
            }
        });

        
        $("#download_btn").on("click", function(e){
            var reg = $('#region').val();
            var prv = $('#provinces').val();
            var mun = $('#municipality').val();
            var ssn = $('#season').val();
            var distType = $('#distType').val();
            if(mun == "default" && prv != "default" && reg != "default"){
                url = `https://rcef-seed.philrice.gov.ph/rcef_ds2024/public/data_warehouse/${ssn}/${distType}/${reg}/${ssn}_${distType}_${reg}_${prv}_${mun}.xlsx`;
                window.open(url, "_blank");
            }else if(mun == "default" && prv == "default" && reg != "default"){
                url = `https://rcef-seed.philrice.gov.ph/rcef_ds2024/public/data_warehouse/${ssn}/${distType}/${reg}/${ssn}_${distType}_${reg}_${prv}_${mun}.xlsx`;
                window.open(url, "_blank");
            }else{
                var url = '{{ route("exportDistData", ["reg" => ":reg", "prv" => ":prv", "mun" => ":mun", "ssn" => ":ssn", "typ" => ":typ"]) }}';
                url = url.replace(':reg', reg).replace(':prv', prv).replace(':mun', mun).replace(':ssn', ssn).replace(':typ', distType);
                window.open(url);
            }
        });
        
        function resetDropdowns() {
            $('#region').val('default').trigger('change');
            $('#provinces').val('default').trigger('change');
            $('#municipality').val('default').trigger('change');
            $('#distType').val('default').trigger('change');
            $('#season').val($('#season option:first-child').val()).trigger('change');
            $('#distDatatable').hide();
        }
        
        $('#reset').click(resetDropdowns);
        
        </script>
@endpush
