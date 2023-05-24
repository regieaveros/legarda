<!-- LOCATION AREA START -->
<section id="page-content" class="page-wrapper">
    <!-- LOCATION AREA START -->
    <section id="location" class="pt-70">
        <div class="container">
            <h1 class="text-center"><b>LOCATION MAP</b></h1>
            <!-- GOOGLE MAP AREA START -->
            <div class="google-map-area">
                <iframe src="https://maps.google.com/maps?q=2327%20Legarda%20St%2C%20403%2C%20Manila%2C%201008%20Metro%20Manila&t=&z=17&ie=UTF8&iwloc=&output=embed" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen>
                </iframe>
            </div>
            
            <!-- GOOGLE MAP AREA END -->

            <div class="row">
                
                <div class="col-lg-6 col-sm-6">
                    <div class="nearby_adjust">
                        <?php
                            $ctrlm = 0;
                            $landmark_query = select_db("tbl_nearby_landmarks", '*', "","(1=1) ORDER by display_name_str ASC",2);
                           while($landmark = mysqli_fetch_array($landmark_query)) {
                        ?>
                        <img id="lm<?=$landmark["id"]?>" class="landmark_img landmark_position <?if($ctrlm == 0){echo 'active';}?>" src="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/landmark/<?=$landmark['landmark_img'];?>" width="100%" alt="<?=$landmark["alternative_text_str"]?>">
                        <?php
                            $ctrlm +=1;
                           }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="nearby_adjust">
                        <h3>Nearby Landmarks</h3>
                        <ul class="nearby_li">
                            <?php
                            $landmark_query = select_db("tbl_nearby_landmarks", '*', "","(1=1) ORDER by display_name_str ASC",2);
                            while($landmark = mysqli_fetch_array($landmark_query)){
                            ?>
                            <li class="landmark_img_target" data-img="lm<?=$landmark["id"]?>"><a><?=$landmark['display_name_str'];?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
               
            </div>

        </div>
    </section>
    <!-- LOCATION AREA END -->
</section>