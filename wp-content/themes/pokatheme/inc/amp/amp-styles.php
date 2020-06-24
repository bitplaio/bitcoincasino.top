<?php

//Here goes all the custom css
function poka_amp_my_additional_css_styles( $amp_template ) {
	// only CSS here please...
    $bg_color = (get_field('amp_background_color','options')) ? get_field('amp_background_color','options') : "#0a0a0a";
    $blue_color = (get_field('color_blue','options')) ? get_field('color_blue','options') : "#2d739b";
    $green_color = (get_field('color_green','options')) ? get_field('color_green','options') : "#559f3d";
    $font_color = (get_field('main_font_color','options')) ? get_field('main_font_color','options') : "#2d2d2c";
    $red_color = (get_field('color_red','options')) ? get_field('color_red','options') : "#d02d21";
    ?>
    @font-face {
        font-family: 'poka';
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/poka.eot');
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/poka.eot?#iefix') format('embedded-opentype'),
            url('<?php echo get_template_directory_uri(); ?>/fonts/poka.woff') format('woff'),
            url('<?php echo get_template_directory_uri(); ?>/fonts/poka.ttf') format('truetype'),
            url('<?php echo get_template_directory_uri(); ?>/fonts/poka.svg#poka') format('svg');
        font-weight: normal;
        font-style: normal;
        font-display:swap;
    }
    .icon-poka {
        display:inline-block;
        vertical-align:middle;
        line-height:1;
    }
    .icon-poka:before{
        display: inline-block;
        font-family: 'poka';
        font-style: normal;
        font-weight: normal;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .icon-poka-empty-star:before{content:'\0041';}
    .icon-poka-half-star:before{content:'\0042';}
    .icon-poka-full-star:before{content:'\0043';}
    .icon-poka-arrow-up:before{content:'\0044';}
    .icon-poka-facebook:before{content:'\0045';}
    .icon-poka-twitter:before{content:'\0046';}
    .icon-poka-youtube:before{content:'\0047';}
    .icon-poka-instagram:before{content:'\0048';}
    .icon-poka-facebook-simple:before{content:'\0049';}
    .icon-poka-twitter-simple:before{content:'\004a';}
    .icon-poka-envelope:before{content:'\004b';}
    .icon-poka-calendar:before{content:'\004c';}
    .icon-poka-alphabetical:before{content:'\004d';}
    .icon-poka-solid-arrow-right:before{content:'\004e';}
    .icon-poka-play:before{content:'\004f';}
    .icon-poka-list:before{content:'\0050';}
    .icon-poka-plus:before{content:'\0051';}
    .icon-poka-arrow-down:before{content:'\0052';}
    .icon-poka-arrow-right:before{content:'\0053';}
    .icon-poka-arrow-left:before{content:'\0054';}
    .icon-poka-menu:before{content:'\0055';}
    .icon-poka-play-solid:before{content:'\0056';}
    .icon-poka-check:before{content:'\0057';}
    .icon-poka-check-solid:before{content:'\0058';}
    .icon-poka-check-alt:before{content:'\0059';}
    .icon-poka-search:before{content:'\005a';}
	html {
	    background:#fff;
	}
	body {
	    font-family: sans-serif;
	    font-weight:400;
	    font-size:14px;
	    line-height:1.5em;
	    color:<?php echo $font_color; ?>;
	}
    div, div:before, div:after, a, a:before, a:after {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    p:empty { display:none; }
    a, a:visited {
        color: <?php echo $blue_color; ?>;
    }
    h1, h2, h3, h4, h5, h6 {
        margin:0;
    }
	.amp-header {
	    background: <?php echo $bg_color; ?>;
	    padding:11px 0;
	    position:relative;
	}
	.amp-logo {
	    width:100px;
	    height:46px;
	    display:block;
	    position:relative;
	    margin:0 auto;
	}
    .amp-logo-img img {
        object-fit: contain;
    }
    .amp-toggle-menu {
        position:absolute;
        font-size:20px;
        color:#fff;
        right:15px;
        top:50%;
        line-height:1em;
        margin-top:-10px;
        background:none;
        border:0 none;
        cursor:pointer;
    }
    .amp-toggle-menu .icon-poka {
        font-size: 18px;
        color: #fff;
    }
    #sidemenu {
        box-shadow: 7px 0 7px rgba(0,0,0,0.1);
    }
    #sidemenu ul {
        margin:0;
    }
    #sidemenu>ul a {
        padding:10px 20px;
        font-size:14px;
        color:#444;
        border-bottom:1px solid #ccc;
    }
    #sidemenu>ul>li ul a {
        padding-left:30px;
    }
    #sidemenu>ul>li ul li ul a  {
        padding-left:40px;
    }
    #sidemenu ul li {
        display:block;
        min-width:200px;
    }
    #sidemenu ul li a {
        text-decoration:none;
        display:block;
    }
    #sidemenu>ul li>.sub-menu {
        display:none;
    }
    #sidemenu>ul li:hover>.sub-menu {
        display:block;
    }
    #sidemenu>ul li.menu-item-has-children {
        position:relative;
    }
    #sidemenu>ul li.menu-item-has-children:after {
        content: "\f053";
        font-family: FontAwesome;
        position:absolute;
        top:8px;
        right:4px;
        font-size:16px;
        width:26px;
        height:26px;
        text-align:center;
        line-height:26px;
        display:block;
        opacity:.3;
        transform:rotate(-90deg);
    }
    #sidemenu>ul li.menu-item-has-children>a {
        padding-right:30px;
    }
    .amp-footer {
        position:relative;
        padding:20px 15px;
        border-top:1px solid #ccc;
        margin-top:40px;
    }
    .amp-footer p {
        font-size:12px;
        margin:0;
        line-height:1em;
    }
    .back-to-top {
        right:15px;
        bottom:auto;
        top:50%;
        line-height:1em;
        font-size:12px;
        margin-top:-7px;
    }
    .container {
        max-width:600px;
        position:relative;
        padding:0 15px;
        margin:0 auto;
    }
    .container:before, .container:after { content: " "; display: table; }
    .container:after { clear: both; }
    .btn {
        font-weight: bold;
        padding: .7rem 1rem;
        font-size: 18px;
        -webkit-transition: all 400ms ease;
        -moz-transition: all 400ms ease;
        -ms-transition: all 400ms ease;
        -o-transition: all 400ms ease;
        transition: all 400ms ease;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        border-radius: 5px;
        position: relative;
        overflow: hidden;
        text-decoration:none;
        max-width:300px;
    }
    .btn:hover, .btn:visited, .btn:focus {
        color:#fff;
    }
    .btn .poka-icon {
        background-color: #fff;
        color: <?php echo $green_color; ?>;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        -o-border-radius: 100%;
        border-radius: 100%;
        width: 22px;
        height: auto;
        line-height: 22px;
        text-align: center;
        font-size: 16px;
        margin-left: 0;
    }
    .btn--green {
        background: <?php echo $green_color; ?>;
        box-shadow: 0 3px 2px rgba(0, 0, 0, 0.1);
        color: #fff;
    }
    .btn--blue {
        background: <?php echo $blue_color; ?>;
        color: #fff;
    }
    .btn--full {
        display: block;
        width: 100%;
        margin:0 auto;
    }
    .row {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    .row-sm {
        margin-left: -4px;
        margin-right: -4px;
    }
    .row-sm > div {
        padding-left: 4px;
        padding-right: 4px;
    }
    .row>div {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .row>div.col-6 {
        -webkit-box-flex: 0;
        -webkit-flex: 0 0 50%;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
        width:auto;
    }
    .amp-wp-article-header h1 {
        font-size:24px;
        margin-bottom:15px;
        line-height:1.2em;
        display:block;
        flex: 1 1 100%;
    }
    .amp-wp-article-header .amp-wp-byline amp-img {
        border:0 none;
    }
    .rating {
        margin: 10px auto 15px;
    }

    .section {
        padding:30px 0;
    }
    .textarea h1 {
        font-size:24px;
        margin-bottom:20px;
    }
    .textarea h2 {
        font-size:21px;
        margin-bottom:15px;
    }
    .textarea h3 {
        font-size:18px;
        margin-bottom:15px;
    }
    .textarea h4 {
        font-size:16px;
        margin-bottom:15px;
    }
    .textarea h5 {
        font-size:14px;
        margin-bottom:10px;
    }
    .textarea h6 {
        font-size:14px;
        margin-bottom:5px;
    }
    .textarea hr {
        opacity:0.2;
        margin:20px 0;
    }
    .textarea>.container>ul, .textarea>.container>ol {
        padding-left:20px;
    }
    .textarea blockquote {
        border-color: #ccc;
    }
    .textarea>.container>table {
        width: 100%;
    }
    .textarea>.container>table>thead {
        border-bottom: 1px solid #ccc;
    }
    .textarea>.container>table>thead>th { padding: 5px 10px;  }
    .textarea>.container>table>tbody td { padding: 5px 10px; }


    .table-s1 {
        margin-bottom:20px;
        text-align:center;
    }
    .table-s1 .item > div {
        padding: 0 10px;
    }
    .table-s1 .item {
        padding: 25px 0;
        background: #f4f2ef;
        border-bottom: 2px solid #eeedeb;
        display: block;
    }
    .table-s1 .item .btn--blue {
        margin-bottom: 10px;
    }
    .table-s1 .item>div {
        position:relative;
    }
    .table-s1 .item .count {
        background: #f8f8f8;
        width: 36px;
        line-height: 36px;
        font-size: 12px;
        position: absolute;
        top: 0;
        left: 5px;
        text-align: center;
        border: 1px solid #eeedeb;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        -o-border-radius: 100%;
        border-radius: 100%;
        color: <?php echo $blue_color; ?>;
        font-weight: bold;
        text-indent: 3px;
        display: inline-block;
    }
    .table-s1 .item .c2 {
        padding: 0 50px;
    }
    .table-s1 .item .c3 {
        width: 100%;
        padding: 0 0 10px;
    }
    .rating .star  {
        display: inline-block;
        margin: 0 1px;
        background: <?php echo $blue_color; ?>;
        width: 28px;
        height: 28px;
        line-height: 27px;
        text-align: center;
        border-radius: 100%;
        vertical-align: middle;
    }
    .rating .star i {
        color: #fff;
        font-size: 14px;
        vertical-align: middle;
    }
    .table-s1 .item .c4 {
        width: 100%;
        padding: 0 20px 20px;
        text-align: center;
        padding-bottom: 20px;
    }
    .table-s1 .item .c4 .icon-poka { display:none; }
    .table-s1 .item .c4 h4 {
        font-weight: 300;
        font-size: 20px;
        margin-bottom: 5px;
    }
    .table-s1 .item .c4 h4 strong {
        color: <?php echo $green_color; ?>;
        font-weight: 700;
    }
    .table-s1 .item .c4 p {
        font-size: 13px;
        line-height: 1.5em;
        color: #2d2d2c;
        margin: 0;
    }

    .aff-single-widget {
        background: #eeedeb;
        padding: 25px 0 15px;
        text-align: center;
        margin-bottom:20px;
    }
    .aff-single-widget .img {
        padding: 0 10px;
    }
    .aff-single-widget .ratings-wrapper {
        background: rgba(0, 0, 0, 0.03);
        padding: 8px 0;
        margin-top: 15px;
    }
    .aff-single-widget .ratings-wrapper .rating {
        margin:0;
    }
    .aff-single-widget .item-bonus {
        font-size: 14px;
        color: #2d2d2c;
        max-width: 360px;
        margin: 20px auto 20px;
        padding: 0 15px;
    }
    .aff-single-widget .item-btns {
        padding: 0 15px;
    }
    .aff-single-widget .btn.btn--blue {
        margin-bottom: 10px;
    }

    .aff-single-widget-xl {
        background: rgba(0, 0, 0, 0.025);
        padding: 30px;
        text-align:center;
    }
    .aff-single-widget-xl .widget-text {
        margin-top: 20px;
    }
    .aff-single-widget-xl .widget-text .icon-poka {
        display: none;
    }
    .aff-single-widget-xl h4 {
        font-weight: 300;
        font-size: 26px;
        margin-bottom: 5px;
        color: #2d2d2c;
    }
    .aff-single-widget-xl h4 strong {
        font-weight:700;
        color:<?php echo $green_color; ?>;
    }
    .slideshow {
        margin-bottom:20px;
    }
    .slideshow .cycle-prev, .slideshow .cycle-next {
        display:none;
    }
    .slideshow .slide {
        margin-bottom:20px;
        background:rgba(0,0,0,0.05);
    }
    .slideshow .slide .table {
        padding:20px;
    }

    .news-list .item {
        width: 100%;
        max-width: 360px;
        margin: 0 auto 30px;
        background:rgba(0,0,0,0.05);
        position: relative;
    }
    .news-list .item .text {
        padding: 20px 25px 60px;
        position: relative;
    }
    .news-list .item .btn {
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        -ms-border-radius: 0;
        -o-border-radius: 0;
        border-radius: 0;
        font-size: 14px;
        font-weight: 700;
        display: block;
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
        max-width:100%;
        text-align:center;
    }
    .news-list .item .text h4 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .news-list .item .text p {
        font-size: 13px;
        line-height: 1.3em;
        margin-bottom: 0;
    }
    .casino-guide-box {
        position:relative;
        padding:20px;
        background:rgba(0,0,0,0.05);
        margin-bottom:20px;
    }
    .casino-guides .casino-guide-box .label-guide {
        color: #fff;
        background: rgba(0, 0, 0, 0.8);
        z-index: 10;
        font-size: 12px;
        font-size: 0.85714rem;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        border-radius: 5px;
        padding: 0 13px;
        line-height: 29px;
        height: 29px;
        text-align: center;
        display:inline-block;
    }
    .casino-guides .casino-guide-box .label-guide .icon-poka {
        margin-right: 7px;
        width: 13px;
        vertical-align: middle;
    }
    .casino-guides .casino-guide-box .label-guide--video .icon-poka {
        color: <?php echo $red_color; ?>;
    }
    .casino-guides .casino-guide-box .label-guide--article .icon-poka {
        color: <?php echo $blue_color; ?>;
    }
    .casino-guides .casino-guide-box a {
        text-decoration:none;
    }
    .casino-guides .casino-guide-box .text h4 {
        color: #fff;
        margin: 0;
        line-height: 1.3em;
        font-size: 18px;
        margin-top:30px;
    }
    .casino-guides .casino-guide-box .text p {
        color: <?php echo $font_color; ?>;
        margin: 0;
        line-height: 1.3em;
        font-size: 14px;
    }
    .casino-guides .casino-guide-box .text .btn {
        display:none;
    }

    .news-list-sidebar .news-sidebar-group .item {
        margin-bottom: 15px;
        overflow:hidden;
    }
    .news-list-sidebar .news-sidebar-group .item amp-img {
        width: 55px;
        float:left;
    }
    .news-list-sidebar .news-sidebar-group .item .text {
        width: calc(100% - 55px);
        float: left;
        padding-left:20px;
    }
    .news-list-sidebar .news-sidebar-group .item .text h4 {
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 7px;
        line-height: 1.3em;
    }
    .news-list-sidebar .news-sidebar-group .item .text .read-more {
        margin-bottom: 0;
        font-weight: 700;
        font-size: 12px;
        text-decoration: underline;
        color: <?php echo $font_color; ?>;
    }
    .social-list li {
        display: inline-block;
        margin-right: 6px;
    }
    .social-list li a {
        color: <?php echo $blue_color; ?>;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        -o-border-radius: 100%;
        border-radius: 100%;
        background: rgba(0, 0, 0, 0.05);
        width: 36px;
        height: 36px;
        line-height: 36px;
        text-align: center;
        display: inline-block;
        font-size: 20px;
    }
    .social-list li a .icon-poka {
        font-size: 16px;
        color: <?php echo $blue_color; ?>;
    }
    .search-form-ajax button .icon-poka {
        width: 12px;
        position: relative;
        top: 1px;
    }
    .btn--read-more {
        padding: 0.8rem 1.8rem;
        font-size: 16px;
    }
    .btn--black {
        background: #2d2a21;
    }
    .center-area {
        text-align: center;
    }
    .btn--read-more .icon-poka {
        width: 16px;
        height: 16px;
        background: none;
        border-radius: none;
        color: white;
        margin-left: 15px;
        position: relative;
        vertical-align: middle;
        top: -1px;
    }
    .aff-widget-spins {
        background: rgba(0, 0, 0, 0.025);
        text-align: center;
        padding: 25px 40px;
        box-shadow: 0 6px 9px rgba(0, 0, 0, 0.09);
        margin-bottom: 20px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        border-radius: 5px;
    }
    .aff-widget-spins p {
        font-size: 21px;
        margin:15px 0px;
    }

    .aff-single-widget-big {
        background: rgba(0, 0, 0, 0.025);
        padding: 30px;
        text-align:center;
    }
    .aff-single-widget-big h4 {
        font-weight: 300;
        font-size: 22px;
        margin-bottom: 5px;
        color: <?php echo $font_color; ?>;
    }
    .aff-single-widget-big .btn--blue {
        margin-bottom:10px;
    }
    .d-lg-block , .d-lg-flex, .d-lg-inline-block {
        display: none;
    }
    @media (max-width: 400px) {
        .btn {
            font-size:14px;
        }
    }
	<?php
    if( is_singular('affiliates') ){
    ?>
    .amp-review-top {
        background:#eeedeb;
        text-align:center;
        padding:20px 15px;
    }
    .amp-review-top .btn {
        line-height: 58px;
        padding: 0;
        font-size: 21px;
        font-size: 1.5rem;
    }
    .amp-review-top .btn .poka-icon {
        display: inline-block;
        background-color: #fff;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        -o-border-radius: 100%;
        border-radius: 100%;
        width: 22px;
        height: 22px;
        line-height: 22px;
        text-align: center;
        margin-left: 18px;
    }
    .amp-review-top .btn .poka-icon .icon-poka {
        color: <?php echo $green_color; ?>;
        font-size: 12px;
    }
    .review-bonus {
        margin-top:25px;
        margin-bottom:20px;
        padding-top:25px;
        border-top:1px solid #ccc;
        border-bottom:1px solid #ccc;
    }
    .review-bonus .item {
        margin-bottom: 25px;
    }
    .review-bonus .item h5, .review-overview h5 {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 14px;
        text-align: center;
        margin-bottom: 10px;
        line-height:1.1em;
    }
    .review-bonus h4 {
        font-size: 21px;
        font-weight: 400;
    }
    .review-bonus h4 strong {
        font-weight:700;
        color: <?php echo $green_color; ?>;
    }
    .review-bonus p {
        line-height: 1.4em;
        font-size: 13px;
    }
    .review-overview li {
        margin-bottom:15px;
        font-size:12px;
        display:block;
        line-height:1.3em;
    }
    .review-overview li strong {
        display:block;
    }
    .amp-main-content {
        padding:30px 0;
    }
    .amp-main-content h1 {
        font-size:30px;
        margin-bottom:20px;
    }
    .ups-downs {
        background-color: #eeedeb;
        padding: 40px;
        margin: 40px 0;
    }
    .ups-downs h5 {
        text-align: center;
        color: #222020;
        font-size: 16px;
        font-size: 1.14286rem;
        font-weight: 900;
        margin: 0 auto;
        margin-bottom: 20px;
        padding: 0 20px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e6e6e6;
        display: block;
    }
    .ups-downs .icon.green {
        background-color: <?php echo $green_color; ?>;
    }
    .ups-downs .icon.red {
        background-color: <?php echo $red_color; ?>;
    }
    .ups-downs .icon {
        width: 32px;
        height: 32px;
        line-height: 32px;
        color: #fff;
        text-align: center;
        position: absolute;
        left: 15px;
        top: 50%;
        margin-top: -16px;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        -o-border-radius: 100%;
        border-radius: 100%;
    }
    .ups-downs .icon .icon-poka {
        width: 15px;
        color: white;
    }
    .ups-downs ul {
        padding-left: 60px;
        margin: 15px 0;
    }
    .ups-downs ul li {
        list-style: none;
        font-size: 13px;
        font-size: 0.92857rem;
        padding-bottom: 6px;
        margin-bottom: 6px;
        border-bottom: 1px solid #e6e6e6;
        font-size:14px;
    }
    .amp-review-bottom {
        background-color: #eeedeb;
        text-align:center;
        padding:15px 0 30px 0;
    }
    .amp-review-bottom .btn .poka-icon {
        display: inline-block;
        background-color: #fff;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        -o-border-radius: 100%;
        border-radius: 100%;
        width: 22px;
        height: 22px;
        line-height: 22px;
        text-align: center;
        margin-left: 18px;
    }
    .amp-review-bottom .btn .poka-icon .icon-poka {
        color: <?php echo $green_color; ?>;
        font-size: 12px;
    }
    .amp-review-bottom h4 {
        font-size: 24px;
        padding: 20px 0;
        font-weight: 400;
    }
    .amp-review-bottom h4 strong {
        font-weight:700;
        color:<?php echo $green_color; ?>;
    }
    .slider-carousel-group h5 {
        font-size:16px;
        margin-bottom:15px;
    }
    .terms-wrapper {
        padding: 10px;
        margin-top: 10px;
        font-size: 12px;
        line-height: 1.4;
        background: rgba(0,0,0,0.05);
        border-radius: 5px;
    }
    <?php
    }
}
add_action( 'amp_post_template_css', 'poka_amp_my_additional_css_styles' );
