(function($) {
    'use strict';

    $(function() {

        $('.job-form-js').click(function(e) {
            e.preventDefault();

            if (! $(this).hasClass('open')) {
                $(this).addClass('open').html('Close');
            } else {
                $(this).removeClass('open').html('Add New');
            }

            $('#job-form').toggle(800);
        });

        $('.job-start-selector-js').change(function() {
            $('input[id^=job]').val('');
            getFormFields();
        });

        function getFormFields() {
            
            var select_val = $('.job-start-selector-js').val();
            switch (select_val) {
                case 'minute':
                    $('.job-minute-js').hide();
                    $('input[id=job-minute]').val(1);
                    $('.job-hour-js').hide();
                    $('.job-day_month-js').hide();
                    break;
                    
                case 'hour':
                    $('.job-minute-js').show();
                    $('.job-hour-js').hide();
                    $('input[id=job-hour]').val(1); 
                    $('.job-day_month-js').hide();         
                    break;

                case 'day_month':
                    $('.job-minute-js').show();
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_month]').val(1);
                    break;

                case 'month':
                    $('.job-minute-js').show();
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').show();
                    $('.job-month-js').hide();
                    $('input[id=job-month]').val(1);
                    break;

                case 'monday':
                    $('.job-minute-js').show(); 
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_week]').val(1);
                    break;

                case 'tuesday':
                    $('.job-minute-js').show(); 
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_week]').val(2);
                    break;

                case 'wednesday':
                    $('.job-minute-js').show(); 
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_week]').val(3);
                    break;

                case 'thursday':
                    $('.job-minute-js').show(); 
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_week]').val(4);
                    break;

                case 'friday':
                    $('.job-minute-js').show(); 
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_week]').val(5);
                    break;

                case 'saturday':
                    $('.job-minute-js').show(); 
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_week]').val(6);
                    break;

                case 'sunday':
                    $('.job-minute-js').show(); 
                    $('.job-hour-js').show(); 
                    $('.job-day_month-js').hide();
                    $('input[id=job-day_week]').val(7);
                    break;

                default:
                    //Statements executed when none of the values match the value of the expression
                    break;
            }
        }

        getFormFields();

    });

})(jQuery);