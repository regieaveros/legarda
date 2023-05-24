<!-- SLIDER SECTION START -->
<div class="owl-carousel owl-theme">
    <?php
    $slider_query = select_db("tbl_slider", '*', "","(1=1)",2);
    $ctr = 0;
    while($slider = mysqli_fetch_array($slider_query)) { 
    ?>
        <div class="item <?=($ctr == 0 ? "active": "")?>">
            <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/slider/<?=$slider["slider_img"]?>" title="#slider-direction-<?=$ctr?>" alt="<?=$slider["alternative_text_str"];?>" />
            <div class="slider-overlay">
                <div class="slider-text">
                    <div class="container">
                        <?=$slider["content_rch"];?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    $ctr ++;
    }
    ?>
</div>
<!-- SLIDER SECTION END -->