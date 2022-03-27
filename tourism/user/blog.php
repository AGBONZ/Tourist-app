<?php include 'includes/header.php' ?>

    <!--// Sub Header //-->
    <div class="kd-subheader">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="subheader-info">
              <h1>From Us</h1>
              <!-- <p>Morbi euismod euismod consectetur. Donec pharetra, lacus at convallis maximus, arcu quam accumsan diam, et aliquam odio elit gravida mi</p> -->
            </div>
            <div class="kd-breadcrumb">
              <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Our Team</a></li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!--// Sub Header //-->

    <!--// Content //-->
    <div class="kd-content">

      <!--// Page Section //-->
      <section class="kd-pagesection" style=" padding: 50px 0px 20px 0px; ">
        <div class="container">
          <div class="row">

            <div class="col-md-8">
              <div class="kd-section-title"><h3>Latest From Us</h3></div>
              <div class="kd-blog-list kd-blogmedium">
                <div class="row">
                  <?php 
                    $rw = $connect2db->prepare("SELECT s.id as story_id, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? order by rand() DESC LIMIT 10 ");
                    $rw->execute([1]);
                    if($rw->rowcount() <1){
                      echo 'No recent post';
                    }else{
                      while($row = $rw->fetch() ){?>
                  <div class="col-md-12">
                    <div class="bloginner">
                      <figure><a href="#">
                        <?php 
                        $storyID = $row['story_id'];
                          $img_str = $connect2db->prepare("SELECT story_id, file, type FROM story_file WHERE id=?");
                          $img_str->execute([$storyID ]);
                          if($img_str->rowcount() <1){
                            echo 'No media file for this story';
                          }else{
                            while($img = $img_str->fetch()){
                              $img_file = $img['file'];
                              $img_type = $img['type']; ?>
                                <img src="../story_files/<?php echo $img_file; ?>" alt=""></a>
                                <img src="extraimages/blog1-med.jpg" alt="">
                                <figcaption><a href="#" class="fa fa-plus-circle">Hello</a></figcaption>
                            <?php
                            }
                          }
                        ?>
                        
                      </figure>
                      <div class="kd-bloginfo">
                        <h2><a href="#"><?php echo $row['title']; ?></a></h2>
                        <ul class="kd-postoption">
                          <li><a href="#" class="thcolorhover">News </a></li>
                          <li><time datetime="<?php echo $row['time']; ?>">| 
                            <?php echo date('F j, Y.  g:i a',strtotime($row['time'])); ?></time></li>
                        </ul>
                        <ul class="kd-postoption">
                          <li><a href="" ><strong>Happening </strong> </a></li>
                          <li>| <?php echo $row['city'].','. $row['state'].','. $row['country']; ?></li>
                          <li></li>
                        </ul>
                        <ul class="kd-postoption">
                          <li><a href="" ><strong>Posted by </strong> </a></li>
                          <li>| <?php echo $row['user']; ?></li>
                          <li></li>
                        </ul>
                        <p id="details" class="show-read-more"><?php echo $row['details']; ?></p>
                      </div>

                      <!-- Like and comment count -->

                        <div class="kd-usernetwork">
                          <ul class="kd-blogcomment">
                            <li><a href="#" class="thcolorhover"><i class="fa fa-comments-o"></i> 
                                <?php 
                                  $cm_id = $row['story_id'];
                                  $cm = $connect2db->prepare("SELECT count(id) as id FROM comment WHERE story_id=?");
                                  $cm->execute([$cm_id]);
                                  if($cm->rowcount() < 1){
                                    echo '0';
                                  }else{
                                    $cm_count = $cm->fetch();
                                   echo $cm_count['id'];
                                  }
                                ?>
                            </a></li>
                            <li>
                              <!-- likecount and like script ===========================================--- -->
                                <a href="?story_like=<?php echo $row['story_id']; ?>" name="like_btn" class="thcolorhover" style="background:transparent;"><i class="fa fa-heart-o"></i> 
                              <?php 
                                if(isset($_GET['story_like'])){
                                  $str_id = $_GET['story_like'];
                                  $lk_qr = $connect2db->query("SELECT id FROM comment_like WHERE story_id=$str_id");
                                  if($lk_qr->rowcount()>0){
                                    echo 'already liked';
                                  }else{
                                    $lki = $connect2db->prepare("INSERT INTO comment_like(story_id,like_count)VALUES(?,?)");
                                    $lki->execute([$str_id, 1]);
                                    if($lki){
                                      echo "<script> window.location='blog'</script>";}else{echo "<script> window.location='blog'</script>";
                                    }
                                  }
                                }else{
                                      $lk_id = $row['story_id'];
                                      $lk = $connect2db->prepare("SELECT count(id) as id FROM comment_like WHERE story_id=?");
                                      $lk->execute([$lk_id]);
                                      if($lk->rowcount() < 1){
                                        echo '0';
                                      }else{
                                        $lk_count = $lk->fetch();
                                       echo $lk_count['id'];
                                      }
                                    }
                                ?></a>
                            </li>
                            <!-- Like end here=============================================------ -->
                          </ul>
                        </div>

                        <!-- Comment box and Comment Script ==================================---- -->
                        <p id="respond"><strong> </strong></p>
                        <?php 
                          if(isset($_POST['comment_btn'])){
                            if(empty($_POST['comment_box'])){
                              echo "comment box cannot be empty";echo "<script> window.location='blog'</script>";
                              exit();
                            }else{
                              $comment = trim($_POST['comment_box']);
                              $story_id = trim($_POST['story_id']);
                              $qs = $connect2db->prepare("INSERT INTO comment(story_id,comment) VALUES(?,?)");
                              $qs->execute([$story_id, $comment]);
                              if($qs){
                                echo "Done";echo "<script> window.location='blog'</script>";
                                exit();
                              }else{
                                echo 'Error! try later ...';echo "<script> window.location='blog'</script>";
                                exit();
                              }
                            }
                          }
                          
                          ?>
                      <div class="kd-usernetwork">
                          <form method="post" id="<?php echo $row['story_id']; ?>" class="comment_form">
                            <input type="hidden" name="story_id" class="uni" id="story_id<?php echo $row['story_id']; ?>" value="<?php echo $row['story_id']; ?>">
                            <div class="form-group">
                              <label>&nbsp; </label>
                              <textarea class="form-control comment_uni" name="comment_box" id="comment_box<?php echo $row['story_id']; ?>" placeholder="Drop Your Comment"></textarea>
                            </div>
                            <div class="form-group">
                              <button class="btn btn-info btn_comment" name="comment_btn" id="comment_btn<?php echo $row['story_id']; ?>"> submit</button>
                            </div>
                          </form>
                      </div>

                      <!-- Commence box ends here =====================================---------- -->
                    </div>
                  </div>
                <?php }} ?>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              
              <div class="kd-bookingtab">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-building"></i></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <marquee direction="up">
                  <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="kd-booking-list"><h2>Book hotel</h2>
                      <ul>
                        <li><i class="fa fa-check-circle"></i> No.1 for booking in our surroundings</li>
                        <li><i class="fa fa-check-circle"></i> No hidden costs</li>
                        <li><i class="fa fa-check-circle"></i> Attractive offers with price advantage</li>
                      </ul>
                    </div>
                  </div>
                  </marquee>
                  
                </div>

              </div>

            </div>

          </div>
        </div>
      </section>
      <!--// Page Section //-->

    </div>
    <!--// Content //-->

    <?php include 'includes/footer.php'; ?>

    

  </body>

</html>