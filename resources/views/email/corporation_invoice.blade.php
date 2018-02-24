<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Locum Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="style.css" media="all"/>
    <!-- <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 100%;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo1 {
            margin-top: 15px;
            width: 33%;
            float: left;
            text-align: left;
            margin-bottom: 10px;
        }

        #logo2 {
            margin-top: 15px;
            width: 33%;
            float: left;
            text-align: center;
            margin-bottom: 10px;
        }

        #logo2 img {
            text-align: center;
        }

        #logo3 {
            margin-top: 15px;
            width: 33%;
            float: left;
            text-align: right;
            margin-bottom: 10px;
        }


        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            position: relative;
            left: -10px;
            float: right;
            text-align: left;
        }

        #company span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style> -->
    <style>
    body {
        background-image: url("/img/invoice-image.png");
        background-size: 5% 80%;
        background-position: center;
        background-repeat: no-repeat;
    }
    .header {
        margin-top: 40px;
    }
    .header p {
        color: #585858;
        font-size: 16px;
    }
    .invoice {
        background-color: #7d97ad;
        height: 70px;
        margin-top: 80px;
    }
    .invoice h3 {
        /*height: 30px;
        line-height: 30px;*/
        color: #fff;
    }
    .invoice label {
        color: #7d97ad;
        margin-top: 30px;
        font-size: 16px;
    }
    .invoice p {
        color: #585858;
        font-size: 16px;
    }
    td {
        color: #585858;
        font-size: 13px;
    }
    thead {
        background-color: #7d97ad;
        color: #fff;
    }
    .footer p {
        color: #585858;
        font-size: 16px;
    }
    .footer label {
        color: #7d97ad;
        font-size: 16px;
    }
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    .invoice-date {
        background: red;
    }
    .invoice-number {
        float: left;
    }
    .pay-method {
        margin-top: 20px;
    }
    .practice-info {
        float:left;
    }
    .payment-method-preferred {
        float: right;
    }
    .practice-info-and-method-pay {
        /*margin-top: 45px;*/
        border-top: 1px solid #7d97ad;;
    }
    .table {
        width: 100%;
    }
    .footer-table {
        width: 50%;
        float: right;
    }
</style>
</head>
<body>
<div class="container">
            <div class="header">
                <p>{{$corporation->name}}</p>
                <p><b>Email: {{$corporation->email}}</b></p>
            </div>
            <div class="content">
                <div class="">
                    <div class="invoice">
                        <h3 class="invoice-number" style="padding-left: 20px; padding-top: 20px;">INVOICE </h3>
                        <h3 class="payment-method-preferred" style="padding-right: 20px;">{{date('d/m/Y')}}</h3>
                    </div>
                    <div class="pay-method" style="height: 40px;">
                        <div>
                            <label class="practice-info" style="padding-left: 20px; color: #7d97ad;">BILL TO</label>
                        </div>
                        <div>
                            <label class="payment-method-preferred" style="padding-right: 20px; color: #7d97ad;">PREFERRED PAYMENT METHOD</label>
                        </div>
                    </div>
                    <div class="practice-info-and-method-pay">
                        <div class="practice-info">

                            <p style="padding-left: 20px;">{{$corporation->name}}</p>
                            <p style="padding-left: 20px;"> {{$corporation->email}}</p>
                            
                        </div>
                        <div class="payment-method-preferred">
                            <p style="padding-right: 20px;">PREFERRED PAYMENT METHOD</p>
                        </div>
                    </div>
                </div>
                
                <div style="padding-top: 150px;">
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>TIME</th>
                                    <th>RATE</th>
                                    <th>DAYS/REVENUE</th>
                                    <th>SUBTOTAL</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $subtotal = 0 ;?>
                            <?php $total = 0; ?>
                            @foreach ($jobs as $job)
                                <tr>
                                    <td>{{date('d/m', strtotime($invoice->created_at))}}-{{$newDate = date('d/m', strtotime($invoice->created_at->addDays(\App\Helpers\Constant::PAYMENT_TERMS)))}}
                                    </td>
                                    @if($job->day_rate && $job->day_rate!='')
                                        <td>{{ $job->day_rate }}</td>
                                        <td>{{ $job->totalDays }}</td>
                                        <?php $subtotal = $subtotal + ($job->day_rate * $job->totalDays); ?>
                                        <td>{{ $job->day_rate * $job->totalDays }} </td>
                                        <?php $total = $total +  ($job->day_rate * $job->totalDays * (5 / 100)) + ($job->day_rate * $job->totalDays);?>
                                        <td>{{ ($job->day_rate * $job->totalDays * (5 / 100)) + ($job->day_rate * $job->totalDays) }}</td>
                                    @else
                                        <td>{{ $job->percentage }}%</td>
                                        <td>${{ $job->locumTotal }}</td>
                                        <?php $subtotal = $subtotal + ($job->locumTotal * ($job->percentage / 100)); ?>
                                        <td>${{ $job->locumTotal * ($job->percentage / 100) }} </td>
                                        <?php $total = $total +  (($job->locumTotal * ($job->percentage / 100)) + $job->locumTotal );?>
                                        <td>{{ ($job->locumTotal * ($job->percentage / 100)) + $job->locumTotal }}</td>
                                    @endif
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="width: 400px; float: right;">
            
                @if($job->day_rate && $job->day_rate!='')
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 250px; color: #7d97ad;">SUBTOTAL</p>
                        <p style="float: right; width: 150px; margin-left: 700px;">${{ $subtotal }}</p>
                    </div>
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 300px; color: #7d97ad;">SALES TAX</p>
                        <?php $tax =  ($subtotal * (5 / 100)) ?>
                        <p style="float: right; width: 100px;">${{ $tax }}</p>
                    </div>
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 300px; color: #7d97ad;">TOTAL</p>
                        <p style="float: right; width: 100px;">${{ $total + $tax }}</p>
                    </div>
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 300px; color: #7d97ad;">DUE IN 15 DAYS</p>
                        <p style="float: right; width: 100px;"></p>
                    </div>
                @else
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 300px; color: #7d97ad;">SUBTOTAL</p>
                        <p style="float: right; width: 100px; margin-top: 0px;">${{ $subtotal }}</p>
                    </div>
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 300px; color: #7d97ad;">SALES TAX</p>
                        <?php $tax =  ($subtotal * (5 / 100)) ?>
                        <p style="float: right; width: 100px; margin-top: 0px;">${{ $tax }}</p>
                    </div>
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 300px; color: #7d97ad;">TOTAL</p>
                        <p style="float: right; width: 100px; margin-top: 0px;">${{ $total + $tax}}</p>
                    </div>
                    <div style="width: 400px; height: 30px; border-bottom: 1px solid #ccc;">
                        <p style="float: left; width: 300px; color: #7d97ad;">DUE IN 15 DAYS</p>
                        <p style="float: right; width: 100px; margin-top: 0px;"></p>
                    </div>
                @endif
                <p style="margin-top: 30px;">Thank you for your business!</p>
            </div>
        </div>
