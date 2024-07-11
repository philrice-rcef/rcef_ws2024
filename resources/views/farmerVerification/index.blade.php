<?php $qr_side = "active"; $qr_home="active"?>

@extends('layouts.index')

@section('styles')
<link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}"/>
    <link
    rel="stylesheet"
    href="{{ asset('public/assets/iCheck/skins/flat/green.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/css/daterangepicker.css') }}"/>
    <link href="public/css/HoldOn.min.css" rel="stylesheet" />
    <link
    rel="stylesheet"
    href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .shadow-sm	{box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);}
        .shadow	{box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);}
        .shadow-md	{box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);}
        .shadow-lg	{box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);}
        .shadow-xl	{box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);}
        .shadow-2xl	{box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);}
        .shadow-inner	{box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);}
        .shadow-none	{box-shadow: 0 0 #0000;}

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
        border: 2px solid #c3c6ce;
                -webkit-transition: 0.5s ease-out;
                transition: 0.5s ease-out;
                overflow: visible;
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
            padding: 10px;
            border-radius: 10px;
            background-color: #faf5f580;
            backdrop-filter: blur(5px);
    }

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

		.col-md-6 {
			width: 50%;
			float: left;
            margin-top: 10px;

		}

        .shadow {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .btn {
            display: inline-block;
            margin-top: 5px;
            margin-right: 5px;     
        }

        .boxes {
            width: 100%;
            height: 100%; 
            padding: 1em 2em;
            border-radius: 30px;
            background: #e0e0e0;
            /* background: #e0e0e0; */
               border: 2px solid #c3c6ce;
                -webkit-transition: 0.5s ease-out;
                transition: 0.5s ease-out;
                overflow: visible;
		}

        .boxes:hover {
        border-color: #3ed655;
        background: #e0e0e0;
        /* -webkit-box-shadow: 10px 5px 18px 0 rgba(255, 255, 255, 0.877);
        box-shadow: 10px 5px 18px 0 rgba(255, 255, 255, 0.877); */
        }
		.col-md-6 {
			width: 50%;
			float: left;
            margin-top: 10px;

		}

        #page
        {
            padding-inline: 0em 1.5em;
        }


        .form-field {
            margin-bottom: 1em;
        }
        .form-field label {
            display: block;
            font-weight: bold;
        }
        .form-field input {
            width: calc(100% - 1em);
            padding: 0.5em;
            margin-top: 0.2em;
        }

        .info_list
        {
            list-style-type: none;
        }

        .profiles
        {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .container {
        
        }

        .container > input {
        display: none;
        }

        .container svg {
        overflow: visible;
        }

        .path {
        fill: none;
        stroke: black;
        stroke-width: 6;
        stroke-linecap: round;
        stroke-linejoin: round;
        transition: stroke-dasharray 0.5s ease, stroke-dashoffset 0.5s ease;
        stroke-dasharray: 241 9999999;
        stroke-dashoffset: 0;
        }

        .container input:checked ~ svg .path {
        stroke-dasharray: 70.5096664428711 9999999;
        stroke-dashoffset: -262.2723388671875;
        }


       
    </style>
@endsection

@section('content')
    
<div class="clearfix" id="page">
    
    @include('layouts.message')
    
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel shadow-2xl">
                <div class="x_title">
                    <h1>Farmer Verification</h1>
                    <div class="clearfix"></div>
                </div>

                <section class="group_selector">
                    <div class="selectors" id="selectors style="display: inline-block;>
                        <div class="provinces_container selector_cards" id="containers" style="display: inline-block; margin-right: 10px;">
                            <h4>Province:</h4>
                            <select name="provinces" id="provinces">
                                <option value="default">Select Province</option>
                                @foreach($provinces as $province)
                                <option value="{{$province->province}}">{{$province->regionName}} - {{$province->province}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="municipality_container selector_cards" id="containers" style="display: inline-block;">
                            <h4>Municipality:</h4>
                            <select name="municipality" id="municipality" disabled>
                                <option value="default">Select Municipality</option>
                            </select>
                        </div>

                        <div>
                            <i style="padding-inline: 1em">*Please select province and municipality to begin verification.</i>
                        </div>
                        <div>
                            <button type="button" id='submit' class="btn btn-success submit" disabled>Submit</button> 
                            <button type="button" id="reset" class="btn btn-secondary" style="display:none">Reset</button> 
                        </div>
                            
                    </div>
                </section>
                
                <div style="padding-top: 1em">
                    <div class="col-md-4">
                        <div class="boxes shadow-md" >
                            <h1 style="font-weight: 700;">{{$totalForValidation}}</h1>
                            <hr>
                            <h4>Total records for validation</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="boxes shadow-md" >
                            <h1 style="font-weight: 700;"> 1,000</h1>
                            <hr>
                            <h4>Total records validated</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="boxes shadow-md" >
                            <h1 style="font-weight: 700;"> 1,000</h1>
                            <hr>
                            <h4>Total pending records</h4>
                        </div>
                    </div>
                </div>

                <div id="customSearch" style="display:none;">
                    <div class="col-md-3" style="padding-top: 1em">
                        <div  class="boxes shadow-md" style="text-align: center;">
                            <h1><i class="fas fa-arrow-left" style="font-size: 0.75em;"></i> 1/1,000 <i class="fas fa-arrow-right" style="font-size: 0.75em;"></i></h1>
                            <h4>Farmer Profiles</h4>
                            <hr>
                            <div class="form-field">
                                <label for="firstName">*First Name</label>
                                <input type="text" id="firstName" readonly>
                            </div>
                            <div class="form-field">
                                <label for="midName">*Middle Name</label>
                                <input type="text" id="midName" readonly>
                            </div>
                            <div class="form-field">
                                <label for="lastName">*Last Name</label>
                                <input type="text" id="lastName" readonly>
                            </div>
                            <div class="form-field">
                                <label for="extName">Ext Name</label>
                                <input type="text" id="extName">
                            </div>
                            <div class="form-field">
                                <label for="birthdate">Date of Birth</label>
                                <input type="text" id="birthdate" readonly>
                            </div>
                            <button class="custom-search-button">CUSTOM SEARCH</button>
                        </div>
                    </div>
                </div>
                
                <div id="profiles" style="display:none;">
                    
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

    $('#provinces').change(() => {
            $('#municipality').removeAttr('disabled');
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
                url: "{{ route('farmerVerification.getMuni') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    prov: $prov
                },
                success: function(data){
                    HoldOn.close();
                    $processedMun = JSON.parse(data);
                    $('#municipality option:gt(0)').remove();
                    for(i = 0; i < $processedMun.length; i++){
                        $("#municipality").append('<option value="' + $processedMun[i].geocode + '">' + $processedMun[i].municipality + '</option>');
                    }
                }
            });


        });

        $('#municipality').change(() => { 
            $mun = $('#municipality').val();
            if($mun != 'default')
            {
                $('#submit').removeAttr('disabled');
            }
            else if($mun == 'default')
            {
                $('#submit').attr('disabled', 'disabled');
            }
        });

        $('#submit').on('click', () =>{
            $prv = $('#provinces').val();
            $mun = $('#municipality').val();
            $("#profiles").empty();
            var options = {
                theme:"sk-rect",
                message:'Please wait.',
                backgroundColor:"#494f5f",
                textColor:"white"
            };

            if($prv == 'default')
            {
                alert("Please select a province.");
            }
            else if($mun == 'default')
            {
                alert("Please select municipality.");
            }
            else
            {
                // HoldOn.open(options);

            $.ajax({ 
                type: 'POST',
                url: "{{ route('farmerVerification.getProfiles') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    prov: $prov,
                    mun: $mun
                },
                success: function(data){
                    data.forEach(proc => {
                        $("#profiles").append(`
                            <div class="col-md-6" style="padding-top: 1em">
                                <div class="boxes shadow-md profiles" id="box_${proc.id}">
                                    <div style="display:flex; gap: 0.5em;">
                                        <i class="fa fa-user" aria-hidden="true" style="font-size: 8em"></i>
                                        <ul class="info_list">
                                            <li style="font-size: 1.5em; font-weight: 500;" id="profileName">${proc.firstName} ${proc.midName} ${proc.lastName} ${proc.extName}</li>
                                            <li id="rsbsa">RSBSA No.: ${proc.rsbsa_control_no}</li>
                                            <li id="sex">Sex: ${proc.sex}</li>
                                            <li id="bday">Birthdate: ${proc.birthdate}</li>
                                            <li id="mother">Mother Name: ${proc.mother_name}</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <label class="container">
                                            <input type="checkbox" class="profile-checkbox" id="${proc.id}">
                                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path"></path>
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                    $('.profile-checkbox').on('change', function() {
                    if ($(this).is(':checked')) {
                        console.log(`Checkbox with ID ${this.id} is checked`);
                        $(this).closest('.profiles').css('background-color', '#3ed655');
                        
                    } else {
                        console.log(`Checkbox with ID ${this.id} is unchecked`);
                        $(this).closest('.profiles').css('background-color', '');
                        
                    }
                });
                    // HoldOn.close();
                }
            });
                $('#customSearch').show();
                $('#profiles').show();

            }
        });


    </script>
@endpush
