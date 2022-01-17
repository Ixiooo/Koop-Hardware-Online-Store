@extends('layouts.adminApp')
@section('scripts')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
    <script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    
@endsection
@section('styles')

    <style>

        /* Card CSS */

        .admin_cards{
            transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
            cursor: pointer;
        }

        .admin_cards:hover{
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
        }

        /* Card Contents CSS */

        .label{
            color: black;
        }

        .value{
            text-align: center;
            display: block;
            color: black;
        }

        .icon{
            color: #4b922d;
        }

        .money{
            text-align: center;
            display: block;
            font-size: 24px;
            font-weight: 400;
            color: black;
        }

        /* Recent Orders CSS */

        .recent_orders_table thead tr, .recent_orders_table tbody tr{
            text-align: center;
        }

        .recent_orders_table tbody tr td a{
            text-decoration: none;
            color: #5c5c5c;
        }

        .recent_orders_table tbody tr td a:hover{
            text-decoration: none;
            color: black;
        }

		/* Text in Body */
		.body-text{
			font-family: 'Roboto', sans-serif;
			font-weight: 400;
			font-size: 14px;
		}

		/* Info Cards Footer */
		.body-text-thin{
			font-family: 'Roboto', sans-serif;
			font-weight: 300;
			font-size: 14px;
		}

		/* Form Label */
		.body-text-thick{
			font-family: 'Roboto', sans-serif;
			font-weight: 500;
			font-size: 14px;
		}

		/* Info Card Numbers */
		.card-number-text{
			font-family: 'Roboto', sans-serif;
			font-weight: 400;
			font-size: 32px;
		}

		/* Info Card Text */
		.card-heading-text{
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 18px;
		}

        /* Card Title */
		.card-heading{
			font-family: 'Montserrat', sans-serif;
			font-weight: 400;
			font-size: 18px;
		}

        #notif_icon:hover{
            text-decoration: none;
            color: #16AFED;
        }

        .report-header-text{
            color: #FD0302;
			font-family: 'Roboto', sans-serif;
			font-weight: 500;
			font-size: 24px;
		}

        .report-header-text-smaller{
            color: #FD0302;
			font-family: 'Roboto', sans-serif;
			font-weight: 500;
			font-size: 18px;
		}

    </style>
    
@endsection

