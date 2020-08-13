@extends('layouts.new_theme')

@section('title', 'Retailer Dashboard')

@section('content')

    <div class="">
        <div class="row">
            <div class="col-12"><img src="" height="400px" width="400px" alt=""></div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                        <p>Products</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{ $ordersCount }}</h2>
                        <p>Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">0%</h2>
                        <p>Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-package text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">0</h2>
                        <p>Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-end">
                        <h4 class="card-title">Revenue</h4>
                        <div class="dropdown">
                            <button class="btn-icon btn btn-round btn-sm" type="button" data-toggle="dropdown">
                                <i class="feather icon-settings"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                 style="position: absolute; transform: translate3d(124px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="#">Last 28 days</a>
                                <a class="dropdown-item" href="#">Last Week</a>
                                <a class="dropdown-item" href="#">Yesterday</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body pb-0" style="position: relative;">
                            <div class="d-flex justify-content-start">
                                <div class="mr-2">
                                    <p class="mb-50 text-bold-600">This Month</p>
                                    <h2 class="text-bold-400">
                                        <sup class="font-medium-1">$</sup>
                                        <span class="text-success">0</span>
                                    </h2>
                                </div>
                                <div>
                                    <p class="mb-50 text-bold-600">Last Month</p>
                                    <h2 class="text-bold-400">
                                        <sup class="font-medium-1">$</sup>
                                        <span>0</span>
                                    </h2>
                                </div>

                            </div>
                            <div id="revenue-chart" style="min-height: 285px;">
                                <div id="apexchartsxeae76nm" class="apexcharts-canvas apexchartsxeae76nm light" style="width: 634px; height: 270px;">
                                    <svg id="SvgjsSvg1134" width="500" height="270" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                         class="apexcharts-svg" transform="translate(0, 0)" style="background: transparent;">
                                        <g id="SvgjsG1136" class="apexcharts-inner apexcharts-graphical" transform="translate(65.0625, 30)">
                                            <defs id="SvgjsDefs1135">
                                                <clipPath id="gridRectMaskxeae76nm">
                                                    <rect id="SvgjsRect1141" width="555.1796875" height="201.348" x="-2" y="-2" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0"></rect>
                                                </clipPath>
                                                <clipPath id="gridRectMarkerMaskxeae76nm">
                                                    <rect id="SvgjsRect1142" width="553.1796875" height="199.348" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0"></rect>
                                                </clipPath>
                                                <linearGradient id="SvgjsLinearGradient1148" x1="0" y1="1" x2="1" y2="1">
                                                    <stop id="SvgjsStop1149" stop-opacity="1" stop-color="rgba(242,146,146,1)" offset="0"></stop>
                                                    <stop id="SvgjsStop1150" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="1"></stop>
                                                    <stop id="SvgjsStop1151" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="1"></stop>
                                                    <stop id="SvgjsStop1152" stop-opacity="1" stop-color="rgba(242,146,146,1)" offset="1"></stop>
                                                </linearGradient>
                                                <linearGradient id="SvgjsLinearGradient1157" x1="0" y1="1" x2="1" y2="1">
                                                    <stop id="SvgjsStop1158" stop-opacity="1" stop-color="rgba(185,195,205,1)" offset="0"></stop>
                                                    <stop id="SvgjsStop1159" stop-opacity="1" stop-color="rgba(185,195,205,1)" offset="1"></stop>
                                                    <stop id="SvgjsStop1160" stop-opacity="1" stop-color="rgba(185,195,205,1)" offset="1"></stop>
                                                    <stop id="SvgjsStop1161" stop-opacity="1" stop-color="rgba(185,195,205,1)" offset="1"></stop>
                                                </linearGradient>
                                            </defs>
                                            <line id="SvgjsLine1140" x1="235.71986607142856" y1="0" x2="235.71986607142856" y2="197.348" stroke="#b6b6b6" stroke-dasharray="3"
                                                  class="apexcharts-xcrosshairs" x="235.71986607142856" y="0" width="1" height="197.348" fill="#b1b9c4" filter="none" fill-opacity="0.9"
                                                  stroke-width="1"></line>
                                            <g id="SvgjsG1163" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                <g id="SvgjsG1164" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)">
                                                    <text id="SvgjsText1165" font-family="Helvetica, Arial, sans-serif" x="0" y="226.348" text-anchor="middle" dominant-baseline="auto" font-size="12px"
                                                          font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1166" style="font-family: Helvetica, Arial, sans-serif;">01</tspan>
                                                        <title>01</title></text>
                                                    <text id="SvgjsText1167" font-family="Helvetica, Arial, sans-serif" x="78.73995535714286" y="226.348" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="12px" font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1168" style="font-family: Helvetica, Arial, sans-serif;">05</tspan>
                                                        <title>05</title></text>
                                                    <text id="SvgjsText1169" font-family="Helvetica, Arial, sans-serif" x="157.47991071428572" y="226.348" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="12px" font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1170" style="font-family: Helvetica, Arial, sans-serif;">09</tspan>
                                                        <title>09</title></text>
                                                    <text id="SvgjsText1171" font-family="Helvetica, Arial, sans-serif" x="236.21986607142856" y="226.348" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="12px" font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1172" style="font-family: Helvetica, Arial, sans-serif;">13</tspan>
                                                        <title>13</title></text>
                                                    <text id="SvgjsText1173" font-family="Helvetica, Arial, sans-serif" x="314.95982142857144" y="226.348" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="12px" font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1174" style="font-family: Helvetica, Arial, sans-serif;">17</tspan>
                                                        <title>17</title></text>
                                                    <text id="SvgjsText1175" font-family="Helvetica, Arial, sans-serif" x="393.69977678571433" y="226.348" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="12px" font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1176" style="font-family: Helvetica, Arial, sans-serif;">21</tspan>
                                                        <title>21</title></text>
                                                    <text id="SvgjsText1177" font-family="Helvetica, Arial, sans-serif" x="472.4397321428572" y="226.348" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="12px" font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1178" style="font-family: Helvetica, Arial, sans-serif;">26</tspan>
                                                        <title>26</title></text>
                                                    <text id="SvgjsText1179" font-family="Helvetica, Arial, sans-serif" x="551.1796875000001" y="226.348" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="12px" font-weight="400" fill="#b9c3cd" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1180" style="font-family: Helvetica, Arial, sans-serif;">31</tspan>
                                                        <title>31</title></text>
                                                </g>
                                            </g>
                                            <g id="SvgjsG1189" class="apexcharts-grid">
                                                <g id="SvgjsG1190" class="apexcharts-gridlines-horizontal">
                                                    <line id="SvgjsLine1192" x1="0" y1="0" x2="551.1796875" y2="0" stroke="#e7e7e7" stroke-dasharray="0" class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1193" x1="0" y1="39.4696" x2="551.1796875" y2="39.4696" stroke="#e7e7e7" stroke-dasharray="0" class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1194" x1="0" y1="78.9392" x2="551.1796875" y2="78.9392" stroke="#e7e7e7" stroke-dasharray="0" class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1195" x1="0" y1="118.4088" x2="551.1796875" y2="118.4088" stroke="#e7e7e7" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1196" x1="0" y1="157.8784" x2="551.1796875" y2="157.8784" stroke="#e7e7e7" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1197" x1="0" y1="197.348" x2="551.1796875" y2="197.348" stroke="#e7e7e7" stroke-dasharray="0" class="apexcharts-gridline"></line>
                                                </g>
                                                <g id="SvgjsG1191" class="apexcharts-gridlines-vertical"></g>
                                                <line id="SvgjsLine1199" x1="0" y1="197.348" x2="551.1796875" y2="197.348" stroke="transparent" stroke-dasharray="0"></line>
                                                <line id="SvgjsLine1198" x1="0" y1="1" x2="0" y2="197.348" stroke="transparent" stroke-dasharray="0"></line>
                                            </g>
                                            <g id="SvgjsG1144" class="apexcharts-line-series apexcharts-plot-series">
                                                <g id="SvgjsG1154" class="apexcharts-series" seriesName="LastxMonth" rel="2" >
                                                    <path id="SvgjsPath1162"
                                                          d="M0 118.40879999999993C27.558984374999994 118.40879999999993 51.18097098214285 39.46960000000013 78.73995535714285 39.46960000000013C106.29893973214284 39.46960000000013 129.9209263392857 138.1436000000001 157.4799107142857 138.1436000000001C185.0388950892857 138.1436000000001 208.66088169642856 94.72703999999999 236.21986607142856 94.72703999999999C263.7788504464285 94.72703999999999 287.4008370535714 177.6132 314.9598214285714 177.6132C342.5188058035714 177.6132 366.14079241071425 98.67399999999998 393.6997767857143 98.67399999999998C421.25876116071424 98.67399999999998 444.88074776785714 157.87840000000006 472.4397321428571 157.87840000000006C499.99871651785713 157.87840000000006 523.620703125 78.93920000000003 551.1796875 78.93920000000003C551.1796875 78.93920000000003 551.1796875 78.93920000000003 551.1796875 78.93920000000003 "
                                                          fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient1157)" stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                          stroke-dasharray="8" class="apexcharts-line" index="1" clip-path="url(#gridRectMaskxeae76nm)"
                                                          pathTo="M 0 118.40879999999993C 27.558984374999994 118.40879999999993 51.18097098214285 39.46960000000013 78.73995535714285 39.46960000000013C 106.29893973214284 39.46960000000013 129.9209263392857 138.1436000000001 157.4799107142857 138.1436000000001C 185.0388950892857 138.1436000000001 208.66088169642856 94.72703999999999 236.21986607142856 94.72703999999999C 263.7788504464285 94.72703999999999 287.4008370535714 177.6132 314.9598214285714 177.6132C 342.5188058035714 177.6132 366.14079241071425 98.67399999999998 393.6997767857143 98.67399999999998C 421.25876116071424 98.67399999999998 444.88074776785714 157.87840000000006 472.4397321428571 157.87840000000006C 499.99871651785713 157.87840000000006 523.620703125 78.93920000000003 551.1796875 78.93920000000003"
                                                          pathFrom="M -1 1934.0104000000001L -1 1934.0104000000001L 78.73995535714285 1934.0104000000001L 157.4799107142857 1934.0104000000001L 236.21986607142856 1934.0104000000001L 314.9598214285714 1934.0104000000001L 393.6997767857143 1934.0104000000001L 472.4397321428571 1934.0104000000001L 551.1796875 1934.0104000000001"></path>
                                                    <g id="SvgjsG1155" class="apexcharts-series-markers-wrap">
                                                        <g class="apexcharts-series-markers">
                                                            <circle id="SvgjsCircle1205" r="0" cx="236.21986607142856" cy="94.72703999999999" class="apexcharts-marker wg8bhc4fi no-pointer-events"
                                                                    stroke="#ffffff" fill="#b9c3cd" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1156" class="apexcharts-datalabels"></g>
                                                </g>
                                                <g id="SvgjsG1145" class="apexcharts-series" seriesName="ThisxMonth"  rel="1" >
                                                    <path id="SvgjsPath1153"
                                                          d="M0 157.87840000000006C27.558984374999994 157.87840000000006 51.18097098214285 78.93920000000003 78.73995535714285 78.93920000000003C106.29893973214284 78.93920000000003 129.9209263392857 165.77232000000004 157.4799107142857 165.77232000000004C185.0388950892857 165.77232000000004 208.66088169642856 59.20440000000008 236.21986607142856 59.20440000000008C263.7788504464285 59.20440000000008 287.4008370535714 138.1436000000001 314.9598214285714 138.1436000000001C342.5188058035714 138.1436000000001 366.14079241071425 39.46960000000013 393.6997767857143 39.46960000000013C421.25876116071424 39.46960000000013 444.88074776785714 98.67399999999998 472.4397321428571 98.67399999999998C499.99871651785713 98.67399999999998 523.620703125 15.78783999999996 551.1796875 15.78783999999996C551.1796875 15.78783999999996 551.1796875 15.78783999999996 551.1796875 15.78783999999996 "
                                                          fill="none" fill-opacity="1" stroke="url(#SvgjsLinearGradient1148)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4"
                                                          stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskxeae76nm)"
                                                          pathTo="M 0 157.87840000000006C 27.558984374999994 157.87840000000006 51.18097098214285 78.93920000000003 78.73995535714285 78.93920000000003C 106.29893973214284 78.93920000000003 129.9209263392857 165.77232000000004 157.4799107142857 165.77232000000004C 185.0388950892857 165.77232000000004 208.66088169642856 59.20440000000008 236.21986607142856 59.20440000000008C 263.7788504464285 59.20440000000008 287.4008370535714 138.1436000000001 314.9598214285714 138.1436000000001C 342.5188058035714 138.1436000000001 366.14079241071425 39.46960000000013 393.6997767857143 39.46960000000013C 421.25876116071424 39.46960000000013 444.88074776785714 98.67399999999998 472.4397321428571 98.67399999999998C 499.99871651785713 98.67399999999998 523.620703125 15.78783999999996 551.1796875 15.78783999999996"
                                                          pathFrom="M -1 1934.0104000000001L -1 1934.0104000000001L 78.73995535714285 1934.0104000000001L 157.4799107142857 1934.0104000000001L 236.21986607142856 1934.0104000000001L 314.9598214285714 1934.0104000000001L 393.6997767857143 1934.0104000000001L 472.4397321428571 1934.0104000000001L 551.1796875 1934.0104000000001"></path>
                                                    <g id="SvgjsG1146" class="apexcharts-series-markers-wrap">
                                                        <g class="apexcharts-series-markers">
                                                            <circle id="SvgjsCircle1206" r="0" cx="236.21986607142856" cy="59.20440000000008" class="apexcharts-marker wbtor1b25 no-pointer-events"
                                                                    stroke="#ffffff" fill="#f29292" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1147" class="apexcharts-datalabels"></g>
                                                </g>
                                            </g>
                                            <line id="SvgjsLine1200" x1="0" y1="0" x2="551.1796875" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line>
                                            <line id="SvgjsLine1201" x1="0" y1="0" x2="551.1796875" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line>
                                            <g id="SvgjsG1202" class="apexcharts-yaxis-annotations"></g>
                                            <g id="SvgjsG1203" class="apexcharts-xaxis-annotations"></g>
                                            <g id="SvgjsG1204" class="apexcharts-point-annotations"></g>
                                        </g>
                                        <rect id="SvgjsRect1139" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect>
                                        <g id="SvgjsG1181" class="apexcharts-yaxis" rel="0" transform="translate(32.0625, 0)">
                                            <g id="SvgjsG1182" class="apexcharts-yaxis-texts-g">
                                                <text id="SvgjsText1183" font-family="Helvetica, Arial, sans-serif" x="20" y="31.5" text-anchor="end" dominant-baseline="auto" font-size="11px"
                                                      fill="#b9c3cd" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">49.0k
                                                </text>
                                                <text id="SvgjsText1184" font-family="Helvetica, Arial, sans-serif" x="20" y="71.06960000000001" text-anchor="end" dominant-baseline="auto"
                                                      font-size="11px" fill="#b9c3cd" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">48.0k
                                                </text>
                                                <text id="SvgjsText1185" font-family="Helvetica, Arial, sans-serif" x="20" y="110.63920000000002" text-anchor="end" dominant-baseline="auto"
                                                      font-size="11px" fill="#b9c3cd" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">47.0k
                                                </text>
                                                <text id="SvgjsText1186" font-family="Helvetica, Arial, sans-serif" x="20" y="150.20880000000002" text-anchor="end" dominant-baseline="auto"
                                                      font-size="11px" fill="#b9c3cd" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">46.0k
                                                </text>
                                                <text id="SvgjsText1187" font-family="Helvetica, Arial, sans-serif" x="20" y="189.77840000000003" text-anchor="end" dominant-baseline="auto"
                                                      font-size="11px" fill="#b9c3cd" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">45.0k
                                                </text>
                                                <text id="SvgjsText1188" font-family="Helvetica, Arial, sans-serif" x="20" y="229.34800000000004" text-anchor="end" dominant-baseline="auto"
                                                      font-size="11px" fill="#b9c3cd" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">44.0k
                                                </text>
                                            </g>
                                        </g>
                                    </svg>
                                    <div class="apexcharts-legend"></div>
                                    <div class="apexcharts-tooltip light" style="left: 311.063px; top: 61.5px;">
                                        <div class="apexcharts-tooltip-series-group active" style="display: flex;"><span class="apexcharts-tooltip-marker"
                                                                                                                         style="background-color: rgb(242, 146, 146);"></span>
                                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">This Month: </span><span
                                                        class="apexcharts-tooltip-text-value">47.5k</span></div>
                                                <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                        <div class="apexcharts-tooltip-series-group active" style="display: flex;"><span class="apexcharts-tooltip-marker"
                                                                                                                         style="background-color: rgb(185, 195, 205);"></span>
                                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Last Month: </span><span
                                                        class="apexcharts-tooltip-text-value">46.6k</span></div>
                                                <div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom light" style="left: 281.806px; top: 229.348px;">
                                        <div class="apexcharts-xaxistooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; min-width: 15.9531px;">13</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 row pr-0 h-100">
                <div class="col-sm-6 col-12 pr-0  mt-1">
                    <div class="card h-100">
                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                            <p>Products</p>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-12 pr-0  mt-1">
                    <div class="card h-100">
                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                            <p>Products</p>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-12 pr-0 mt-2">
                    <div class="card h-100">
                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                            <p>Products</p>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-12 pr-0 mt-2">
                    <div class="card h-100">
                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">
                            <div class="avatar bg-rgba-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                            <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                            <p>Products</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
