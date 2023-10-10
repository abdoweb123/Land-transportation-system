<!--=================================
 header start-->
<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <!-- logo -->
    <div class="text-left navbar-brand-wrapper">
        <h3 class="text-center m-auto" style="font-family: system-ui;">{{company_name_arabic()}}</h3>
    </div>
    <!-- Top bar left -->
    <ul class="nav navbar-nav mr-auto" style="margin-right: 50px;">
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    شباك التذاكر
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width: 180px;">
                    <li><a class="dropdown-item" href="{{route('reservationBookingRequests.searchLines')}}">حجز مقعد</a></li>
                    <li><a class="dropdown-item" href="#">مراجعة تفعيل الوردية</a></li>
                    <li>
                        <form method="GET" action="{{ route('logout')}}">
                            @csrf
                            <a class="dropdown-item" href="#" onclick="event.preventDefault();this.closest('form').submit();" style="padding: 4px 8px;"><i class="bx bx-log-out"></i>الخروج من النظام </a>
                        </form>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    الحركة والتشغيل
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="{{route('tripData.index')}}">دليل الرحلات</a></li>
                    {{--                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">دليل مسار الرحلات</a></li>--}}
                    <li><a class="dropdown-item" href="{{route('runTrips.index')}}">تشغيل رحلة</a></li>
                    <li><a class="dropdown-item" href="{{route('get_connect_runTrip_page')}}">ربط رحلات الذهاب والعودة</a></li>
                    {{--                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">تعديل بيانات التشغيل</a></li>--}}
                    <li><a class="dropdown-item" href="{{route('move_trip_seats_page')}}" style="border-bottom: 1px solid #ddd;">نقل مقاعد رحلة</a></li>
                    <li><a class="dropdown-item" href="{{route('settings.index')}}">إعدادات التشغيل</a></li>
                    <li class="dropdown-item-sub"><a class="dropdown-item dropdown-toggle" id="runTrip_reports" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>تقارير التشغيل</span><span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" >
                            <li><a class="dropdown-item" href="#">تقرير مراجعة التشغيل</a></li>
                            <li><a class="dropdown-item" href="#">تقرير مراجعة التشغيل-بالعدد</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    الماليات
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width: 180px;">
                    <li><a class="dropdown-item" href="#">عهدة التذاكر</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">توريدات موظف الحجز</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مراجعة إيرادات المكاتب</a></li>
                    <li><a class="dropdown-item" href="#">مراجعة عهد التذاكر</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مراجعة التذاكر التالفة</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مراجعة التشغيل</a></li>
                    <li><a class="dropdown-item" href="#">إدخال المصاريف</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    التقارير
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width: 200px;">
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" id="runTrip_reports" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>  أكواد النظام</span><span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 200px; left: -201px !important;">
                            <li class="dropdown-item-sub">
                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                                    <span>دليل العاملين</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 150px; left: -151px !important;">
                                    <li><a class="dropdown-item" href="{{route('departments.index')}}">دليل الإدارات</a></li>
                                    <li><a class="dropdown-item" href="{{route('employeeJobs.index')}}" style="border-bottom: 1px solid #ddd;">دليل الوظائف</a></li>
                                    <li><a class="dropdown-item" href="{{route('getAllEmployees',3)}}">بيانات العاملين</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-item-sub">
                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"  style="border-bottom: 1px solid #ddd;">
                                    <span>دليل العملاء والخصومات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 205px; left: -206px !important;">
                                    <li><a class="dropdown-item" href="{{route('paymentMethods.index')}}" style="border-bottom: 1px solid #ddd;">دليل وسائل الدفع</a></li>
                                    <li><a class="dropdown-item" href="{{route('customerTypes.index')}}" style="border-bottom: 1px solid #ddd;">دليل أنواع العملاء</a></li>
                                    <li><a class="dropdown-item" href="{{route('degrees.index')}}" style="border-bottom: 1px solid #ddd;">دليل أنواع الخدمة</a></li>
                                    <li><a class="dropdown-item" href="{{route('getAllUsers')}}">دليل العملاء</a></li>
                                    <li class="dropdown-item-sub">
                                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span> دليل الميداليات والخصومات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style=" min-width: 182px; left: -182px !important;">
                                            <li><a class="dropdown-item" href="{{route('coupons.index')}}">دليل الكوبونات</a></li>
                                            <li><a class="dropdown-item" href="{{route('packages.index')}}">دليل الاشتراكات</a></li>
                                            <li><a class="dropdown-item" href="{{route('bookedPackages.index')}}">دليل الاشتراكات المحجوزة</a></li>
                                            <li><a class="dropdown-item" href="{{route('millages.index')}}">دليل الخصومات</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-item-sub">
                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                                    <span>دليل الأتوبيسات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 185px; left: -186px !important;">
                                    <li><a class="dropdown-item" href="{{route('busTypes.index')}}">دليل الماركات</a></li>
                                    <li><a class="dropdown-item" href="{{route('busModels.index')}}">دليل الموديلات</a></li>
                                    <li><a class="dropdown-item" href="{{route('seats.create')}}" style="border-bottom: 1px solid #ddd;">دليل تصميم الأتوبيسات</a></li>
                                    <li><a class="dropdown-item" href="{{route('banks.index')}}">دليل البنوك</a></li>
                                    <li><a class="dropdown-item" href="{{route('busOwners.index')}}" style="border-bottom: 1px solid #ddd;">دليل حقوق الملكية</a></li>
                                    <li><a class="dropdown-item" href="{{route('buses.index')}}">بيانات الأتوبيسات</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-item-sub">
                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                                    <span>دليل المواقع</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 168px; left: -169px !important;">
                                    <li><a class="dropdown-item" href="{{route('countries.index')}}">دليل الدول</a></li>
                                    <li><a class="dropdown-item" href="{{route('cities.index')}}">دليل المدن</a></li>
                                    <li class="dropdown-item-sub">
                                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                                            <span>دليل المناطق</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 185px; left: -186px !important;">
                                            <li><a class="dropdown-item" href="{{route('states.index')}}">دليل المحافظات</a></li>
                                            <li><a class="dropdown-item" href="{{route('stations.index')}}">دليل المحطات</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="{{route('offices.index')}}">دليل مكاتب الحجز</a></li>
                                    <li><a class="dropdown-item" href="{{route('offices.index')}}">دليل نقاط الحجز</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-item-sub">
                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>دليل التوريدات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 168px; left: -169px !important;">
                                    <li><a class="dropdown-item" href="#">دليل أنواع التوريدات</a></li>
                                    <li><a class="dropdown-item" href="#">دليل طرق الدفع</a></li>
                                    <li><a class="dropdown-item" href="#">دليل وسائل التوريد</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#"  data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>تقارير المراجعة</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="left: -229px !important;  min-width: 228px;">
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مراجعة التشغيل</a></li>
                            <li><a class="dropdown-item" href="#">مراجعة التذاكر الملغية</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مراجعة التذاكر المعدلة</a></li>
                            <li><a class="dropdown-item" href="#">مراجعة عهد التذاكر</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مراجعة أرصدة التذاكر</a></li>
                            <li><a class="dropdown-item" href="#">مراجعة الدخول والخروج من النظام</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#"  data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>تقارير الإيرادات الرئيسية</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="left: -301px !important;  min-width: 300px;">
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">تفصيلي إيرادات رحلات الخطوط / موظف / فترة</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إيرادات الطريق / موظف الحجز / فترة</a></li>
                            <li><a class="dropdown-item" href="#">الإيراد اليومي للحافلات</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">الإيراد اليومي للمكاتب / نظار الحجز</a></li>
                            <li><a class="dropdown-item" href="#">بيان الإركاب والإيراد / فترة</a></li>
                            <li><a class="dropdown-item" href="#">بيان الإركاب والإيراد / فترة - يومى</a></li>
                            <li><a class="dropdown-item" href="#">بيان الإركاب والإيراد / فترة - شهرى</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان الإركاب والإيراد / فترة - شهرى / بالموعد</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان الإركاب والإيراد مناطق / فترة</a></li>
                            <li><a class="dropdown-item" href="#">إجمالي إيرادات المكاتب / خط / فترة</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إجمالي إيرادات المكاتب / مكتب / فترة</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مبيعات النولون للفرع / مكتب / فترة (إجمالي)</a></li>
                            <li><a class="dropdown-item" href="#">بيان الإيرادات المسددة / مكتب / ناظر حجز</a></li>
                            <li><a class="dropdown-item" href="#">بيان الإيرادات والتحصيلات / فترة</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#"  data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>تقارير أخرى</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="left: -450px !important;  min-width: 450px;">
                            <li><a class="dropdown-item" href="#">معدلات الإركاب لخط / فترة (إيرادات محققة من التشغيل)</a></li>
                            <li><a class="dropdown-item" href="#">معدلات الإركاب لخط / فترة (إيرادات محققة من التشغيل) - بدون مكاتب</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان الإيرادات والإركاب / فترة (إيرادات محققة من التشغيل)</a></li>
                            <li><a class="dropdown-item" href="#">معدلات الإركاب لخط / فترة (إيرادات محصلة من المكاتب)</a></li>
                            <li><a class="dropdown-item" href="#">معدلات الإركاب لخط / فترة (إيرادات محصلة من المكاتب) - بدون مكاتب</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان الإيرادات والإركاب / فترة (إيرادات محصلة من المكاتب)</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان الإيراد المرحل لفترة</a></li>
                            <li><a class="dropdown-item" href="#">بيان الإركاب والإيراد / فترة</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#"  data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>الحجز المجانى</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="left: -321px !important;  min-width: 320px;">
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان الميداليات والخصومات</a></li>
                            <li><a class="dropdown-item" href="#">بيان الحجز المجاني / مكتب / موظف الحجز</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان الحجز المجاني / خط / مكتب / موظف الحجز</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إجمالي الحجز المجاني / نوع الحجز</a></li>
                            <li><a class="dropdown-item" href="#">بيان الخصومات</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#"  data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>تقارير العملاء</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="left: -271px !important;  min-width: 270px;">
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان العملاء</a></li>
                            <li><a class="dropdown-item" href="#">بيان العملاء / منطقة الإركاب</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إجمالي العملاء / منطقة الإركاب</a></li>
                            <li><a class="dropdown-item" href="#">بيان العملاء / منطقة الوصول</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إجمالي العملاء / منطقة الوصول</a></li>
                            <li><a class="dropdown-item" href="#">بيان العملاء / مكتب الإركاب</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إجمالي العملاء / مكتب الإركاب</a></li>
                            <li><a class="dropdown-item" href="#">بيان العملاء / مكتب الحجز</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إجمالي العملاء / مكتب الحجز</a></li>
                            <li><a class="dropdown-item" href="#">إجمالي العملاء / موظف الحجز</a></li>
                            <li><a class="dropdown-item" href="#">إجمالي العملاء / نوع الخدمة</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#"  data-bs-toggle="dropdown" aria-expanded="false">
                            <span>تقارير (الإيمان جيت)</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="left: -371px !important;  min-width: 370px;">
                            <li><a class="dropdown-item" href="#">بيانات تشغيل الخطوط لحافلة / فترة </a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيان إجمالي عن تشغيل الخطوط الداخلية / فترة (ذ/ع)</a></li>
                            <li><a class="dropdown-item" href="#">بيانات تشغيل الحافلات لخط / فترة </a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">ملخص بيانات تشغيل الحافلات لخط / فترة</a></li>
                            <li><a class="dropdown-item" href="#">بيان تشغيل الحافلات / فرع / خط / فترة (ذ/ع)</a></li>
                            <li><a class="dropdown-item" href="#">بيان تشغيل الحافلات / فرع / فترة</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">مؤشرات تشغيل الحافلات / فترة</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">بيانات تشغيل السائقين لخط / فترة </a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">معدلات الإركاب لخط / فترة / أيام الأسبوع </a></li>
                            <li><a class="dropdown-item" href="#">بيان الإركاب والإيراد / فترة *</a></li>
                            <li><a class="dropdown-item" href="#">بيان الإركاب والإيراد / مناطق / فترة *</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">معدلات الإركاب لخط / فترة - مجمع</a></li>
                            <li><a class="dropdown-item" href="#">إجمالي إيرادات المكاتب / خط / فترة</a></li>
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إجمالي إيرادات الخطوط / مكتب / فترة</a></li>
                            <li><a class="dropdown-item" href="#">بيان العملاء</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    أكواد النظام
                </a>
                <ul class="dropdown-menu" aria-labelledby="runTrip_reports">
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>دليل العاملين</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 150px; left: -150px !important;">
                            <li><a class="dropdown-item" href="{{route('departments.index')}}">دليل الإدارات</a></li>
                            <li><a class="dropdown-item" href="{{route('employeeJobs.index')}}" style="border-bottom: 1px solid #ddd;">دليل الوظائف</a></li>
                            <li><a class="dropdown-item" href="{{route('getAllEmployees',3)}}">بيانات العاملين</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"  style="border-bottom: 1px solid #ddd;">
                            <span>دليل العملاء والخصومات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style=" min-width: 200px; left: -200px !important;">
                            <li><a class="dropdown-item" href="{{route('paymentMethods.index')}}" style="border-bottom: 1px solid #ddd;">دليل وسائل الدفع</a></li>
                            <li><a class="dropdown-item" href="{{route('getAllUsers')}}">دليل العملاء</a></li>
                            <li><a class="dropdown-item" href="{{route('customerTypes.index')}}" style="border-bottom: 1px solid #ddd;">دليل أنواع العملاء</a></li>

                            <li class="dropdown-item-sub">
                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span> دليل الخصومات والمجاني</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style=" min-width: 182px; left: -182px !important;">
                                    <li><a class="dropdown-item" href="{{route('coupons.index')}}">دليل الكوبونات</a></li>
                                    <li><a class="dropdown-item" href="{{route('packages.index')}}">دليل الاشتراكات</a></li>
                                    <li><a class="dropdown-item" href="{{route('bookedPackages.index')}}">دليل الاشتراكات المحجوزة</a></li>
                                    <li><a class="dropdown-item" href="{{route('millages.index')}}">دليل الخصومات</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>دليل الأتوبيسات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style=" min-width: 182px; left: -182px !important;">
                            <li><a class="dropdown-item" href="{{route('busTypes.index')}}">دليل الماركات</a></li>
                            <li><a class="dropdown-item" href="{{route('busModels.index')}}">دليل الموديلات</a></li>
                            <li><a class="dropdown-item" href="{{route('seats.create')}}" style="border-bottom: 1px solid #ddd;">دليل تصميم الأتوبيسات</a></li>
                            <li><a class="dropdown-item" href="{{route('banks.index')}}">دليل البنوك</a></li>
                            <li><a class="dropdown-item" href="{{route('busOwners.index')}}" style="border-bottom: 1px solid #ddd;">دليل حقوق الملكية</a></li>
                            <li><a class="dropdown-item" href="{{route('buses.index')}}">بيانات الأتوبيسات</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>دليل المواقع</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style=" min-width: 160px; left: -160px !important;">
                            <li class="dropdown-item-sub">
                                <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                                    <span>دليل المناطق</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 185px; left: -185px !important;">
                                    <li><a class="dropdown-item" href="{{route('states.index')}}">دليل المحافظات</a></li>
                                    <li><a class="dropdown-item" href="{{route('stations.index')}}">دليل المحطات</a></li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="{{route('offices.index')}}">دليل مكاتب الحجز</a></li>
                            <li><a class="dropdown-item" href="{{route('offices.index')}}">دليل نقاط الحجز</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>دليل التوريدات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style=" min-width: 160px; left: -160px !important;">
                            <li><a class="dropdown-item" href="#">دليل أنواع التوريدات</a></li>
                            <li><a class="dropdown-item" href="#">دليل طرق الدفع</a></li>
                            <li><a class="dropdown-item" href="#">دليل وسائل التوريد</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-bottom: 1px solid #ddd;">
                            <span>دليل التكاليف</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 160px; left: -160px !important;">
                            <li><a class="dropdown-item" href="#">دليل أنواع المصروفات</a></li>
                            <li><a class="dropdown-item" href="#">دليل الموردين</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-item-sub">
                        <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>دليل الرحلات</span> <span><i class="fa fa-arrow-circle-left float-right"></i></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sub" aria-labelledby="runTrip_reports" style="min-width: 160px; left: -160px !important;">
                            <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">دليل الخطوط</a></li>
                            <li><a class="dropdown-item" href="{{route('degrees.index')}}" style="border-bottom: 1px solid #ddd;">دليل أنواع الخدمة</a></li>
                            <li><a class="dropdown-item" href="#">دليل الملاحظات</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    أدوات
                </a>
                <ul class="dropdown-menu" aria-labelledby="runTrip_reports" style=" min-width: 265px; left: -225px !important;">
                    <li><a class="dropdown-item" href="#">سماحيات الدخول للنظام</a></li>
                    <li><a class="dropdown-item" href="#">مجموعات الصلاحيات</a></li>
                    <li><a class="dropdown-item" href="#">توزيع المستخدمين على المجموعات</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">صلاحيات استخدام النظام للمجموعات</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">تعديل كلمة المرور</a></li>
                    <li><a class="dropdown-item" href="#">الدعم الفني</a></li>
                    <li><a class="dropdown-item" href="#">تحديد مسئول المتابعة</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">تعديل إمكانية الدخول والخروج</a></li>
                    <li><a class="dropdown-item" href="#">رسائل التنبيه</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">أحدث التعليمات</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">إعدادات النظام</a></li>
                    <li><a class="dropdown-item" href="#">ترحيل البيانات</a></li>
                    <li><a class="dropdown-item" href="#">عمل نسخة احتياطية من البرنامج</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    نوافذ
                </a>
                <ul class="dropdown-menu" aria-labelledby="runTrip_reports" style=" min-width: 150px; left: -115px !important;">
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;">ترتيب تلقائي</a></li>
                    <li><a class="dropdown-item" href="#">ترتيب أفقي</a></li>
                    <li><a class="dropdown-item" href="#">ترتيب رأسي</a></li>
                    <li><a class="dropdown-item" href="#" style="border-bottom: 1px solid #ddd;"> ترتيب متتالي</a></li>
                    <li><a class="dropdown-item" href="#">البحث عن رحلة</a></li>
                    <li><a class="dropdown-item" href="#">عهدة التذاكر</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item mx-3">
            <div class="dropdown">
                <a class="dropdown-toggle nav-link top_nav_new" href="#" role="button" id="dropdownMenuLink"  data-bs-toggle="dropdown" aria-expanded="false" style="color:black">
                    Admin
                </a>
                <ul class="dropdown-menu" aria-labelledby="runTrip_reports" style="min-width: 110px;">
                    <li><a class="dropdown-item" href="#">Query</a></li>
                    <li><a class="dropdown-item" href="#">Test</a></li>
                </ul>
            </div>
        </li>

    </ul>
    <!-- top bar right -->
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            {{--            <div class="btn-group mb-1">--}}
            {{--                <button type="button" class="btn p-10 btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
            {{--                    --}}{{--   {{trans('main_trans.change_language')}}--}}
            {{--                    @if(App::getLocale() == 'ar')--}}
            {{--                        العربية--}}
            {{--                        <img src="{{ URL::asset('assets/images/flags/EG.png') }}" alt="">--}}
            {{--                    @elseif(App::getLocale() == 'en')--}}
            {{--                        English--}}
            {{--                        <img src="{{ URL::asset('assets/images/flags/US.png') }}" alt="">--}}
            {{--                    @endif--}}
            {{--                </button>--}}
            {{--                <div class="dropdown-menu">--}}
            {{--                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
            {{--                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
            {{--                            {{ $properties['native'] }}--}}
            {{--                        </a>--}}
            {{--                    @endforeach--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </li>

        {{--                <li class="nav-item fullscreen">--}}
        {{--                    <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>--}}
        {{--                </li>--}}
        <li class="nav-item dropdown ">
            <a class="nav-link top-nav notifications_list" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                <i class="ti-bell"></i>
                <span class="badge badge-danger notification-status"> </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-big dropdown-notifications">
                <?php  use App\Models\Les; $lessNotifications = Les::latest()->paginate(10); ?>
                <div class="dropdown-header notifications py-0">
                    <p class="mb-0 font-bold" style="font-size: 15px;">إشعارات التدفق المالي</p>
                    {{--                            <span class="badge badge-pill badge-warning">ال</span>--}}
                </div>
                <div class="dropdown-divider"></div>
                @foreach($lessNotifications as $item)
                    <a href="#" class="dropdown-item"><span>{{$loop->index+1}}- </span> @if($item->type == 1) تم تحصيل مبلغ مقداره  <strong>{{$item->amount}}</strong>  جنيها @else  تم دفع مبلغ مقداره {{$item->amount}} جنيها @endif<small class="float-right text-muted time">{{$item->created_at->diffForHumans()}}</small> </a>
                @endforeach
            </div>
        </li>
        {{--                <li class="nav-item dropdown ">--}}
        {{--                    <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"--}}
        {{--                        aria-expanded="true"> <i class=" ti-view-grid"></i> </a>--}}
        {{--                    <div class="dropdown-menu dropdown-menu-right dropdown-big">--}}
        {{--                        <div class="dropdown-header">--}}
        {{--                            <strong>Quick Links</strong>--}}
        {{--                        </div>--}}
        {{--                        <div class="dropdown-divider"></div>--}}
        {{--                        <div class="nav-grid">--}}
        {{--                            <a href="#" class="nav-grid-item"><i class="ti-files text-primary"></i>--}}
        {{--                                <h5>New Task</h5>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="nav-grid-item"><i class="ti-check-box text-success"></i>--}}
        {{--                                <h5>Assign Task</h5>--}}
        {{--                            </a>--}}
        {{--                        </div>--}}
        {{--                        <div class="nav-grid">--}}
        {{--                            <a href="#" class="nav-grid-item"><i class="ti-pencil-alt text-warning"></i>--}}
        {{--                                <h5>Add Orders</h5>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="nav-grid-item"><i class="ti-truck text-danger "></i>--}}
        {{--                                <h5>New Orders</h5>--}}
        {{--                            </a>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </li>--}}
        <li class="nav-item dropdown mr-30">
            <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button">
                <img src="{{asset('assets/images/profile-avatar.jpg')}}" alt="avatar">
            </a>
            <div class="dropdown-menu dropdown-menu-right employee_information" style="left:0; min-width:180px;">
                <div class="dropdown-header">
                    <div class="media">
                        <div class="media-body">
                            <h6>بيانات الموظف</h6>
                            <p class="mt-0 mb-0"> {{auth('admin')->user()->name}}</p>
                            <p>{{auth('admin')->user()->email}}</p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                {{--                <a class="dropdown-item" href="#"><i class="text-warning ti-user"></i>Profile</a>--}}
                {{--                <a class="dropdown-item" href="#"><i class="text-dark ti-layers-alt"></i>Projects <span--}}
                {{--                        class="badge badge-info">6</span> </a>--}}
                {{--                <div class="dropdown-divider"></div>--}}
                {{--                <a class="dropdown-item" href="#"><i class="text-info ti-settings"></i>Settings</a>--}}
                <form method="GET" action="{{ route('logout')}}">
                    @csrf
                    <a class="dropdown-item" href="#" onclick="event.preventDefault();this.closest('form').submit();"><i class="bx bx-log-out"></i>تسجيل الخروج</a>
                </form>
            </div>
        </li>
    </ul>
</nav>

<!--=================================
header End-->
