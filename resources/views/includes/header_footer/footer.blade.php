<!-- Start footer area -->
<section id="contact">
    <footer id="footer" class="footer-area bg-2 bg-opacity-black-90">
        <div class="footer-top pt-30 pb-30 footer-adjust">
            <div class="footer-container-content">
                <div class="row">

                    <!-- footer-address -->
                    <div class="col-sm-5">
                        <div class="footer-widget">
                            <?=get_value_condition("content_rch","tbl_content_txt","id=8")?>
                        </div>
                    </div>

                    <!-- footer-contact -->
                    <div class="col-sm-4">
                        <div class="footer-widget">
                            <?=get_value_condition("content_rch","tbl_content_txt","id=9")?>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="footer-widget">
                            <?=get_value_condition("content_rch","tbl_content_txt","id=17")?>
                        </div>
                        <a href="<?=get_value_condition("link_str","tbl_widget","id=1")?>" class="footer-social-media"><i class="fa fa-facebook"></i></a>
                        <a href="<?=get_value_condition("link_str","tbl_widget","id=2")?>" class="footer-social-media"><i class="fa fa-instagram"></i></a>
                    </div>

                </div>
            </div>
        </div>
        
    </footer>
</section>
<!-- End footer area -->