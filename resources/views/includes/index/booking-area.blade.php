<!-- BOOKING AREA START -->
<div class="booking-area bg-1 call-to-bg plr-140 booking-pt">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="section-title text-white">
                    <?=get_value_condition("content_rch","tbl_content_txt","id=3")?>
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="booking-conternt clearfix">
                    <div class="book-dorm text-white">
                        <?=get_value_condition("content_rch","tbl_content_txt","id=4")?>
                    </div>
                    <div class="booking-image">
                        <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/content/<?=get_value_condition("content_img","tbl_content_img","id=2")?>" alt="<?=get_value_condition("alternative_text_str","tbl_content_img","id=2")?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BOOKING AREA END -->