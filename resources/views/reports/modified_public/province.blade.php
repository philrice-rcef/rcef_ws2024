<?php $qr_side = "active"; $qr_home="active"?>

@extends('layouts.index')

@section('styles')
  <link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/iCheck/skins/flat/green.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/daterangepicker.css') }}">
  <style>
    ul.parsley-errors-list {
        list-style: none;
        color: red;
        padding-left: 0;
        display: none !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 5px;
        right: 1px;
        width: 20px;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #a7acb5;
        color: black;
    }
    .x_content {
        padding: 0 5px 6px;
        float: left;
        clear: both;
        margin-top: 0; 
    }
  </style>
@endsection

@section('content')

    <div class="clearfix"></div>

    @include('layouts.message')

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="alert alert-warning alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong><i class="fa fa-info-circle"></i> Notice!</strong> This is a scheduled report, please note that the values displayed based on live data are <b><u>updated everyday @ 12 MN</u></b> to eliminate or minimize loading time.
        </div>

        <!-- FILTER PANEL -->
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    1). Select a Region
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content form-horizontal form-label-left">
                <div class="row">
                    <div class="col-md-8">
                        <select name="region" id="region" class="form-control">
                            <option value="0">Please select a region</option>
                            @foreach ($region_list as $row)
                                <option value="{{$row->region}}">{{$row->region}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-success form-control" id="load_report_btn"><i class="fa fa-database"></i> LOAD PROVINCIAL REPORT</button>
                    </div>
                </div>
            </div>
        </div><br>
        <!-- FILTER PANEL -->

        <!-- distribution details -->
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    2). Provincial Report
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content form-horizontal form-label-left">
                <table class="table table-hover table-striped table-bordered" id="province_tbl">
                    <thead>
                        <th style="width:150px;">Province</th>
                        <th>Total beneficiaries</th>
                        <th>Estimated Area Planted (ha)</th>
                        <th>Bags distributed (20kg/bag)</th>
                        <th>Total male</th>
                        <th>Total female</th>
                    </thead>
                </table>
            </div>
        </div><br>
        <!-- /distribution details -->
    </div>

@endsection()

@push('scripts')
    <script src=" {{ asset('public/js/jquery.inputmask.bundle.js') }} "></script>
    <script src=" {{ asset('public/js/select2.min.js') }} "></script>
    <script src=" {{ asset('public/js/parsely.js') }} "></script>
    <script src=" {{ asset('public/assets/iCheck/icheck.min.js') }} "></script>
    <script src=" {{ asset('public/js/daterangepicker.js') }} "></script>

    <script>
        $("#province_tbl").DataTable(); 
        $("#load_report_btn").on("click", function(e){
            var region = $("#region").val();

            $('#province_tbl').DataTable().clear();
            $("#province_tbl").DataTable({
                "bDestroy": true,
                "autoWidth": false,
                "searchHighlight": true,
                "processing": true,
                "serverSide": true,
                "orderMulti": true,
                "order": [],
                "ajax": {
                    "url": "{{ route('generate.province.report') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                        "_token": "{{ csrf_token() }}",
                        region: region
                    }
                },
                "columns":[
                    {"data": "province"},
                    {"data": "total_beneficiaries"},
                    {"data": "total_registered_area"},
                    {"data": "total_bags_distributed"},
                    {"data": "total_male_count"},
                    {"data": "total_female_count"}
                ]
            });
        });
        

        $("#excel_btn").on("click", function(e){
            $("#excel_btn").empty().html('<i class="fa fa-cog fa-spin"></i> Exporting data to Excel...');
            $("#excel_btn").attr('disabled', '');

            $.ajax({
                type: 'POST',
                url: "{{ route('rcef.report.excel') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    excel_type: 'provincial'
                },
                success: function (response, textStatus, request) {
                    var a = document.createElement("a");
                    a.href = response.file; 
                    a.download = response.name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();

                    $("#excel_btn").removeAttr('disabled');
                    $("#excel_btn").empty().html('Export to Excel (Statistics)');
                }
            });
        });
    </script>
@endpush
