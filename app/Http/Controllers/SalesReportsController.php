<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class SalesReportsController extends Controller
{
    //
    public function showSalesReport()
    {
        //Five Years Sales Report
        $five_years = array();
        $five_years[0] = Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::now()->year)->count();
        $five_years_sum = $five_years[0];
        for($ctr = 1;$ctr<5; $ctr++)
        {
            $five_years[$ctr] =  Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::now()->subYear($ctr))->count();
            $five_years_sum += $five_years[$ctr]; 
        }

        //1 Year Sales report
        $annual = array();
        $annual[0] = Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $annual_sum = $annual[0];
        for($ctr = 1;$ctr<13; $ctr++)
        {
            $annual[$ctr] = Order::where('status', '=', 'delivered')
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->whereMonth('created_at', Carbon::now()->subMonth($ctr))
                                    ->count();

            if($ctr == 12)
            {
                $annual[$ctr] = Order::where('status', '=', 'delivered')
                                    ->whereYear('created_at', Carbon::now()->subYear(1))
                                    ->whereMonth('created_at', Carbon::now()->subMonth($ctr))
                                    ->count();
            }
            $annual_sum += $annual[$ctr];

        }

        //1 month daily report
        $one_month = array();
        $one_month[0] = Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::today())->count();
        $one_month_days = Carbon::now()->daysInMonth;
        $one_month_sum = $one_month[0];

        for($ctr = 1;$ctr<$one_month_days; $ctr++)
        {
            $one_month[$ctr] = Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::now()->subDay($ctr))->count();
            $one_month_sum += $one_month[$ctr];
        }
        

        //1 week daily report
        $one_week = array();
        $one_week[0] = Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::today())->count();
        $one_week_sum = $one_week[0];
        for($ctr = 1;$ctr<7; $ctr++)
        {
            $one_week[$ctr] = Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::now()->subDay($ctr))->count();
            $one_week_sum += $one_week[$ctr];
        }
        
        //Total Sales All in All
        $total_sales= Order::where('status', '=', 'delivered')->count();

        $data = array
        (
            'five_years' =>  $five_years,
            'one_month' =>  $one_month,
            'one_week' =>  $one_week,
            'annual' =>  $annual,
            
            'five_years_sum' =>  $five_years_sum,
            'one_month_sum' =>  $one_month_sum,
            'one_week_sum' =>  $one_week_sum,
            'annual_sum' =>  $annual_sum,

            'total_sales' =>  $total_sales
        );

        return view('admin.sales')->with($data);
    }

    public function showSalesReportByDate(Request $request)
    {

        if($request->input('start_date') == '' || $request->input('end_date') == '' )
        {
            return back()->with('error', 'Start Date / End Date is Empty');
        }
        else if($request->input('start_date') < $request->input('end_date') == '' )
        {
            return back()->with('error', 'Provided Dates Invalid');
        }
        
        $start_date_data = $request->input('start_date', date('Y-m-d'));
        $end_date_data = $request->input('end_date', date('Y-m-d'));

        $start = Carbon::createFromFormat('Y-m-d', $start_date_data);
        $end = Carbon::createFromFormat('Y-m-d', $end_date_data);

        // $end_month = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('m');
        
        $year_count = $start->diffInYears($end);                  
        $months_count = $start->diffInMonths($end); 
        $days_count =  $start->diffInDays($end);
        
        $initial_format ='';

        //If days is not greater than 1 month, show daily report
        if($days_count < 31)
        {
            $requested_report_count = array();
            $requested_report_timestamp = array();
            
            $requested_report_count[0] = Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data))->count();
            $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('M d'); 

            $requested_report_sum = $requested_report_count[0];

            for($ctr = 1;$ctr<=$days_count; $ctr++)
            {
                $requested_report_count[$ctr] = Order::where('status', '=', 'delivered')
                                                ->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subDay($ctr))->count();

                $requested_report_sum +=$requested_report_count[$ctr];
                
                $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subDays($ctr)->format('M d'); 
            }
            
            $initial_format = 'daily';

        }

        //If months is greater than 1 month, show monthly report
        else if($months_count < 13)
        {

            $requested_report_count = array();
            $requested_report_timestamp = array();

            $requested_report_count[0] = Order::where('status', '=', 'delivered')
                                                ->whereYear('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                ->whereMonth('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                ->count();
            $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('M Y'); 
            

            $requested_report_sum = $requested_report_count[0];

            for($ctr = 1;$ctr<=$months_count; $ctr++)
            {
                $requested_report_count[$ctr] =  Order::where('status', '=', 'delivered')
                                                        ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->year)
                                                        ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr))
                                                        ->count();
                $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr)->format('M Y'); 

                //Get Data from 12th month from last year
                if($ctr == 12)
                {
                    $requested_report_count[$ctr] =  Order::where('status', '=', 'delivered')
                                                        ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear(1))
                                                        ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr))
                                                        ->count();
                    $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr)->format('M Y'); 
                }

                $requested_report_sum += $requested_report_count[$ctr];

            }

            $initial_format = 'monthly';
        }

        //If year is greater than 1 year, show yearly report
        else if($year_count>1)
        {
            $requested_report_count = array();
            $requested_report_timestamp = array();
            
            $requested_report_count[0] = Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data))->count();
            $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('Y'); 

            $requested_report_sum = $requested_report_count[0];

            for($ctr = 1;$ctr<=$year_count; $ctr++)
            {
                $requested_report_count[$ctr] = Order::where('status', '=', 'delivered')
                                                ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($ctr))->count();

                $requested_report_sum +=$requested_report_count[$ctr];
                
                $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($ctr)->format('Y'); 
            }
            
            $initial_format = 'yearly';
        }

        //Total Sales All in All
        $total_sales= Order::where('status', '=', 'delivered')->count();

        $data = array
        (
            'total_sales' =>  $total_sales,

            'start_date_data' =>  $start_date_data,
            'end_date_data' =>  $end_date_data,

            'start' =>  $start,
            'end' =>  $end,

            'requested_report_count' =>  $requested_report_count,
            'requested_report_timestamp' =>  $requested_report_timestamp,
            'requested_report_sum' =>  $requested_report_sum,

            'initial_format' =>  $initial_format

        );

        return view('admin.salesByDate')->with($data);
    }

    public function showSalesReportByDateFormat(Request $request)
    {
        if($request->input('start_date') == '' || $request->input('end_date') == '' )
        {
            return back()->with('error', 'Start Date / End Date is Empty');
        }
        else if($request->input('start_date') < $request->input('end_date') == '' )
        {
            return back()->with('error', 'Provided Dates Invalid');
        }

        $sort_format = $request->input('sort_format');
        $initial_format = $request->input('initial_format');

        $start_date_data = $request->input('start_date', date('Y-m-d'));
        $end_date_data = $request->input('end_date', date('Y-m-d'));

        $start = Carbon::createFromFormat('Y-m-d', $start_date_data);
        $end = Carbon::createFromFormat('Y-m-d', $end_date_data);

        $year_count = $start->diffInYears($end);                  
        $months_count = $start->diffInMonths($end); 
        $days_count =  $start->diffInDays($end);
      
        if($sort_format == 'daily')
        {
            //Verify and Continue the Next functions

            
                $requested_report_count = array();
                $requested_report_timestamp = array();
    
                $requested_report_count[0] = Order::where('status', '=', 'delivered')
                                                    ->whereYear('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->whereMonth('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->count();
                $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('M d Y'); 
                
                $requested_report_sum = $requested_report_count[0];

                for($ctr = 1;$ctr<=$days_count; $ctr++)
                {
                   
                    $requested_report_count[$ctr] =  Order::where('status', '=', 'delivered')
                                                            ->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subDay($ctr))->count();

                    $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subDays($ctr)->format('M d Y');
                   
                        
                    $requested_report_sum +=$requested_report_count[$ctr];
                    
                

            }
            

        }
        else if($sort_format == 'monthly')
        {
            //Monthly to Monthly
            if($initial_format == 'monthly')
            {
                $requested_report_count = array();
                $requested_report_timestamp = array();
    
                $requested_report_count[0] = Order::where('status', '=', 'delivered')
                                                    ->whereYear('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->whereMonth('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->count();
                $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('M Y'); 
                
    
                $requested_report_sum = $requested_report_count[0];
    
                for($ctr = 1;$ctr<=$months_count; $ctr++)
                {
                    $requested_report_count[$ctr] =  Order::where('status', '=', 'delivered')
                                                            ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->year)
                                                            ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr))
                                                            ->count();
                    $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr)->format('M Y'); 
    
                    //Get Data from 12th month from last year
                    if($ctr == 12)
                    {
                        $requested_report_count[$ctr] =  Order::where('status', '=', 'delivered')
                                                            ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear(1))
                                                            ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr))
                                                            ->count();
                        $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($ctr)->format('M Y'); 
                    }
    
                    $requested_report_sum += $requested_report_count[$ctr];
    
                }
    
            }

            //Yearly to Monthly
            else if($initial_format == 'yearly')
            {
                $requested_report_count = array();
                $requested_report_timestamp = array();
    
                $requested_report_count[0] = Order::where('status', '=', 'delivered')
                                                    ->whereYear('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->whereMonth('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->count();
                $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('M Y'); 
                
    
                $requested_report_sum = $requested_report_count[0];
    
                $year_counter = floor($months_count / 12);   
                $excess_months_counter = $months_count % 12;   
    
                $loop_counter_months = 0;
    
                $previous_data_year = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('Y');
    
                for($i = 0; $i<$year_counter; $i++)
                {
                    //If months is exactly divisible by 12
                    for($j = 0;$j<12; $j++)
                    {
                        $loop_counter_months += 1;
                        
                        $new_data_year = Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months)->format('Y');
    
                        if($previous_data_year != $new_data_year)
                        {
                            $requested_report_count[$loop_counter_months] =  Order::where('status', '=', 'delivered')
                                                                                ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($i+1))
                                                                                ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months))
                                                                                ->count();
                            $requested_report_timestamp[$loop_counter_months] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months)->format('M Y');
                        }
    
                        else
                        {
                            $requested_report_count[$loop_counter_months] =  Order::where('status', '=', 'delivered')
                                                                                ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($i))
                                                                                ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months))
                                                                                ->count();
    
                            $requested_report_timestamp[$loop_counter_months] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months)->format('M Y'); 
    
                        }
    
                        $previous_data_year =  $new_data_year;
                        
                        $requested_report_sum += $requested_report_count[$loop_counter_months];
                    }
    
                    //If months is not exactly divisible by 12
                    if($i == $year_counter-1)
                    {
                        if($excess_months_counter != 0)
                        {
                            for($j = 0;$j<$excess_months_counter; $j++)
                            {
                                $loop_counter_months += 1;
                                
                                $new_data_year = Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months)->format('Y');
            
                                if($previous_data_year != $new_data_year)
                                {
                                    $requested_report_count[$loop_counter_months] =  Order::where('status', '=', 'delivered')
                                                                                        ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($year_counter+1))
                                                                                        ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months))
                                                                                        ->count();
                                    $requested_report_timestamp[$loop_counter_months] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months)->format('M Y');
                                }
            
                                else
                                {
                                    $requested_report_count[$loop_counter_months] =  Order::where('status', '=', 'delivered')
                                                                                        ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($year_counter))
                                                                                        ->whereMonth('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months))
                                                                                        ->count();
            
                                    $requested_report_timestamp[$loop_counter_months] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subMonthNoOverflow($loop_counter_months)->format('M Y'); 
            
                                }
            
                                $previous_data_year =  $new_data_year;
                                
                                $requested_report_sum += $requested_report_count[$loop_counter_months];
                            }
                        } 
                    }
                      
                }
                
            }

            //Daily to Monthly
            else if($initial_format == 'daily')
            {
                $requested_report_count = array();
                $requested_report_timestamp = array();
    
                $requested_report_count[0] = Order::where('status', '=', 'delivered')
                                                    ->whereYear('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->whereMonth('created_at',  Carbon::createFromFormat('Y-m-d', $end_date_data))
                                                    ->count();
                $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('M Y'); 
                
    
                $requested_report_sum = $requested_report_count[0];

            }
            
        }

        else if($sort_format == 'yearly')
        {
            $requested_report_count = array();
            $requested_report_timestamp = array();
            
            $requested_report_count[0] = Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data))->count();
            $requested_report_timestamp[0] = Carbon::createFromFormat('Y-m-d', $end_date_data)->format('Y'); 

            $requested_report_sum = $requested_report_count[0];

            for($ctr = 1;$ctr<=$year_count; $ctr++)
            {
                $requested_report_count[$ctr] = Order::where('status', '=', 'delivered')
                                                ->whereYear('created_at', Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($ctr))->count();

                $requested_report_sum +=$requested_report_count[$ctr];
                
                $requested_report_timestamp[$ctr] =  Carbon::createFromFormat('Y-m-d', $end_date_data)->subYear($ctr)->format('Y'); 
            }
            
            $chart_format = 'yearly';
        }

        //Total Sales All in All
        $total_sales= Order::where('status', '=', 'delivered')->count();

        $data = array
        (
            'total_sales' =>  $total_sales,

            'start_date_data' =>  $start_date_data,
            'end_date_data' =>  $end_date_data,

            'start' =>  $start,
            'end' =>  $end,

            'requested_report_count' =>  $requested_report_count,
            'requested_report_timestamp' =>  $requested_report_timestamp,
            'requested_report_sum' =>  $requested_report_sum,

            'days_count' =>  $days_count,
            'months_count' =>  $months_count,
            'year_count' =>  $year_count,

            'initial_format' =>  $initial_format

        );

        return view('admin.salesByDate')->with($data);
    }

}
