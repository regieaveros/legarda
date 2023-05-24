<!-- HEADER AREA START -->
<header class="header-area header-wrapper">
    <div class="header-top-bar bg-white hidden-xs" style="display:none;">
        <div class="container">
            <div class="row">

                <div class="col-md-4 col-sm-4 hidden-xs">
                    <div class="company-info clearfix">
                        <div class="company-info-item">
                            <?=get_value_condition("content_rch","tbl_content_txt","id=10")?>
                            
                        </div>
                        
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img class="header-logo-width" src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/logo/<?=get_value_condition("logo_img","tbl_logo","id=1")?>" alt="">
                        </a>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-4 hidden-xs">
                    <!--
                    <form id="searchForm" action="javascript:findInPage()">
                        <div class="input-group">
                            <input type="text" id="searchItem" class="form-control" placeholder="Search...">
                            <span class="right"><button class="btn btn-link" id="toggle-search"><i class="fa fa-search" aria-hidden="true"></i></button></span>
                        </div>
                    </form>
                    -->
                </div>
                
            </div>
        </div>
    </div>
    <div id="sticky-header" class="header-middle-area  transparent-header hidden-xs header-scroll sticky">
        <div class="container">
            <div class="full-width-mega-drop-menu">
                <div class="row">
                    <div class="col-md-12">
                        <div class="sticky-logo">
                            <a href="{{ url('/') }}">
                                <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/logo/<?=get_value_condition("logo_img","tbl_logo","id=1")?>" alt="" width="80">
                            </a>
                        </div>
                        <div class="text-center">
                            <nav id="primary-menu">
                                <ul class="main-menu">
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('/#aboutus') }}">About<span class="li-align"></span>Us</a></li>
                                    <li><a href="{{ url('/#rooms') }}">Rooms</a></li>
                                    <li><a href="{{ url('/#amenities') }}">Amenities</a></li>
                                    <li><a href="{{ url('/#location') }}">Location</a></li>
                                    <li><a href="{{ url('/#testimonial') }}">Testimonials</a></li>
                                    <li><a href="{{ url('/#contact') }}">Contact<span class="li-align"></span>Us</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="hidden-md hidden-sm hidden-xs contact-info" id="contact-time">
                            <?=get_value_condition("content_rch","tbl_content_txt","id=10")?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER AREA END -->

<!-- MOBILE MENU AREA START -->
<div id="myHeader-m" class="mobile-menu-area hidden-sm hidden-md hidden-lg header-scroll header-sticky">
    <div class="container">
        <div id="custom-row" class="row">
            <div class="col-xs-12">
                <a href="{{ url('/') }}">
                    <div id="image-m" class="pull-left" style="margin-top:-43px;">
                        <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/logo/<?=get_value_condition("logo_img","tbl_logo","id=1")?>" alt="" style="width:60px;">
                    </div>
                </a>
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/#aboutus') }}">About Us</a></li>
                            <li><a href="{{ url('/#rooms') }}">Rooms</a></li>
                            <li><a href="{{ url('/#amenities') }}">Amenities</a></li>
                            <li><a href="{{ url('/#location') }}">Location</a></li>
                            <li><a href="{{ url('/#testimonial') }}">Testimonials</a></li>
                            <li><a href="{{ url('/#contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            
        </div>
        <div class="contact-info-mobile hidden-md hidden-sm hidden-xs" id="contact-time-mobile">
            <?=get_value_condition("content_rch","tbl_content_txt","id=10")?>
        </div>
    </div>
</div>
<!-- MOBILE MENU AREA END -->
