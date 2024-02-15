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

        <!-- FILTER PANEL -->
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Select a Seed Cooperative
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content form-horizontal form-label-left">
                <div class="row">
                    <div class="col-md-9">
                        <select name="coop" id="coop" class="form-control">
                            <option value="0">Please select a seed cooperative</option>
                            @foreach ($coop_list as $row)
                                <option value="{{$row->accreditation_no}}">{{$row->coopName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success form-control" id="load_btn"><i class="fa fa-group"></i> LOAD SEED COOP MEMBERS</button>
                    </div>
                </div>
            </div>
        </div><br>
        <!-- FILTER PANEL -->        

    </div>

@endsection()

@push('scripts')
    <script src=" {{ asset('public/js/jquery.inputmask.bundle.js') }} "></script>
    <script src=" {{ asset('public/js/select2.min.js') }} "></script>
    <script src=" {{ asset('public/js/parsely.js') }} "></script>
    <script src=" {{ asset('public/assets/iCheck/icheck.min.js') }} "></script>
    <script src=" {{ asset('public/js/daterangepicker.js') }} "></script>\
    <script src=" {{ asset('public/js/Chart.bundle.js') }} "></script>

    <script>
        $("#sg_table").DataTable();

        $("#load_btn").on("click", function(e){
            var coop_accre = $("#coop").val();
            $('#sg_table').DataTable().clear();
            $("#sg_table").DataTable({
                "bDestroy": true,
                "autoWidth": false,
                "searchHighlight": true,
                "processing": true,
                "serverSide": true,
                "orderMulti": true,
                "order": [],
                "ajax": {
                    "url": "{{ route('load.coop.members') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                        "_token": "{{ csrf_token() }}",
                        coop_accre: coop_accre
                    }
                },
                "columns":[
                    {"data": "sg_name"}
                ]
            });
        });
        
    </script>
@endpush
