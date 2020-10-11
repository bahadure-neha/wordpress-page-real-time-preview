jQuery(function ($) {
console.log('CHECK');
    $(window).bind('storage', function (e) {

        var post_id = rtp_js_var.post_id;
        var rtp_header_color = window.localStorage.getItem('header_color_'+post_id);
        var rtp_banner_color = window.localStorage.getItem('banner_color_'+post_id);
        var rtp_main_btn_color = window.localStorage.getItem('main_btn_color_'+post_id);
        var rtp_heading_fs = window.localStorage.getItem('heading_fs_'+post_id);

        $('h1').css({'color': rtp_header_color});
        if(rtp_heading_fs!=''){
            $('h1').css({'fontSize': parseInt(rtp_heading_fs) + 'px'});

        }else{
            $('h1').css({'fontSize':  ''});  
        }

        // $('section').css({'backgroundColor': rtp_banner_color});

        $('header .navbar-area').css({'backgroundColor': rtp_banner_color});

        $('.main-btn').css({'backgroundColor': rtp_main_btn_color});
        $('.main-btn').css({'borderColor': rtp_main_btn_color});
    });



    $(document).ready(function (e) {

        var rtp_header_color = rtp_js_var.rtp_header_color;
        var rtp_banner_color = rtp_js_var.rtp_banner_color;
        var rtp_main_btn_color = rtp_js_var.rtp_main_btn_color;
        var rtp_heading_fs = rtp_js_var.rtp_heading_fs;
       
        $('h1').css({'color': rtp_header_color});
        $('h1').css({'fontSize': parseInt(rtp_heading_fs) + 'px'});

        // $('section').css({'backgroundColor': rtp_banner_color});

        $('header .navbar-area').css({'backgroundColor': rtp_banner_color});

        $('.main-btn').css({'backgroundColor': rtp_main_btn_color});
        $('.main-btn').css({'borderColor': rtp_main_btn_color});
    });

});
