<!DOCTYPE html>
<html lang="en" dir="ltr">
    <style type="text/css">
        * {
          font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        }
        .title{
            font-size: 18px;
            width: 100%;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 70px;
        }
        .header-title{
            font-weight: bold;
            letter-spacing: 2px;
        }
        .header-data2{
            letter-spacing: 1px;
        }
        .table-head{
            border: black 1px solid;
            text-align: center;
            font-weight: bold;
            padding: 5px;
        }
        .table-data{
            border: black 1px solid;
            text-align: left;
            padding: 5px;
        }
        .c1{
            width: 35%
        }
        .c2{
            width: 35%
        }
        .c3{
            width: 30%;
            text-align: right;
            padding-right: 10px;
        }
		.ds-logo-right{
           position: absolute;
           top: 10px; 
           right: 30px;
        }
        .ds-logo-left{
            position: absolute;
            top: -10px; 
            left: 30px;
        }
        .logo1{
            width: 100px;
            height: auto;
        }
    </style>
    <body>
    <div class="ds-logo-left"><img 
        src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/rcef/public/images/DA-Logo.png' ?>" 
        alt="" class="logo1">
    </div>
    <div class="ds-logo-right"><img 
        src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/rcef/public/images/Socotec-Logo.png' ?>" 
        alt="" class="logo1">
    </div>
        <div class="title">
            DELIVERY SCHEDULE
        </div>
        <div>
            <span class="header-title">Cooperative Name : </span>
            <span class="header-data2">{{ $coopName }}</span>
        </div>
        <div>
            <span class="header-title">Province : </span>
            <span class="header-data2">{{$province}}</span>
        </div>
        <div>
            <span class="header-title">Municipality : </span>
            <span class="header-data2">{{$municipality}}</span>
        </div>
        <div>
            <span class="header-title">Drop-off Point : </span>
            <span class="header-data2">{{$dop}}</span>
        </div>
        <div>
            <span class="header-title">Delivery Date : </span>
            <span class="header-data2">{{$date}}</span>
        </div>
        <div>
            <span class="header-title">Batch Ticket Number : </span>
            <span class="header-data2">{{$ticket}}</span>
        </div>

        


        <table cellspacing="0" style="width:100%;margin-top:20px;">
            <tr>
                <td class="table-head c1">Variety</td>
                <td class="table-head c2">Seed Tag</td>
                <td class="table-head c3">No. of Bags (20kg/bag)</td>
            </tr>
        </table>
        <table cellspacing="0" style="width:100%;margin-top: 2px;">
            {{ $variety = null }} {{ $total = 0 }}
            @foreach($delivery as $key => $dv)
            {{$total = $total + $dv->totalBagCount}}
            @if($variety == null or $variety != $dv->seedVariety)
            <tr>
                <td class="table-data c1">&nbsp;</td>
                <td class="table-data c2">&nbsp;</td>
                <td class="table-data c3">&nbsp;</td>
            </tr>
            @endif
            <tr>
                <td class="table-data c1">{{$dv->seedVariety}}</td>
                <td class="table-data c2">{{$dv->seedTag}}</td>
                <td class="table-data c3">{{$dv->totalBagCount}}</td>
            </tr>
            {{ $variety = $dv->seedVariety }}
            @endforeach
            <tr>
                <td class="table-data c1">&nbsp;</td>
                <td class="table-data c2">&nbsp;</td>
                <td class="table-data c3">&nbsp;</td>
            </tr>
        </table>
        <table cellspacing="0" style="width:100%;">
            <tr>
                <td class="table-data" colspan="2" style="width:70%;">TOTAL EXPECTED DELIVERY (in bags of 20 kg)</td>
                <td class="table-data c3"> {{ $total }} </td>
            </tr>
        </table>
    </body>
</html>
