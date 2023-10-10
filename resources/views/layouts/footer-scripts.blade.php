<!-- jquery -->
<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<!-- plugins-jquery -->
<script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>
<!-- plugin_path -->
<script type="text/javascript"> var plugin_path ='{{asset('assets/js')}}/'</script>

<!-- chart -->
<script src="{{ URL::asset('assets/js/chart-init.js') }}"></script>
<!-- calendar -->
<script src="{{ URL::asset('assets/js/calendar.init.js') }}"></script>
<!-- charts sparkline -->
<script src="{{ URL::asset('assets/js/sparkline.init.js') }}"></script>
<!-- charts morris -->
<script src="{{ URL::asset('assets/js/morris.init.js') }}"></script>
<!-- datepicker -->
<script src="{{ URL::asset('assets/js/datepicker.js') }}"></script>
<!-- sweetalert2 -->
<script src="{{ URL::asset('assets/js/sweetalert2.js') }}"></script>
<!-- toastr -->
@yield('js')
<script src="{{ URL::asset('assets/js/toastr.js') }}"></script>
<!-- validation -->
<script src="{{ URL::asset('assets/js/validation.js') }}"></script>
<!-- lobilist -->
<script src="{{ URL::asset('assets/js/lobilist.js') }}"></script>
<!-- custom -->
<script src="{{ URL::asset('assets/js/custom.js') }}"></script>

<script src="{{ URL::asset('assets/js/jquery.validate.js') }}"></script>

<script>

    $('.dropdown-toggle').click(function (){

        $(this).parent().siblings().children('ul').css({
            display : 'none',
        });

        $(this).next().css({
            display : 'block',
        });

    });


    $('.notifications_list').click(function (){

        $('.dropdown-notifications').toggle();
    });


    $('.user-avatar').click(function (){

        $('.employee_information').toggle();
    });





    /*** To hide select options when click on another element in the page ***/
    $(document).mouseup(function (e)
    {
        var container = $('.dropdown-menu');

        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.hide();
        }
    });

    /*** To hide select options when click on another element in the page ***/
    $(document).mouseup(function (e)
    {
        var container = $('.dropdown-notifications');

        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.hide();
        }
    });


</script>