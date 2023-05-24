<!-- ABOUT Legarda's Place AREA START -->
<section id="aboutus">
    <div class="about-Legarda's Place-area pt-70 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12 text-justify">
                    <?=get_value_condition("content_rch","tbl_content_txt","id=1")?>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="about-image">
                       <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/content/<?=get_value_condition("content_img","tbl_content_img","id=1")?>" alt="<?=get_value_condition("alternative_text_str","tbl_content_img","id=1")?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ABOUT Legarda's Place AREA END -->