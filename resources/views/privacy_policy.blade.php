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
        <div class="properties-details-area privacy-policy-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?=get_value_condition("content_rch","tbl_content_txt","id=20")?>
                    </div>
                </div>
            </div>
        </div>
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