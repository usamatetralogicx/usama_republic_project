<?php
$confirmed_dates_array = array();
if (!empty($confirmed_sales_data)) {
    foreach ($confirmed_sales_data as $s) {
        $date = new \DateTime($s->order_date);
        $date_no = $date->format('d');
        $date_name = $date->format('Y-m-d');
        $confirmed_dates_array[$date_no] = $date_name;
    }
}
$confirmed_sales_array = array();
if (!empty($confirmed_dates_array)) {
    foreach ($confirmed_dates_array as $index => $d) {
        $date = new \DateTime($d);
        $total_sales = $confirmed->where('order_date', $date->format('Y-m-d'))->sum('order_total');
        $confirmed_sales_array[$index] = $total_sales;
    }
}
$dates = array();
$values = array();
foreach ($confirmed_dates_array as $d) {
    array_push($dates, $d);
}
foreach ($confirmed_sales_array as $s) {
    array_push($values, $s);
}
$confirmed_data = collect();
$confirmed_data->push(
    ['dates' => $dates,
        'values' => $values
    ]
);
