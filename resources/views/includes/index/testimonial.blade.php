<!-- TESTIMONIAL AREA START -->
<section id="testimonial">
<div class="testimonial-area pb-50">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="testimonial">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-6">
                            <div class="section-title mb-30">
                                <br>
                                <br>
                                <br>
                                <?=get_value_condition("content_rch","tbl_content_txt","id=7")?>
                            </div>
                            <div class="testimonial-carousel dots-right-btm">
                                <!-- testimonial-item -->
                                <?php
                                $testimonial_query = select_db("tbl_testimonials", '*', "","(1=1)",2);
                                while($testimonial = mysqli_fetch_array($testimonial_query)){
                                ?>
                                <!-- testimonial-item -->
                                <div class="testimonial-item">
                                    <div class="testimonial-brief">
                                        <?=$testimonial['testimonial_rch'];?>
                                        <br/>
                                    </div>
                                    <?=$testimonial['name_rch'];?>
                                    <br/>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="testimonial-image">
                                <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/content/<?=get_value_condition("content_img","tbl_content_img","id=3")?>" alt="Testimonial Legarda Place">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<!-- TESTIMONIAL AREA END -->