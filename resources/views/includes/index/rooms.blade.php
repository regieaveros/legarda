<!-- FEATURED FLAT AREA START -->
<section id="rooms">
<div class="featured-flat-area pt-70 room-pb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title-2 text-center">
                    <?=get_value_condition("content_rch","tbl_content_txt","id=6")?>
                </div>
            </div>
        </div>
        <div class="featured-flat">
            <div class="row">
                <!-- flat-item -->
                
                <?php
                $category_query = select_db("tbl_category", '*', "", "(1=1)", 2);
                while($category = mysqli_fetch_assoc($category_query)){
                
                    $category_idr = $category["id"];
                    $category_name = $category["display_name_str"];
                ?>
                <div class="category-container">
                    <div class="category-name">
                        <h3><?=$category_name?></h3>
                    </div>
                    <div class="room-container">
                <?php
                    $room_query = select_db("tbl_rooms", '*', "","(category_idr=".$category_idr.")",2);
                    while($room = mysqli_fetch_array($room_query)){
                ?>
                <div class="col-md-4 col-sm-6 col-xs-12">
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
                                <h5><a href="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>room_list?id=<?=$room["id"]?>"><?=$room["room_name_str"]?></a></h5>
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
                </div>
                    <?php
                }
                ?>
                
            </div>
        </div>
    </div>
</div>
</section>
<!-- FEATURED FLAT AREA END -->