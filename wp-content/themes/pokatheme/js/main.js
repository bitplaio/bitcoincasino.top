jQuery(document).ready(function($) {

    var $window = $(window);

    //placeholders for IE
    $('input').placeholder();

    //Mm-menu
    $("#mobile-menu").mmenu({
        offCanvas: {
            pageSelector: "#page-wrapper"
        },
		navbars		: {
			content : [ "prev", "searchfield", "close" ]
		},
        extensions: ["shadow-page", "fx-menu-slide"]
    });

    //Tooltips
    function tooltips_init(){
        $( '.terms-wrapper' ).each(function() {
            if( $(this).find('.tooltip-text').length ){
                tippy( $(this).find('.tooltip-el')[0], {
                    content: $(this).find('.tooltip-text').html(),
                    placement: 'top',
                    interactive: true,
                    arrow: true
                });
            }
        });
    }
    tooltips_init();

    $('header .menu').superfish();

    $('.lightbox').magnificPopup({
        type: 'image',
        mainClass: 'mfp-with-zoom',
        zoom: {
            enabled: true,

            duration: 300,
            easing: 'ease-in-out',
            opener: function(openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        },
        gallery:{
            enabled:true
        }
    });

    //Responsive videos
    $("#main, .section").fitVids();

    $('.carousel').each(function(){
        var rtlValue = false;
        var num = 3;
        if( $('html').attr('dir') == 'rtl' ){
            rtlValue = true;
        }
        if( $(this).parents('.main__content__left').length ){
            num = 1;
        }
        $(this).owlCarousel({
            loop:true,
            rtl:rtlValue,
            margin:20,
            nav:true,
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                780:{
                    items:2
                },
                971:{
                    items:num
                }
            },
            navText:['<i class="icon-poka icon-poka-arrow-left"></i>','<i class="icon-poka icon-poka-arrow-right"></i>'],
            onInitialized : tooltips_init
        });
    });

    var rtlValue = false;
    if( $('html').attr('dir') == 'rtl' ){
        rtlValue = true;
    }
    $('.carousel-relevant').owlCarousel({
        loop:true,
        rtl:rtlValue,
        margin:35,
        responsiveClass:true,
        items:2.5,
        autoWidth:false,
        dots:false,
        responsive:{
            0:{
                items:1,
            },
            575:{
                items:1.5,
            },
            971:{
                items:2.5
            }
        }
    });

    $('.carousel-screenshot').owlCarousel({
        loop:true,
        rtl:rtlValue,
        margin:35,
        responsiveClass:true,
        items:4,
        nav:true,
        dots:false,
        navText:['<i class="icon-poka icon-poka-arrow-left"></i>','<i class="icon-poka icon-poka-arrow-right"></i>'],
        responsive:{
            0:{
                items:2,
                margin:10
            },
            780:{
                items:3
            },
            971:{
                items:4
            }
        }
    })

    //Social share
    $('.post-share .social li a:not(.email-link)').click(function(){

        var windowWidth = $window.width();
        var windowHeight = $window.height();

        var url = $(this).attr('href');
        var winWidth = parseInt($(this).attr('data-width'));
        var winHeight = parseInt($(this).attr('data-height'));

        var winTop = (windowHeight / 2) - (winHeight / 2);
        var winLeft = (windowWidth / 2) - (winWidth / 2);
        window.open(url, 'Social Share', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);

        return false;
    });

    //Ajax search
    if( $('.search-form-ajax-input').length ){
        $.ajax({
            type: "post",
            url: ajax_var.url,
            dataType: "jsonp",
            data: "action=poka_autocompletesearch&nonce="+ajax_var.nonce,
            success: function(result){
                var inputSearchEl = $( ".search-form-ajax-input" );
                inputSearchEl.autocomplete({
                    minLength: 1,
                    source : result,
                    appendTo: inputSearchEl.parents('.search-form-ajax')
                })
                .autocomplete( "instance" )._renderItem = function( ul, item ) {
                    return $( "<li class='custom-li-el'>" )
                    .append( "<div class='img'><a href='" + item.link + "'><img src='"+ item.image +"' alt=''/></a></div>" )
                    .append( "<div class='text'><a class='title' href='" + item.link + "'>" + item.label + "</a><p>" + item.promo_title + "</p><div class='row row-sm'><div class='col-6'><a rel='nofollow' target='_blank' href='" + item.afflink + "' class='btn btn--green'>"+ item.playnowtext +"</a></div><div class='col-6'><a href='" + item.link + "' class='btn btn--blue'>"+ item.reviewtext +"</a></div></div></div>" )
                    .appendTo( ul );
                };

            }
        });
    }

    //rating icons
    if( ajax_var.rating_icons.length ){
        var icon_full = $.parseHTML( ajax_var.rating_icons.full_star ).closest('span').remove();
        var icon_empty = $.parseHTML( ajax_var.rating_icons.empty_star ).closest('span').remove();
    } else {
        var icon_full = '<i class="icon-poka icon-poka-full-star">';
        var icon_empty = '<i class="icon-poka icon-poka-empty-star">';
    }

    if( $('.rating-user').length > 0 ) {
        var ratingScreenshot = $('.rating-user').html();
    }
    if( !window.matchMedia("(max-width: 991px)").matches ) {
        //User ratings
        $('.rating-user>.star').mouseenter( function(){ ratingUserDrawStars( $(this) ); } );
        $('.rating-user').mouseleave(
            function(){
                $('.rating-user').html(ratingScreenshot);
                $('.rating-user>.star').mouseenter( function(){ ratingUserDrawStars( $(this) ); } );
        });
    }

    function ratingUserDrawStars( el ){
        if( !el.parent().hasClass('user-rated') ){
            el.parent().find('.star').removeClass('full-star').html( icon_empty );
            el.prevAll().andSelf().addClass('full-star').html( icon_full );
        }
    }

    $(".rating-user").on('click' , '>.star' , function(){

        var el = $(this);

        if( !$(this).hasClass('user-rated') ){

            // Retrieve post ID from data attribute
            var post_id = el.parent().attr('data-post-id');

            if( el.parent().attr('data-log') == "no" ){
                el.parent().addClass('animated wobble');
            }

            var user_rating = el.parent().find('.full-star').length;

            // Ajax call
            $.ajax({
                type: "post",
                url: ajax_var.url,
                data: "action=poka_rating&nonce="+ajax_var.nonce+"&review_rating=&post_id="+post_id+"&user_rating="+user_rating,
                success: function(result){
                    // If vote successful
                    el.parent().removeClass('animated wobble');
                    console.log(result);
                    if(result != "already" && result != "login") {
                        el.parent().addClass('animated tada');
                        el.prevAll().andSelf().html( icon_full );
                        var num = parseInt(el.parent().next('.rating-counter').find('span').text());
                        //console.log(num);
                        el.parent().next('.rating-counter').find('span').text( num+1 );
                        el.parents('.clearfix').find('.rating-msg').text( ajax_var.msg_success ).addClass('success').removeClass('error');
                    }
                    if(result == "login") {
                        $('html,body').animate({"scrollTop":$('.login-register').offset().top});
                    }
                    if(result == "already") {
                        el.parent().addClass('animated wobble');
                        el.parents('.clearfix').find('.rating-msg').text( ajax_var.msg_error ).addClass('error').removeClass('success');
                    }
                }
            });
            el.parent().addClass('user-rated');

        }

        return false;
    })

    var $jsNewsAjaxLoadMore = $('.jsNewsAjaxLoadMore');
    if( $jsNewsAjaxLoadMore.length > 0 ) {
        $jsNewsAjaxLoadMore.on('click' , function(e) {
            e.preventDefault();
            var $this           = $(this);
            var cat             = $this.attr('data-cat');
            var offset          = $this.attr('data-offset');
            var descrExcerpt    = $this.attr('data-descr-excerpt');
            var descrLength     = $this.attr('data-descr-length');
            var $newsWrapper    = $this.parents('.news-list');
            $this.find('.spinner').addClass('visible');
            $this.addClass('disabled');

            $.ajax({
                type: "post",
                url: ajax_var.url,
                data: "action=poka_ajax_load_more_news&cat="+cat+"&offset="+offset+"&descr_excerpt="+descrExcerpt+"&descr_length="+descrLength,

                success: function(result){

                    $this.find('.spinner').removeClass('visible');
                    $this.removeClass('disabled');
                    result = $.parseJSON(result);

                    $newsWrapper.find('.row').append( result.html );
                    if( result.new_offset ) {
                        $this.attr('data-offset' , result.new_offset);
                    } else {
                        $this.remove();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

        });
    }

    var $stickySidebar          = $('.jsStickySidebar');
    var wasStickyInitialized    = false;

    if( $stickySidebar.length > 0 ) {
        //If is desktop initialize sticky
        if( !window.matchMedia("(max-width: 767px)").matches ) {
            stickyInit();
        }

        $(window).on('resize' , function(){
            //Using a timeout for the case of user constantly resizing
            setTimeout( function() {
                //If is mobile destroy sticky
                if(window.matchMedia("(max-width: 767px)").matches) {
                    if( wasStickyInitialized )
                        stickyDestroy();
                } else  {
                    //If is desktop again re-initialize
                    if( !wasStickyInitialized )
                        stickyInit();
                }
            }, 600);
        });
    }

    function stickyInit() {
        $stickySidebar.stick_in_parent({
            inner_scrolling : false,
            offset_top      : 50
        });
        wasStickyInitialized = true;
    }

    function stickyDestroy() {
        $stickySidebar.trigger('sticky_kit:detach');
        $stickySidebar = null;
        $stickySidebar = $('.jsStickySidebar');
        wasStickyInitialized = false;
    }

    /**
    Table filters
     */
    var tableDefaultOrder = "asc";

    $('.table-header .btn-sort').on('click',function(e){

        e.preventDefault();

        sortTableFunc( $(this), 'btn-sort' );

    });

    $('.table-header .btn-order').on('click',function(e){

        e.preventDefault();

        sortTableFunc( $(this), 'btn-order' );

    });

    function sortTableFunc( $that, $btnType ){

        var sortType = null;

        if( $that.hasClass('active') )
            return;

        if( $that.parents('.table-s2').length ){
            var $parent = $that.parents('.table-s2');
            var $table_style = "style2";
        } else {
            var $parent = $that.parents('.table-s1');
            var $table_style = "style1";
        }

        if( $btnType === 'btn-sort' ){
            $parent.find('.btn-sort').removeClass('active');
            $that.addClass('active');

            if( $that.hasClass('btn-sort-name') ){
                sortType = sortName;
                tableDefaultOrder = "asc";
            } else if( $that.hasClass('btn-sort-rating') ){
                sortType = sortRating;
                tableDefaultOrder = "desc";
            } else if( $that.hasClass('btn-sort-date') ){
                sortType = sortDate;
                tableDefaultOrder = "asc";
            }

            //change the sorting order of the buttons
            $parent.find('.btn-order').removeClass('active');
            if( tableDefaultOrder === "asc" ){
                $parent.find('.btn-order-asc').addClass('active');
            } else {
                $parent.find('.btn-order-desc').addClass('active');
            }
        }

        if( $btnType === 'btn-order' ){
            $parent.find('.btn-order').removeClass('active');
            $that.addClass('active');

            if( $parent.find('.btn-sort.active').hasClass('btn-sort-name') ){
                sortType = sortName;
            } else if( $parent.find('.btn-sort.active').hasClass('btn-sort-rating') ){
                sortType = sortRating;
            } else if( $parent.find('.btn-sort.active').hasClass('btn-sort-date') ){
                sortType = sortDate;
            }

            if( $parent.find('.btn-order.active').hasClass('btn-order-asc') ){
                tableDefaultOrder = "asc";
            } else {
                tableDefaultOrder = "desc";
            }
        }

        $parent.find('.item').sort(sortType).appendTo($parent);
    }

    function sortName(a,b){
        var a  = $(a).data('sort-name').toLowerCase();
        var b  = $(b).data('sort-name').toLowerCase();

        if( tableDefaultOrder === 'asc' ){
            return a < b ? -1 : 1;
        } else {
            return a < b ? 1 : -1;
        }
    }

    function sortRating(a,b){
        var a  = $(a).data('sort-rating');
        var b  = $(b).data('sort-rating');

        if( tableDefaultOrder === 'asc' ){
            return a < b ? -1 : 1;
        } else {
            return a < b ? 1 : -1;
        }
    }

    function sortDate(a,b){
        var a  = $(a).data('sort-date');
        var b  = $(b).data('sort-date');

        if( tableDefaultOrder === 'asc' ){
            return a < b ? -1 : 1;
        } else {
            return a < b ? 1 : -1;
        }
    }


});
