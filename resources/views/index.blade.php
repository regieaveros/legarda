<?php

    include 'admin/functions/fn_connect.php';
    include 'admin/functions/fn_main.php';

    session_start();

?>
@extends('layouts.template')

@section('title')

    <?=get_value_condition("website_name_str","tbl_detail","id=1")?> | Your Ideal Place to Live!

@endsection

@section('icon')
    <link rel="icon" type="image/png" href="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/favicon/<?=get_value_condition("favicon_img","tbl_logo","id=1")?>"> 
@endsection

@section('slider')

    @include('includes.index.slider')

@endsection

@section('content')
	
    <!-- Start page content -->
    <section id="page-content" class="page-wrapper">

        @include('includes.index.home')
        @include('includes.index.about')
        @include('includes.index.rooms')
        @include('includes.index.booking-area')
        @include('includes.index.amenities')
        @include('includes.index.location')
        @include('includes.index.testimonial')
       
    </section>

@endsection

@section('header')

    @include('includes.header_footer.header')
        
@endsection

@section('footer')

	@include('includes.header_footer.footer')

@endsection

@section('js')

<script>
    //********************** OUR AMENITIES & FEATURES ***************************

    //Desktop Lightgallery
    $(document).ready(function() {

        <?php
        $amenities_s_query = select_db("tbl_amenities", '*', "","(1=1)",2);
        while($amenities_s = mysqli_fetch_array($amenities_s_query)){
        ?>
            $('#<?=$amenities_s["display_name_str"]?>').click(function(){

                $(this).lightGallery({
                    dynamic:true,
                    html:true,
                    mobileSrc:true,
                    dynamicEl:[

                        <?=get_gallery_amenities("album",$amenities_s["album_gal"]);?>

                    ]
                }); 
            });
        <?php
        }
        ?>

    });

    //Mobile Lightgallery
    $(document).ready(function() {

        <?php
        $amenities_s_query_m = select_db("tbl_amenities", '*', "","(1=1)",2);
        while($amenities_s_m = mysqli_fetch_array($amenities_s_query_m)){
        ?>

            $('#<?=$amenities_s_m["display_name_str"]?>-m').click(function(){

                $(this).lightGallery({
                    dynamic:true,
                    mobileSrc:true,
                    dynamicEl:[

                        <?=get_gallery_amenities("album",$amenities_s_m["album_gal"]);?>

                    ]
                }); 
            });
        <?php
        }
        ?>

    });

    //********************** END OF OUR AMENITIES & FEATURES ***************************
    
    $(document).ready(function(){
        //Nearby Landmark
        $('.landmark_img_target').on('mouseenter', function () {
            var data_img = $(this).attr('data-img');
            $('.landmark_img').removeClass("active");
			$('#'+data_img).addClass("active");
        });
        
        //Owl Carousel
        $('.owl-carousel').owlCarousel({
            items:1,
            margin:0,
            loop:true,
            autoHeight:true,
            autoplay:true,
            autoplayTimeout:4000
        });
      
    });
    
    function findInPage() {
	
    	var str = $("#searchItem").val();
    	//alert(str);
        var txt, i, found;
        if (str == "") {
            return false; 
        }
        // Find next occurance of the given string on the page, wrap around to the
        // start of the page if necessary.
        if (window.find) {
            // Look for match starting at the current point. If not found, rewind
            // back to the first match.
            if (!window.find(str)) {
                while (window.find(str, false, true)) {
                    n++;
                }
            } else {
                n++;
            }
            // If not found in either direction, give message.
            if (n == 0) {
                alert("Not found.");
            }
        } else if (window.document.body.createTextRange) {
            txt = window.document.body.createTextRange();
            // Find the nth match from the top of the page.
            found = true;
            i = 0;
            while (found === true && i <= n) {
                found = txt.findText(str);
                if (found) {
                    txt.moveStart("character", 1);
                    txt.moveEnd("textedit");
                }
                i += 1;
            }
            // If found, mark it and scroll it into view.
            if (found) {
                txt.moveStart("character", -1);
                txt.findText(str);
                txt.select();
                txt.scrollIntoView();
                n++;
            } else {
                // Otherwise, start over at the top of the page and find first match.
                if (n > 0) {
                    n = 0;
                    findInPage(str);
                }
                // Not found anywhere, give message. else
                alert("Not found.");
            }
        }
        return false;
    }
    
    $("#toggle-search").click(function(){
    	var search_item = $("#searchItem");
    	if(search_item.hasClass("active")){
    		search_item.removeClass("active");
    	}else{
    		search_item.addClass("active");
    	}
    	
    });
    
    
</script>

@endsection

@section('privacy')
<div class="alert alert-info alert-dismissible alert-position">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?=get_value_condition("content_rch","tbl_content_txt","id=19")?><a href="{{ url('/privacy_policy') }}">Website Privacy Notice</a>
</div>
@endsection