<!-- <header class="clearfix">
    <div id="logo1">
        <img src="{{ url('/img/watermark-locum.png') }}">
    </div>
    <div id="logo2">
        <img src="{{ url('/img/logo.png') }}">
    </div>
    <div id="logo3">
        <img src="{{ url('/img/watermark-locum.png') }}">
    </div>
    <h1>LocumOD Invoice</h1>
    <div style="padding: 0px 20px;">
        <div id="company" class="clearfix">
            <div><span>Corporation</span>{{$corporation->name}}</div>

            <div><span>EMAIL</span><a href="mailto:{{$corporation->email}}">{{$corporation->email}}</a>
            </div>
        </div>
        <div id="project">

        </div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service">JOB ID</th>
            <th class="desc">DESCRIPTION</th>
            {{-- @if percentage --}}
            <th class="desc">PERCENTAGE</th>
            <th class="desc">AVERAGE DAILY INCOME</th>
            {{--  @endif --}}
            <th class="desc">DAY RATE</th>
            <th class="desc">DAYS</th>
            <th style="text-align: right">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <?php $grand_total=0?>
        @foreach ($jobs as $job)
            <tr>
                <td class="service">#{{ $job->id }}</td>
                <td class="desc">Paying for services</td>
                @if($job->percentage != NULL || $job->percentage != 0)
                    <td class="desc">{{$job->percentage}}%</td>
                @else()
                    <td class="desc"></td>
                @endif
                @if(isset($job->day_rate))
                    <td class="desc">${{$job->day_rate}}</td>
                @else
                    <td class="desc">${{  number_format( ($job->locumTotal / $job->totalDays), 2 )}}</td>
                @endif
                @if(isset($job->day_rate) && $job->day_rate != 0)
                    <td class="desc">${{ $job->day_rate}}</td>
                @else
                    <td class="desc"></td>
                @endif
                <td class="desc">{{$job->totalDays}}</td>

                @if(isset($job->day_rate))
                    <td class="total">${{$job->total}}</td>
					<?php $grand_total += $job->total?>
                @else
                    <td class="total">${{$job->locumTotal}}</td>
        			<?php $grand_total += $job->locumTotal?>
                @endif

        @endforeach
        <tr>
            <td colspan="6">LocumOD</td>
            <td class="total">$15</td>
        </tr>
        <tr>
            <td colspan="6">GRAND TOTAL</td>
            @if(isset($job->day_rate))
                <td class="total">${{15 +$grand_total}}</td>
            @else
                <td class="total">${{15 +$grand_total}}</td>
            @endif
        </tr>

        </tbody>
    </table>
</main>
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer> -->
</body>
</html>