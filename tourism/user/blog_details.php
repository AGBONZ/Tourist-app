<?php include 'includes/header.php'; 

  if(isset($_GET['slug_id'])){
    $slug_id = $_GET['slug_id'];

    $slug_cat = $connect2db->prepare("SELECT id FROM category WHERE slug=?"); $slug_cat->execute([$slug_id]);
    $cat_id = $slug_cat->fetch();
    $slug_cat_id = $cat_id['id'];
    // echo "<script> alert('$slug_cat_id') </script>";

    $rw = $connect2db->prepare("SELECT s.id as story_id, s.slug as slug, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? AND s.category_id=?");
                    $rw->execute([1, $slug_cat_id]);
                    $row = $rw->fetch();
                    $str_id =$row['story_id'];
  }else{
    $slug = $_GET['slug'];
    $rw = $connect2db->prepare("SELECT s.id as story_id, s.slug as slug, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? AND s.slug=?");
                    $rw->execute([1, $slug]);
                    $row = $rw->fetch();
                    $str_id =$row['story_id'];
  }




    if(isset($_POST['comment_btn'])){
      if(!isset($_POST['name']) || empty($_POST['name']) || isset($_POST['name'])==""){
        echo "<script> alert('Fill All Field');</script>";
      }elseif(!isset($_POST['mobile']) || empty($_POST['mobile']) || isset($_POST['mobile'])==""){ 
        echo "<script> alert('Fill All Field');</script>";
      }elseif(!isset($_POST['comment_box']) || empty($_POST['comment_box']) || isset($_POST['comment_box'])==""){ 
        echo "<script> alert('Fill All Field');</script>";
      }else{
        $name =trim($_POST['name']);
        $mobile=trim($_POST['mobile']);
        $comment = trim($_POST['comment_box']);

        $com = $connect2db->prepare("SELECT name, mobile FROM comment WHERE name=? AND comment=?");
        $com->execute([$name, $comment]);        

        // if($com->rowcount()>0){
        //     echo "<script> alert('Duplicate post, check again');window.location='blog_details?slug='<?php echo $_GET[slug]; ' </script>";
        // }else{
            $qs = $connect2db->prepare("INSERT INTO comment(name,mobile,story_id,comment) VALUES(?,?,?,?)");
          $qs->execute([$name,$mobile,$str_id,$comment]);
          if($qs){
            echo "<script> alert('Sent');</script>";
          }else{
            echo "<script> alert('Error! try later ...');</script>";
          }
         // }
 
      }
    }
    
    ?>
    <!--// Sub Header //-->
    <div class="kd-subheader">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="subheader-info">
              <h1>Blog Detail</h1>
              <!-- <p>Morbi euismod euismod consectetur. Donec pharetra, lacus at convallis maximus, arcu quam accumsan diam, et aliquam odio elit gravida mi</p> -->
            </div>
            <div class="kd-breadcrumb">
              <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Blog Details</a></li>
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
      <section class="kd-pagesection" style=" padding: 0px 0px 0px 0px; background: #ffffff; ">
        <div class="container">
          <div class="row">

              <!--// Package Detail //-->
              <div class="col-md-8">
                <div class="kd-blog-detail">
                    <figure class='detail-thumb'>
                      <?php 
                      $ws = $connect2db->prepare("SELECT file, type FROM story_file WHERE story_id=? order by id DESC LIMIT 1");
                      $ws->execute([$str_id]); $str = $ws->fetch(); if($str['type'] == 'image'){ 
                          echo "<img class='detail-thub' width='100%' height='430' src='../story_files/$str[file]'>";
                        }else{
                          echo "
                              <iframe src='../story_files/$str[file]' width='100%' height='330'  frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            ";
                          }
                        ?>
                        </figure> 

                  <div class="widget kd-gallery-widget">
                  <ul>
                    <?php 
                        $ss = $connect2db->prepare("SELECT * FROM story_file WHERE story_id=? order by id DESC");
                        $ss->execute([$str_id]);
                        if($ss->rowcount() <1){
                        echo 'Not ready ...';
                        }else{
                          while($sf = $ss->fetch() ){?>
                    <li><a href="../story_files/<?php echo $sf['file'];?>"><img src="../story_files/<?php echo $sf['file'];?>" alt="" style="width:50px;height:50px;"></a></li>
                      <?php }} ?>
                  </ul>
                </div>

                  <div class="inn-detail">
                    <div class="kd-detail-time thbg-color" ><small><?php list($y, $m, $d) = explode(':',$row['time']); echo $d; ?></small> <br> <?php echo $m; ?></div>
                    <div class="kd-rich-editor">
                      <h3><?php echo $row['title']; ?></h3>
                      <ul class="kd-detailpost-option">
                        <li>By: <a class="thcolorhover" href="#"><?php echo $row['user']; ?></a></li>
                        <li>In <a class="thcolorhover" href="#"><?php echo $row['city']; ?>,</a> <a class="thcolorhover" href="#"><?php echo $row['state']. ' of '. $row['country']; ?></a></li>
                        <li><a class="thcolorhover" href="#"><?php 
                                  $cm = $connect2db->prepare("SELECT count(id) as id FROM comment WHERE story_id=?");
                                  $cm->execute([$str_id]);
                                  if($cm->rowcount() < 1){
                                    echo '0';
                                  }else{
                                    $cm_count = $cm->fetch();
                                   echo $cm_count['id'];
                                  }
                                ?> Comments</a></li>
                      </ul>
                      <p><?php echo $row['details']; ?></p>
                      <!-- <blockquote>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et</blockquote> -->
                    </div>
                  </div>

                  <!--// User Tag //-->
                  <div class="kd-user-tag">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="kd-tag ">
                          <!-- <span><i class="fa fa-tag"></i> Tags:</span> -->
                          <ul>
                            <?php 
                              $cat_sg = $connect2db->prepare("SELECT * FROM story_features WHERE story_id = ?");
                              $cat_sg->execute([$str_id]);
                              if($cat_sg->rowcount()<1){
                                'No features';
                              }else{
                                while($rw_sg = $cat_sg->fetch()){ ?>
                                      <li style="text-transform: uppercase;"><?php echo $rw_sg['features']; ?></li>
                                  <?php 
                                }
                              }
                            ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--// User Tag //-->


                  <!--// Comments //-->
                  <?php 
                          $cmm = $connect2db->prepare("SELECT * FROM comment WHERE story_id=? order by id DESC");
                          $cmm->execute([$str_id]);
                          if($cmm->rowcount() < 1){
                            echo '<h4 class=text-warning p-3 badge badge-warning> Be the first to comment ... </h4>';
                            
                          }else{?>
                            
                  <div id="kdcomments">
                      <h2><?php echo $cm_count['id'];?> Comments</h2>
                      <ul style="height:700px;display: block; overflow: scroll;">
                      <?php 
                      $i = 0;
                            while($cmm_val= $cmm->fetch()){ $i++; //$comm_child = $cmm_val['id'] ; ?>
                        <li>
                          <div class="thumblist">
                            <ul class="<?php if($i % 2 == 0){echo 'children';}else{echo ''; } ?>">
                              
                                   
                              <li>
                                <figure><a href="#"><img alt="" src="extraimages/comment1.jpg"></a></figure>
                                <div class="text">
                                  <a href="#"><?php echo $cmm_val['name']; ?></a> 
                                  <time datetime="2008-02-14 20:00"><i class="fa fa-calendar"></i> <?php echo 
                                  date('F g Y, h:i A', strtotime($cmm_val['created_at'])); ?></time>
                                  <p><?php echo $cmm_val['comment']; ?></p>
                                  <a class="replay-btn thbg-colorhover" href="#respond">Reply</a>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                        <?php }}?>
                      </ul>
                  </div>
                  <!--// Comments //-->

                  <!--// Comment Form //-->
                  <div id="respond">
                      <h2>Leave Your Comments</h2>
                      
                      <form method="post">
                        <p><input type="text" placeholder="Name *" name="name" required></p>
                        <p><input type="text" placeholder="Phone *" name="mobile" required></p>
                        <p class="kd-textarea"><textarea placeholder="add your comment" name="comment_box" required></textarea></p>
                        <p class="kd-button"><input type="submit" name="comment_btn" value="Submit comments" class="thbg-color"></p>
                      </form>
                  </div>
                    <!--// Comment Form //-->

                </div>
              </div>
              <!--// Package Detail //-->

              <aside class="col-md-4">

                <div class="widget widget_tab">
                  

                    <!-- Nav tabs -->
                    

                    <!-- Tab panes -->
                    <div class="widget widget_categories">
                  <div class="kd-widget-title"><h2>Story Categories</h2></div>
                  <ul>
                    <?php 
                    $feat = $connect2db->prepare("SELECT * FROM category ");
                    $feat->execute();
                    if($feat->rowcount()<1){
                      echo "<li><a href='#'> No record found </a></li>";
                    }else{
                      while($features = $feat->fetch()){
                        echo "<li><a href='blog_post?slug=$features[slug]'> $features[category] </a></li>";
                      }
                    }?>
                    
                  </ul>
                </div>

                  </div>

                  <div class="widget widget-blogpost">
                    <div class="kd-widget-title"><h2>Our Latest Posts</h2></div>
                      <ul>

                  <?php 
                    $getLatest = $connect2db->prepare("SELECT * FROM story ORDER BY rand() LIMIT 0, 3 ");
                    $getLatest->execute();
                    while ($story = $getLatest->fetch()) {
                      $getImage = $connect2db->prepare("SELECT file FROM story_file WHERE story_id = ? and type = ? ORDER BY rand()");
                          $getImage->execute([$story['id'], 'image']);
                          $image = $getImage->fetch()['file'];
                      ?>

                    <li>
                      <figure><a href="#"><img src="../story_files/<?php echo $image?>" alt=""></a></figure>
                      <div class="kd-post-info">
                        <h6>
                          <a href="blog_details?slug=<?php echo $story['slug']?>">
                            <?php echo $story['title']?>
                          </a>
                        </h6>
                        <time ><?php echo $story['created_at']?></time>
                      </div>
                    </li>

                     <?php 
                    }
                  ?>
                    
                  </ul>
                </div>

                <div class="widget kd-gallery-widget">
                  <div class="kd-widget-title"><h2>Flicker Gallery</h2></div>
                  <ul>
                    <?php 
                        $ss = $connect2db->query("SELECT * FROM story_file order by rand() LIMIT 8");
                        if($ss->rowcount() <1){
                        echo 'Not ready ...';
                        }else{
                          while($sf = $ss->fetch() ){?>
                    <li><a href="../story_files/<?php echo $sf['file'];?>"><img src="../story_files/<?php echo $sf['file'];?>" alt="" style="width:50px;height:50px;"></a></li>
                      <?php }} ?>
                  </ul>
                </div>
                
              </aside>

          </div>
        </div>
      </section>
      <!--// Page Section //-->

    </div>
    <!--// Content //-->

<?php include 'includes/footer.php'; ?>
  </body>

</html>