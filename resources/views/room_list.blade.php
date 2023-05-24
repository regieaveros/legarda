<?php

	include 'admin/functions/fn_connect.php';
	include 'admin/functions/fn_main.php';

	session_start();

?>

@extends('layouts.template')

@section('title')

	<?=get_value_condition("website_name_str","tbl_detail","id=1")?>

@endsection

@section('icon')

    <link rel="icon" type="image/png" href="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/favicon/<?=get_value_condition("favicon_img","tbl_detail","id=1")?>">

@endsection

@section('content')
	
    <!-- Start page content -->
    <section id="page-content" class="page-wrapper">

        <!-- PROPERTIES DETAILS AREA START -->
        <?php

            if(isset($_GET["id"])){
                $room_id = addslashes(strip_tags($_GET["id"]));
                $room_query = select_db("tbl_rooms", '*', "","(id=".$room_id.") ORDER BY id DESC LIMIT 1",2);
                $room = mysqli_fetch_array($room_query);

        ?>
        
        <div class="properties-details-area pt-115 pb-60">
            <div class="container">
                <h2><?=$room["room_name_str"]?></h2>
                <div class="row">
                    <div class="col-md-8">
                        <!-- pro-details-image -->
                        <div class="pro-details-image mb-60">
                            <div class="pro-details-big-image">
                                <div class="tab-content">
                                    <?=get_gallery("album",$room["album_gal"],1);?>
                                </div>
                            </div>

                            <div class="pro-details-carousel">
                                <?=get_gallery("album",$room["album_gal"],2);?>
                            </div>   
                        </div>
                        
                        <?=$room['details_rch']?>

                        <!-- pro-details-feedback -->
                        <div class="pro-details-feedback mb-40">
                            
                            <?=$room['feedback_rch']?>
                            
                        </div>
                    </div>
                    <div class="col-md-4"> 

                        <aside class="widget widget-featured-property">
                            <?=get_value_condition("content_rch","tbl_content_txt","id=15")?>
                            <div class="row"> 
                                <!-- flat-item -->
                                <?php
                                $room_query = select_db("tbl_rooms", '*', "","(1=1) ORDER BY RAND() LIMIT 4",2);
                                while($room = mysqli_fetch_array($room_query)){
                                ?>
                                <div class="col-md-12">
                                    <div class="flat-item service-item">
                                        <div class="flat-item-image">
                                            <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/room/<?=$room["room_img"]?>" alt="<?=$room["alternative_text_str"]?>">
                                            <div class="flat-link">
                                                <a href="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>room_list?id=<?=$room["id"]?>">More Details</a>
                                            </div>
                                            <ul class="flat-desc">
                                                <li>
                                                    <img src="{{ asset('images/icons/4.png') }}" alt="<?=$room["alternative_text_str"]?>">
                                                    <span><?=$room["area_str"]?></span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('images/icons/5.png') }}" alt="<?=$room["alternative_text_str"]?>">
                                                    <span><?=$room["beds_int"]?></span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('images/icons/6.png') }}" alt="<?=$room["alternative_text_str"]?>">
                                                    <span><?=$room["bath_int"]?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="flat-item-info">
                                            <div class="flat-title-price">
                                                <h5><a href="{{ url('/room_list') }}"><?=$room["room_name_str"]?></a></h5>
                                                <span class="price">
                                                    
                                                    <span style="font-size: 11px; font-style: italic;"><?=($room["price_starts_bol"]==1?get_value_condition("content_rch","tbl_content_txt","id=18"):"")?></span>
                                                    
                                                    
                                                    <?=monetarize($room["price_cur"])?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </aside>

                        <!-- widget-video -->
                        <aside class="widget widget-video pt-30">
                            <?=get_value_condition("content_rch","tbl_content_txt","id=16")?>
                            <div class="properties-video">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <?=get_value_condition("video_rch","tbl_video","id=1")?>
                                </div>
                            </div>
                        </aside>
                    
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <!-- PROPERTIES DETAILS AREA END -->

    </section>

@endsection

@section('header')

    @include('includes.header_footer.header_rooms')
        
@endsection

@section('footer')

    @include('includes.header_footer.footer')
    
@endsection

@section('js')
    <script>
    
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