@section('content')

    @php
        // echo '<pre>'; print_r($one_week_sum); echo '</pre>';

        //Six Months
        $five_years_dataPoints = array();
        //Assign data from database to datapoints in the graph
        for ($i =0; $i < count($five_years); $i++) 
        { 
            $five_years_dataPoints[$i] = array("y" => $five_years[$i], "label" =>date('Y', strtotime("-".$i." year")));
        }
        $five_years_dataPoints = array_reverse($five_years_dataPoints, false);

        //1 Year
        $annual_dataPoints = array();
        //Assign data from database to datapoints in the graph
        for ($i =0; $i < count($annual); $i++) 
        { 
            $annual_dataPoints[$i] = array("y" => $annual[$i], "label" =>date('M Y', strtotime("-".$i." month")));
        }
        $annual_dataPoints = array_reverse($annual_dataPoints, false);
        
        //1 Month
        $one_month_dataPoints = array();
        //Assign data from database to datapoints in the graph
        for ($i =0; $i < count($one_month); $i++) 
        { 
            $one_month_dataPoints[$i] = array("y" => $one_month[$i], "label" =>date('M d', strtotime("-".$i." day")));
        }
        $one_month_dataPoints = array_reverse($one_month_dataPoints, false);

        //1 week
        $weekly_dataPoints = array();
        //Assign data from database to datapoints in the graph
        for ($i =0; $i < count($one_week); $i++) 
        { 
            $weekly_dataPoints[$i] = array("y" => $one_week[$i], "label" =>date('M d', strtotime("-".$i." day")));
        }
        $weekly_dataPoints = array_reverse($weekly_dataPoints, false);

    @endphp

    {{-- Breadcrumbs --}}
    <div class="row breadcrumbs_row">
        <div class="col-md-6 col-12 align-self-center breadcrumb_col">
            <h3 class="text-themecolor mb-0">Sales Reports</h3>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a href="/admin/dashboard">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Sales Reports</li>
            </ol>
        </div>

        {{-- Registered Accounts Col--}}
        <div class="col-md-6 col-12">
            <div class="row">
                <div class="col my-auto pr-0">
                    <span class="value card-number-text text-right">
                        @if (!empty($total_sales)){{$total_sales}}
                        @else 0
                        @endif
                    </span>
                </div>
                <div class="col my-auto">
                    <i class="fas fa-chart-line fa-3x icon text-left"></i>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <span class="label body-text"> Total Completed Order(s)</span> 
                </div>
            </div>
        </div>
    </div>

    {{-- Show Orders by Date --}}
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <div class="card bg-white text-dark h-100">
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row">
                        <div class="col-lg-4 col-12 my-auto">
                            <h5 class="report-header-text">Show Order Report by Date</h5>
                        </div>
                        <div class="col-lg-8 col-12 ml-auto">
                            {!! Form::open([ 'route' => ['admin.showSalesReportByDate'], 'method' => 'get' ]) !!}
                                <div class="form-row justify-content-end">
                                    <div class="col-6 col-md-auto">
                                        <label for="start_date">Start Date</label>
                                        {{ Form::date('start_date', '', [ 'class'=>'form-control', 'id' => 'start_date', 'placeholder' => 'Start Date' ]) }}
                                    </div>
                                    <div class="col-6 col-md-auto">
                                        <label for="end_date">End Date</label>
                                        <div class="input-group mb-2">
                                            {{ Form::date('end_date', '', [ 'class'=>'form-control', 'id' => 'end_date', 'placeholder' => 'End Date' ]) }}
                                        </div>
                                    </div>			    
                                    <div class="col-12 col-md-auto text-right mt-auto">
                                        <button type="submit" class="btn page-btn mb-2">Submit</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
			
		</div>
    </div>

    <div class="row">
        {{-- Weekly Report --}}
        <div class="col-12 col-lg-6 mb-3">
            <div class="card bg-white text-dark h-100">
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row">
                        <div class="col-8 mb-2">
                            <h5 class="card-title report-header-text">1 Week Order Report</h5>
                        </div>
                        <div class="col float-right align-self-center">
                            <h5 class="report-header-text-smaller text-right">{{$one_week_sum}} Order(s)</h5>
                        </div>
                    </div>
                    <div class="row mx-3">
                        <div id="weeklyChart" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <button class="body-text-thin btn page-btn py-1 my-0" id="dl_weekly_chart">
                        <span class="ms-auto">
                            <i class="fas fa-file-download"></i>
                        </span>
                        Download as CSV (Excel File)
                    </button>
                </div>
            </div>
        </div>

        {{-- Monthly Report --}}
        <div class="col-12 col-lg-6 mb-3">
            <div class="card bg-white text-dark h-100">
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row">
                        <div class="col-8 mb-2">
                            <h5 class="card-title report-header-text">1 Month Order Report</h5>
                        </div>
                        <div class="col float-right align-self-center">
                            <h5 class="report-header-text-smaller text-right">{{$one_month_sum}} Order(s)</h5>
                        </div>
                    </div>
                    <div class="row mx-3">
                        <div id="monthlyChart" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <button class="body-text-thin btn page-btn py-1 my-0" id="dl_one_month_chart">
                        <span class="ms-auto">
                            <i class="fas fa-file-download"></i>
                        </span>
                        Download as CSV (Excel File)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- 12 Months Report --}}
        <div class="col-12 col-lg-6 mb-3">
            <div class="card bg-white text-dark h-100">
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row">
                        <div class="col-8  mb-2">
                            <h5 class="card-title report-header-text">12 Months Order Report</h5>
                        </div>
                        <div class="col float-right align-self-center">
                            <h5 class="report-header-text-smaller text-right">{{$annual_sum}} Order(s)</h5>
                        </div>
                    </div>
                    <div class="row mx-3">
                        <div id="annualChart" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <button class="body-text-thin btn page-btn py-1 my-0" id="dl_12_month_chart">
                        <span class="ms-auto">
                            <i class="fas fa-file-download"></i>
                        </span>
                        Download as CSV (Excel File)
                    </button>
                </div>
            </div>
        </div>

        {{-- Five Years Report --}}
        <div class="col-12 col-lg-6 mb-3">
            <div class="card bg-white text-dark h-100">
                <div class="card-body my-0 px-3 pb-1">
                    <div class="row">
                        <div class="col-8  mb-2">
                            <h5 class="card-title report-header-text">Five Years Order Report</h5>
                        </div>
                        <div class="col float-right align-self-center">
                            <h5 class="report-header-text-smaller text-right">{{$five_years_sum}} Order(s)</h5>
                        </div>
                    </div>
                    <div class="row mx-3">
                        <div id="sixMonthsChart" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <button class="body-text-thin btn page-btn py-1 my-0" id="dl_five_years_chart">
                        <span class="ms-auto">
                            <i class="fas fa-file-download"></i>
                        </span>
                        Download as CSV (Excel File)
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('post-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script>


        function load_chart()
        {
            var five_years_chart = new CanvasJS.Chart("sixMonthsChart", {
                animationEnabled: true,
                zoomEnabled: true,
                exportEnabled: true,
                theme: "light2",
                title:{
                    text: "Five Years Sales"
                },
                axisY: {
                    title: "Order Count"
                },
                data: [{
                    type: "area",
                    yValueFormatString: "0 Order(s)",
                    dataPoints: <?php echo json_encode($five_years_dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            five_years_chart.render();

            var annual_chart = new CanvasJS.Chart("annualChart", {
                animationEnabled: true,
                zoomEnabled: true,
                exportEnabled: true,
                theme: "light2",
                title:{
                    text: "12 Months Sales"
                },
                axisY: {
                    title: "Order Count"
                },
                data: [{
                    type: "area",
                    yValueFormatString: "0 Order(s)",
                    dataPoints: <?php echo json_encode($annual_dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            annual_chart.render();
            
            var monthly_chart = new CanvasJS.Chart("monthlyChart", {
                animationEnabled: true,
                zoomEnabled: true,
                exportEnabled: true,
                theme: "light2",
                title:{
                    text: "1 Month Sales"
                },
                axisY: {
                    title: "Order Count"
                },
                data: [{
                    type: "area",
                    yValueFormatString: "0 Order(s)",
                    dataPoints: <?php echo json_encode($one_month_dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            monthly_chart.render();
            
            var weekly_chart = new CanvasJS.Chart("weeklyChart", {
                animationEnabled: true,
                zoomEnabled: true,
                exportEnabled: true,
                theme: "light2",
                title:{
                    text: "1 Week Sales"
                },
                axisY: {
                    title: "Order Count"
                },
                data: [{
                    type: "area",
                    yValueFormatString: "0 Order(s)",
                    dataPoints: <?php echo json_encode($weekly_dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            weekly_chart.render();

            
            document.getElementById("dl_weekly_chart").addEventListener("click", function(){
                downloadCSV({ filename: "weekly-chart-data.csv", chart: weekly_chart })
            });

            document.getElementById("dl_one_month_chart").addEventListener("click", function(){
                downloadCSV({ filename: "one-month-chart-data.csv", chart: monthly_chart })
            });

            document.getElementById("dl_12_month_chart").addEventListener("click", function(){
                downloadCSV({ filename: "12-months-chart-data.csv", chart: annual_chart })
            });

            document.getElementById("dl_five_years_chart").addEventListener("click", function(){
                downloadCSV({ filename: "five-years-chart-data.csv", chart: five_years_chart })
            });
        }

        function limit_date()
        {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            if(dd<10)
            {
                dd='0'+dd
            } 
            if(mm<10)
            {
                mm='0'+mm
            } 

            today = yyyy+'-'+mm+'-'+dd;
            document.getElementById("end_date").setAttribute("max", today);
            document.getElementById("start_date").setAttribute("max", today);

        }

        function convertChartDataToCSV(args) {  
            var result, ctr, keys, columnDelimiter, lineDelimiter, data;

            data = args.data || null;
            if (data == null || !data.length) {
                return null;
            }

            columnDelimiter = args.columnDelimiter || ',';
            lineDelimiter = args.lineDelimiter || '\n';

            keys = Object.keys(data[0]);

            result = '';
            result += keys.join(columnDelimiter);
            result += lineDelimiter;

            data.forEach(function(item) {
                ctr = 0;
                keys.forEach(function(key) {
                if (ctr > 0) result += columnDelimiter;
                result += item[key];
                ctr++;
                });
                result += lineDelimiter;
            });
            return result;
        }

        function downloadCSV(args) {
            var data, filename, link;
            var csv = "";
            for(var i = 0; i < args.chart.options.data.length; i++){
                csv += convertChartDataToCSV({
                data: args.chart.options.data[i].dataPoints
                });
            }
            if (csv == null) return;

            filename = args.filename || 'chart-data.csv';

            if (!csv.match(/^data:text\/csv/i)) {
                csv = 'data:text/csv;charset=utf-8,' + csv;
            }
            
            data = encodeURI(csv);
            link = document.createElement('a');
            link.setAttribute('href', data);
            link.setAttribute('download', filename);
            document.body.appendChild(link); // Required for FF
                link.click(); 
                document.body.removeChild(link);   
        }

        //Registersw
        function register_sw()
        {
            navigator.serviceWorker.register('/sw.js');
        }

        //Show Notification
        function showNotification(message)
        {
            // const notification = new Notification ("Koop Hardware Online Store",
            // {
            //     icon: '/storage/logo/icon.png',
            //     body: message
            // });

            // notification.onclick = (e) => 
            // {
            //     window.location.href = "/admin/orders/ordered"
            // }
            
            
            navigator.serviceWorker.getRegistration().then( function( registration )
            {
                
                //Display Notification
                registration.showNotification
                ( 
                    "Koop Hardware Online Store",
                    {
                        icon: '/storage/logo/icon.png',
                        badge:'/storage/logo/icon.png',
                        body:message
                    } 
                );
            } );
            
            
        }

        //Ask for Notification Permissions
        function ask_notif_permission()
        {
            if(Notification.permission !== 'granted')
            {
                Notification.requestPermission();
            }
        }

        //Realtime Refresh and Notification in Admin Dashboard
        function realtime_notif()
		{
            
			var pusher = new Pusher('03527b096d7dc99cecc1', {
				cluster: 'ap1'
			});

			var channel = pusher.subscribe('admin-channel');
			channel.bind('order-placed-event', function(data) {
                
                //Desktop Push Notif
                if(Notification.permission == 'granted')
                {   
                    showNotification(data.message['text']);
                }

			});
		}

        $(document).ready(function(){

            register_sw();

            ask_notif_permission();
            realtime_notif();

            limit_date();
            load_chart();
            
        });

    </script>

@endsection