$(document).ready(function(){
    $('.show_list').click(function(){
        var block_sidebar  = $(this).parent().parent();
        if( block_sidebar.hasClass('active') )
            block_sidebar.removeClass('active');
        else
            block_sidebar.addClass('active');
    });
    $('.icon_show_list').click(function(){
        block_sb	= $(this).parent().parent();
        if( block_sb.hasClass('active') )
            block_sb.removeClass('active');
        else
            block_sb.addClass('active');
    });
	$('.closebtn').click(function(){
		$('#mySidenav').attr('style','left:-335px');
		$('#overlay').hide();
	});    
    $('#overlay,.close_sidebar_right').click(function(){
        $("#overlay").hide();
        $('.sidenavright').css('right','-270px');
         $('.sbleft,.sidenav').css('left','-335px');
 
     });

     $(".div_footer_small p").on('click',function(){
        $(this).parent().find(".child_menu_footer").slideToggle();
        $(this).find(".arrow_around").toggleClass("arrow_turn");
    });

    $('.navbar-nav .li_main').mouseenter(function(){
        $('.navbar-nav .li_main.actives').css('background', 'none');

        $(this).find('.dropdown-menu').show();
        if( $(this).hasClass('actives') )
        $   (this).find('.dropdown-menu').hide();

    }).mouseleave(function(){
        $(this).find('.dropdown-menu').hide();
    });
    $('.li_account').mouseenter(function(){
        $('.arrow_box_account').show();
    }).mouseleave(function(){
        $(this).find('.dropdown-menu').hide();
    });
    $('.nav-sidebar .click').on('click',function(){
        $(this).parents('.nav-item').find('.ul-lv2').slideToggle();
        if ($(this).hasClass('fa-minus')) {
            $(this).removeClass('fa-minus');
            $(this).addClass('fa-plus');
        }else{
            $(this).removeClass('fa-plus');
            $(this).addClass('fa-minus');
        }
    });
    var position = $(window).scrollTop();
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if(scroll > position) {
            $('.sidebar_sup_v3').addClass('fixed-sb');
        }
        position = scroll;
        if (position == 0) {
            $('.sidebar_sup_v3').removeClass('fixed-sb');
        }
    });    
    $('.li_menu').mouseenter(function(){
        _this  = $(this);
        obj_active = $('.li_menu.active');
        $('.li_menu,.li_menu > ul').removeClass('active');
        _this.addClass('active');
        $(this).find('ul').first().addClass('active');
    }).mouseleave(function(){
        $('.li_menu').removeClass('active');
        $('.li_menu,.li_menu > ul').removeClass('active');
        if (jQuery.type( obj_active )  === "object")
            obj_active.addClass('active');
    });    
    $('.li_post_head').hover(function(){
        var tab = $(this).attr('data-tab');
        $('.li_post_head').removeClass('active');
        $(this).addClass('active');
        $('.ul_content_post li').removeClass('active');
        $('.'+tab).addClass('active');
    });
    $('.show_hide_footer').click(function(){
        $(this).parent().find('.list_footer').toggle('');
        $(this).toggleClass('active');
    });
    $('.close_cate_sidebar').click(function(){
        $(this).parent().parent().hide();
    });
    $('.show_category_sb').click(function(){
        // $('#mySidenav').animate({
        //     scrollTop: parseInt($(".div_avatar").offset().top)
        // }, 200);
        $(this).parent().find('.category_post').show();
    });
});
function openNav() {
    document.getElementById("mySidenav").style.left = "0";
	$('#overlay').show();
}
function openNavright() {
    document.getElementById("mySidenavright").style.right = "0";
	$('#overlay').show();
}
function closeNavright(){
    document.getElementById("mySidenavright").style.right = "-290px";
	$('#overlay').show();
}
function trim(str) {
    return str.replace(/^\s+|\s+$/g,"");
}
function removeUnicode(str){
    str= str.toLowerCase();  
    str= str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g,"a");  
    str= str.replace(/??|??|???|???|???|??|???|???|???|???|???/g,"e");  
    str= str.replace(/??|??|???|???|??/g,"i");  
    str= str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g,"o");  
    str= str.replace(/??|??|???|???|??|??|???|???|???|???|???/g,"u");  
    str= str.replace(/???|??|???|???|???/g,"y");  
    str= str.replace(/??/g,"d");  
    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-"); 
    /* t??m v?? thay th??? c??c k?? t??? ?????c bi???t trong chu???i sang k?? t??? - */ 
    str= str.replace(/-+-/g,"-"); //thay th??? 2- th??nh 1- 
    str= str.replace(/^\-+|\-+$/g,"");  
    //c???t b??? k?? t??? - ??? ?????u v?? cu???i chu???i  
    return trim(str);  
}