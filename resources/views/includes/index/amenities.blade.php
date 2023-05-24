<!-- SERVICES AREA START -->
<section id="amenities">
<div class="services-area pt-70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title-2 text-center">
                    <?=get_value_condition("content_rch","tbl_content_txt","id=2")?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $amenities_query = select_db("tbl_amenities", '*', "","(1=1)",2);
            while($amenities = mysqli_fetch_array($amenities_query)){
            ?>
            <div class="col-sm-3 hidden-xs">
                <div class="service-item" id="<?=$amenities["display_name_str"]?>">
                    <div class="service-item-image">
                        <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/icon/<?=$amenities["icon_img"]?>" alt="<?=$amenities["alternative_text_str"]?>">
                    </div>
                    <div class="service-item-info">
                        <h5 class="text-center"><a><?=$amenities["amenities_name_str"]?></a></h5>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <!-- Mobile Lightgallery -->
            <div class="hidden-sm hidden-md hidden-lg">
                <?php
                $amenities_query_m = select_db("tbl_amenities", '*', "","(1=1)",2);
                while($amenities_m = mysqli_fetch_array($amenities_query_m)){
                ?>
                <div class="col-2 service-item icon-mb-10" id="<?=$amenities_m["display_name_str"]?>-m">
                    <div class="service-item-image">
                        <img src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/icon/<?=$amenities_m["icon_img"]?>" alt="<?=$amenities["alternative_text_str"]?>">
                    </div>
                    <p class="text-center"><small><?=$amenities_m["amenities_name_str"]?></small></p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
</section>
<!-- SERVICES AREA END -->
