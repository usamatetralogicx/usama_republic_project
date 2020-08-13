<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Reports</title>
    <link rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/toastr.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-ecommerce-shop.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/forms/wizard.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/extensions/toastr.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns ecommerce-application navbar-floating footer-static menu-collapsed " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

<!-- BEGIN: Header-->
@include('layouts.side-nav-bar')
@include('layouts.top-nav-bar')


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <form action="#" class="icons-tab-steps checkout-tab-steps wizard-circle">
                <!-- Checkout Place order starts -->
                <fieldset class="checkout-step-1 px-0">
                    <section id="place-order" class="list-view product-checkout">
                        <div class="checkout-items">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-start pb-0">
                                            <div>
                                                <h2 class="text-bold-700">78.9k</h2>
                                                <p class="mb-0">Products</p>
                                            </div>
                                            <div class="avatar bg-rgba-primary p-50">
                                                <div class="avatar-content">
                                                    <i class="feather icon-monitor text-primary font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-content" style="position: relative;">
                                            <div id="line-area-chart-5" style="min-height: 80px;"><div id="apexcharts6rmh9qka" class="apexcharts-canvas apexcharts6rmh9qka light" style="width: 250px; height: 80px;"><svg id="SvgjsSvg1508" width="250" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1510" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1509"><clipPath id="gridRectMask6rmh9qka"><rect id="SvgjsRect1514" width="329" height="105" x="-2.5" y="-2.5" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMask6rmh9qka"><rect id="SvgjsRect1515" width="326" height="102" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1521" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1522" stop-opacity="1" stop-color="rgba(169,162,246,1)" offset="0"></stop><stop id="SvgjsStop1523" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="1"></stop><stop id="SvgjsStop1524" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="1"></stop><stop id="SvgjsStop1525" stop-opacity="1" stop-color="rgba(169,162,246,1)" offset="1"></stop></linearGradient><filter id="SvgjsFilter1528" filterUnits="userSpaceOnUse"><feFlood id="SvgjsFeFlood1529" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood1529Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1530" in="SvgjsFeFlood1529Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1530Out"></feComposite><feOffset id="SvgjsFeOffset1531" dx="0" dy="5" result="SvgjsFeOffset1531Out" in="SvgjsFeComposite1530Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1532" stdDeviation="4 " result="SvgjsFeGaussianBlur1532Out" in="SvgjsFeOffset1531Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1533" result="SvgjsFeMerge1533Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1534" in="SvgjsFeGaussianBlur1532Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1535" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1536" in="SourceGraphic" in2="SvgjsFeMerge1533Out" mode="normal" result="SvgjsFeBlend1536Out"></feBlend></filter></defs><line id="SvgjsLine1513" x1="0" y1="0" x2="0" y2="100" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="100" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1537" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1538" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1541" class="apexcharts-grid"><line id="SvgjsLine1543" x1="0" y1="100" x2="324" y2="100" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1542" x1="0" y1="1" x2="0" y2="100" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1517" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1518" class="apexcharts-series" seriesName="TrafficxRate" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1526" d="M 0 66.66666666666667C 22.679999999999996 66.66666666666667 42.120000000000005 38.888888888888886 64.8 38.888888888888886C 87.47999999999999 38.888888888888886 106.92 80.55555555555556 129.6 80.55555555555556C 152.28 80.55555555555556 171.72 25 194.4 25C 217.07999999999998 25 236.51999999999998 38.888888888888886 259.2 38.888888888888886C 281.88 38.888888888888886 301.32 11.111111111111114 324 11.111111111111114" fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient1521)" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMask6rmh9qka)" filter="url(#SvgjsFilter1528)" pathTo="M 0 66.66666666666667C 22.679999999999996 66.66666666666667 42.120000000000005 38.888888888888886 64.8 38.888888888888886C 87.47999999999999 38.888888888888886 106.92 80.55555555555556 129.6 80.55555555555556C 152.28 80.55555555555556 171.72 25 194.4 25C 217.07999999999998 25 236.51999999999998 38.888888888888886 259.2 38.888888888888886C 281.88 38.888888888888886 301.32 11.111111111111114 324 11.111111111111114" pathFrom="M -1 150L -1 150L 64.8 150L 129.6 150L 194.4 150L 259.2 150L 324 150"></path><g id="SvgjsG1519" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1549" r="0" cx="0" cy="0" class="apexcharts-marker w0my1z1z3 no-pointer-events" stroke="#ffffff" fill="#7367f0" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1520" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1544" x1="0" y1="0" x2="324" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1545" x1="0" y1="0" x2="324" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1546" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1547" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1548" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1512" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1539" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"><g id="SvgjsG1540" class="apexcharts-yaxis-texts-g"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light"><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker" style="background-color: rgb(115, 103, 240);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 250px; height: 80px;"></div></div><div class="contract-trigger"></div></div></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-start pb-0">
                                            <div>
                                                <h2 class="text-bold-700">659.8k</h2>
                                                <p class="mb-0">Orders</p>
                                            </div>
                                            <div class="avatar bg-rgba-success p-50">
                                                <div class="avatar-content">
                                                    <i class="feather icon-user-check text-success font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-content" style="position: relative;">
                                            <div id="line-area-chart-6" style="min-height: 80px;"><div id="apexchartsm7z07s9y" class="apexcharts-canvas apexchartsm7z07s9y light" style="width: 250px; height: 80px;"><svg id="SvgjsSvg1553" width="250" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1555" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1554"><clipPath id="gridRectMaskm7z07s9y"><rect id="SvgjsRect1559" width="329" height="105" x="-2.5" y="-2.5" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMaskm7z07s9y"><rect id="SvgjsRect1560" width="326" height="102" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1566" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1567" stop-opacity="1" stop-color="rgba(85,221,146,1)" offset="0"></stop><stop id="SvgjsStop1568" stop-opacity="1" stop-color="rgba(40,199,111,1)" offset="1"></stop><stop id="SvgjsStop1569" stop-opacity="1" stop-color="rgba(40,199,111,1)" offset="1"></stop><stop id="SvgjsStop1570" stop-opacity="1" stop-color="rgba(85,221,146,1)" offset="1"></stop></linearGradient><filter id="SvgjsFilter1573" filterUnits="userSpaceOnUse"><feFlood id="SvgjsFeFlood1574" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood1574Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1575" in="SvgjsFeFlood1574Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1575Out"></feComposite><feOffset id="SvgjsFeOffset1576" dx="0" dy="5" result="SvgjsFeOffset1576Out" in="SvgjsFeComposite1575Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1577" stdDeviation="4 " result="SvgjsFeGaussianBlur1577Out" in="SvgjsFeOffset1576Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1578" result="SvgjsFeMerge1578Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1579" in="SvgjsFeGaussianBlur1577Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1580" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1581" in="SourceGraphic" in2="SvgjsFeMerge1578Out" mode="normal" result="SvgjsFeBlend1581Out"></feBlend></filter></defs><line id="SvgjsLine1558" x1="0" y1="0" x2="0" y2="100" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="100" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1582" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1583" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1586" class="apexcharts-grid"><line id="SvgjsLine1588" x1="0" y1="100" x2="324" y2="100" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1587" x1="0" y1="1" x2="0" y2="100" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1562" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1563" class="apexcharts-series" seriesName="ActivexUsers" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1571" d="M 0 91.66666666666669C 18.9 91.66666666666669 35.1 50.00000000000003 54 50.00000000000003C 72.9 50.00000000000003 89.1 66.66666666666669 108 66.66666666666669C 126.9 66.66666666666669 143.1 8.333333333333343 162 8.333333333333343C 180.9 8.333333333333343 197.1 50.00000000000003 216 50.00000000000003C 234.9 50.00000000000003 251.1 16.666666666666686 270 16.666666666666686C 288.9 16.666666666666686 305.1 33.33333333333334 324 33.33333333333334" fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient1566)" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskm7z07s9y)" filter="url(#SvgjsFilter1573)" pathTo="M 0 91.66666666666669C 18.9 91.66666666666669 35.1 50.00000000000003 54 50.00000000000003C 72.9 50.00000000000003 89.1 66.66666666666669 108 66.66666666666669C 126.9 66.66666666666669 143.1 8.333333333333343 162 8.333333333333343C 180.9 8.333333333333343 197.1 50.00000000000003 216 50.00000000000003C 234.9 50.00000000000003 251.1 16.666666666666686 270 16.666666666666686C 288.9 16.666666666666686 305.1 33.33333333333334 324 33.33333333333334" pathFrom="M -1 216.66666666666669L -1 216.66666666666669L 54 216.66666666666669L 108 216.66666666666669L 162 216.66666666666669L 216 216.66666666666669L 270 216.66666666666669L 324 216.66666666666669"></path><g id="SvgjsG1564" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1594" r="0" cx="0" cy="0" class="apexcharts-marker w28ry3cpxh no-pointer-events" stroke="#ffffff" fill="#28c76f" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1565" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1589" x1="0" y1="0" x2="324" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1590" x1="0" y1="0" x2="324" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1591" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1592" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1593" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1557" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1584" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"><g id="SvgjsG1585" class="apexcharts-yaxis-texts-g"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light"><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker" style="background-color: rgb(40, 199, 111);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 250px; height: 80px;"></div></div><div class="contract-trigger"></div></div></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-start pb-0">
                                            <div>
                                                <h2 class="text-bold-700">28.7k</h2>
                                                <p class="mb-0">Users</p>
                                            </div>
                                            <div class="avatar bg-rgba-warning p-50">
                                                <div class="avatar-content">
                                                    <i class="feather icon-mail text-warning font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-content" style="position: relative;">
                                            <div id="line-area-chart-7" style="min-height: 80px;"><div id="apexcharts9gfatl6hk" class="apexcharts-canvas apexcharts9gfatl6hk light" style="width: 250px; height: 80px;"><svg id="SvgjsSvg1598" width="250" height="100" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1600" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1599"><clipPath id="gridRectMask9gfatl6hk"><rect id="SvgjsRect1604" width="329" height="105" x="-2.5" y="-2.5" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMask9gfatl6hk"><rect id="SvgjsRect1605" width="326" height="102" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1611" x1="0" y1="1" x2="1" y2="1"><stop id="SvgjsStop1612" stop-opacity="1" stop-color="rgba(255,192,133,1)" offset="0"></stop><stop id="SvgjsStop1613" stop-opacity="1" stop-color="rgba(255,159,67,1)" offset="1"></stop><stop id="SvgjsStop1614" stop-opacity="1" stop-color="rgba(255,159,67,1)" offset="1"></stop><stop id="SvgjsStop1615" stop-opacity="1" stop-color="rgba(255,192,133,1)" offset="1"></stop></linearGradient><filter id="SvgjsFilter1618" filterUnits="userSpaceOnUse"><feFlood id="SvgjsFeFlood1619" flood-color="#000000" flood-opacity="0.1" result="SvgjsFeFlood1619Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite1620" in="SvgjsFeFlood1619Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite1620Out"></feComposite><feOffset id="SvgjsFeOffset1621" dx="0" dy="5" result="SvgjsFeOffset1621Out" in="SvgjsFeComposite1620Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur1622" stdDeviation="4 " result="SvgjsFeGaussianBlur1622Out" in="SvgjsFeOffset1621Out"></feGaussianBlur><feMerge id="SvgjsFeMerge1623" result="SvgjsFeMerge1623Out" in="SourceGraphic"><feMergeNode id="SvgjsFeMergeNode1624" in="SvgjsFeGaussianBlur1622Out"></feMergeNode><feMergeNode id="SvgjsFeMergeNode1625" in="[object Arguments]"></feMergeNode></feMerge><feBlend id="SvgjsFeBlend1626" in="SourceGraphic" in2="SvgjsFeMerge1623Out" mode="normal" result="SvgjsFeBlend1626Out"></feBlend></filter></defs><line id="SvgjsLine1603" x1="0" y1="0" x2="0" y2="100" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="100" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1627" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1628" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1631" class="apexcharts-grid"><line id="SvgjsLine1633" x1="0" y1="100" x2="324" y2="100" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1632" x1="0" y1="1" x2="0" y2="100" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1607" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG1608" class="apexcharts-series" seriesName="Newsletter" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1616" d="M 0 90C 22.679999999999996 90 42.120000000000005 40 64.8 40C 87.47999999999999 40 106.92 90 129.6 90C 152.28 90 171.72 20 194.4 20C 217.07999999999998 20 236.51999999999998 70 259.2 70C 281.88 70 301.32 20 324 20" fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient1611)" stroke-opacity="1" stroke-linecap="butt" stroke-width="5" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMask9gfatl6hk)" filter="url(#SvgjsFilter1618)" pathTo="M 0 90C 22.679999999999996 90 42.120000000000005 40 64.8 40C 87.47999999999999 40 106.92 90 129.6 90C 152.28 90 171.72 20 194.4 20C 217.07999999999998 20 236.51999999999998 70 259.2 70C 281.88 70 301.32 20 324 20" pathFrom="M -1 820L -1 820L 64.8 820L 129.6 820L 194.4 820L 259.2 820L 324 820"></path><g id="SvgjsG1609" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1639" r="0" cx="0" cy="0" class="apexcharts-marker wvpfuf3hbf no-pointer-events" stroke="#ffffff" fill="#ff9f43" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1610" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1634" x1="0" y1="0" x2="324" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1635" x1="0" y1="0" x2="324" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1636" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1637" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1638" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1602" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1629" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"><g id="SvgjsG1630" class="apexcharts-yaxis-texts-g"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light"><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 159, 67);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
                                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 250px; height: 80px;"></div></div><div class="contract-trigger"></div></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checkout-options">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="options-title">Filters</p>
                                        <div class="coupons">
                                            <select class="form-control" name="" id="">
                                                <option value="">All</option>
                                                <option value="">==========</option>
                                                <option value="">This Day</option>
                                                <option value="">This Week</option>
                                                <option value="">This Month</option>
                                                <option value="">This Year</option>
                                                <option value="">==========</option>
                                                <option value="">Yesterday</option>
                                                <option value="">Previous Week</option>
                                                <option value="">Previous Month</option>
                                                <option value="">Previous Year</option>
                                                <option value="">==========</option>
                                                <option value="">Last 24 Hours</option>
                                                <option value="">Last 7 Days</option>
                                                <option value="">Last 30 Days</option>
                                                <option value="">==========</option>
                                                <option value="">custom</option>
                                            </select>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="date"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="date" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn btn-primary btn-block place-order">Search</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </fieldset>
                <!-- Checkout Place order Ends -->
            </form>

        </div>
    </div>
</div>
<!-- END: Content-->

@include('layouts.footer')


<!-- BEGIN: Vendor JS-->
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/jquery.steps.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/components.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('js/scripts/pages/app-ecommerce-shop.js') }}"></script>
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
