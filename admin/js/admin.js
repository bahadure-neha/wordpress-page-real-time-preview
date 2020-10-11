jQuery(function ($) {
    console.log('color_field_abc');
    $(document).ready(function () {
        var post_id = $("input[name='post_ID']").val();
        $('.header_color.wp-color-picker').wpColorPicker({
            change: function (event, ui) {
                var element = event.target;
                var color = ui.color.toString();
                console.log(color);
                window.localStorage.setItem('header_color_'+post_id, color);
            },
        });

        $('.banner_color').wpColorPicker({
            change: function (event, ui) {
                var element = event.target;
                var color = ui.color.toString();
                console.log(color);
                window.localStorage.setItem('banner_color_'+post_id, color);
            },
        });

        $('.main_btn_color').wpColorPicker({
            change: function (event, ui) {
                var element = event.target;
                var color = ui.color.toString();
                console.log(color);
                window.localStorage.setItem('main_btn_color_'+post_id, color);
            },
        });


        $('select.heading_fs').on('change', function () {

            var heading_fs = $(this).val();

            window.localStorage.setItem('heading_fs_'+post_id, heading_fs);
        });

    });
});