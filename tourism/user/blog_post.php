<?php include 'includes/header.php'; 

    $ip_addess = getHostByName(getHostName());;
                               
if (isset($_GET['pageno'])) {
$pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$no_of_records_per_page = 15;
$offset = ($pageno-1) * $no_of_records_per_page;

$result = $connect2db->prepare("SELECT COUNT(*) FROM story");$result->execute();
$total_rows = $result->fetch()[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

if (isset($_GET['category'])) {
  $cat_slug = $_GET['category'];
  $getID = $connect2db->prepare("SELECT id FROM category WHERE slug = ?");
  $getID->execute([$cat_slug]);
  $cat_id = $getID->fetch()['id'];

  $rw = $connect2db->prepare("SELECT s.id as story_id, s.slug as slug, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? AND s.category_id=? order by rand()");
  $rw->execute([1, $cat_id]);
} elseif (isset($_POST['search_btn'])) {
  if(isset($_POST['state_search']) && empty($_POST['categ_search'])){
            $state_search = $_POST['state_search'];
            // echo "<script> alert('$state_search') </script>";

            $rw = $connect2db->prepare("SELECT s.id as story_id, s.slug as slug, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? AND s.state_id=? order by rand()");
                    $rw->execute([1, $state_search]);

          }elseif(isset($_POST['categ_search']) && empty($_POST['state_search'])){
            $categ_search = $_POST['categ_search'];

            $rw = $connect2db->prepare("SELECT s.id as story_id, s.slug as slug, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? AND s.category_id=? order by rand() ");
                    $rw->execute([1,$categ_search]);
            
          }elseif(isset($_POST['categ_search']) && isset($_POST['state_search'])){
            $state_search = $_POST['state_search'];
            $categ_search = $_POST['categ_search'];

            $rw = $connect2db->prepare("SELECT s.id as story_id, s.slug as slug, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? AND s.state_id=? AND s.category_id=? order by rand()");
                    $rw->execute([1, $state_search, $categ_search]);
            
          }else{
            echo "<script>alert('Filter by state or category')</script>";
          }
} else{
  $rw = $connect2db->prepare("SELECT s.id as story_id, s.slug as slug, s.user_id as suid, s.title as title, s.description as details, s.created_at as time, u.id as userID, u.username as user, c.name AS country, st.name AS state, ct.name AS city FROM story as s JOIN users as u on s.user_id = u.id JOIN countries AS c ON s.country_id = c.id JOIN states AS st ON s.state_id = st.id JOIN cities AS ct ON s.city_id = ct.id WHERE s.status=? order by rand()");
                  $rw->execute([1]);
}




        


// Function Get State
  $st = $connect2db->prepare("SELECT s.category_id as story_cat, s.slug as story_slug, c.name as country_name, c.iso3 as ctry_code, st.name as state, st.id as state_id, ct.category as categ FROM story as s JOIN category as ct on s.category_id = ct.id JOIN countries as c on s.country_id = c.id JOIN states as st on s.state_id=st.id Group by state_id ");
  $st->execute();
      
?>
    <!--// Sub Header //-->
    <div class="kd-subheader">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="subheader-info">
              <h1>Lates From Us</h1>
              <!-- <p>Morbi euismod euismod consectetur. Donec pharetra, lacus at convallis maximus, arcu quam accumsan diam, et aliquam odio elit gravida mi</p> -->
            </div>
            <div class="kd-breadcrumb">
              <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Story</a></li>
                <li><a href="#">Latest Story</a></li>
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

            <div class="col-md-12">

              <!--// Blog Large //-->
              <div class="col-md-8">
                <div class="kd-section-title"><h3>Recent Post </h3></div>
                <div class="kd-blog-list kd-bloggrid">
                  <div class="row">
                    <?php 
                    if($rw->rowcount() <1){
                      echo 'No recent post';
                    }else{
                      while($row = $rw->fetch() ){?>
                    <article class="col-md-6">
                      <div class="bloginner">
                        <?php 
                          $story_id = $row['story_id'];
                          $getImage = $connect2db->prepare("SELECT file FROM story_file WHERE story_id = ? and type = ? ORDER BY rand()");
                          $getImage->execute([$story_id, 'image']);
                          $image = $getImage->fetch()['file'];
                        ?>
                        <figure><a href="#"><img src="../story_files/<?php echo $image?>" height="400px" width="500px"></a>
                          <figcaption><a href="#" class="fa fa-plus-circle"></a></figcaption>
                        </figure>
                        <section class="kd-bloginfo">
                          <h2><a href="blog_details?slug=<?php echo $row['slug']?>"><?php echo $row['title']; ?></a></h2>
                          <ul class="kd-postoption">
                            <li><time datetime="2008-02-14 20:00">| 
                              <?php echo $row['time']; ?>
                            </time></li>
                          </ul>
                          <p><?php echo substr($row['details'],0,200) .'...'; ?></p>
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
                              <li><a href="?story_like=<?php echo $row['story_id'];?>" name="like_btn" class="thcolorhover" style="background:transparent;"><i class="fa fa-heart-o"></i> 
                                <?php
                                  if(isset($_GET['story_like'])){
                                    $str_id = $_GET['story_like'];
                                    $lk_qr = $connect2db->query("SELECT id FROM comment_like WHERE story_id='$str_id' AND user_ip='$ip_addess'");
                                    if($lk_qr->rowcount()>0){
                                      echo "<script> window.location='blog_post'</script>";
                                    }else{
                                      $lki = $connect2db->prepare("INSERT INTO comment_like(user_ip,story_id,like_count)VALUES(?,?,?)");
                                      $lki->execute([$ip_addess, $str_id, 1]);
                                      if($lki){
                                          echo "<script> window.location='blog_post'</script>";
                                        }else{echo "<script> window.location='blog_post'</script>";
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
                                ?>
                              </a></li>
                            </ul>
                            <div class="kd-social-network">
                              <ul>
                                <a href="blog_details?slug=<?php echo $row['slug']?>" class="btn btn-info"> Read More</a>
                                
                              </ul>
                            </div>
                          </div>
                        </section>
                      </div>
                    </article>
                  <?php }} ?>
                    
                  </div>
                </div>

                <!-- Paginattion goes here -->
                <div class="pagination-wrap">
                  <div class="pagination">
                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" <?php if($pageno <= 1){ echo 'disabled'; } ?>>
                      <i class="fa fa-angle-double-left"></i>
                    </a>

                    <?php $i=0; while($i<$total_pages){ $i++; ?>
                      <a class="page-link <?php if($i == $pageno){ echo 'active'; }else{echo ' ';} ?>" href="?pageno=<?php echo $i ?>"><?php echo $i; ?></a>
                    <?php }?>

                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>" <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>><i class="fa fa-angle-double-right"></i></a>
                  </div>
                </div>
                <!-- Pagination ends here -->
              </div>
              <!--// Blog Large //-->

              <aside class="col-md-4">
                
                <div class="widget widget_search">
                  <div class="kd-widget-title"><h2>Search Widget</h2> <a href="blog_post" class="btn btn-info ml-3" style="margin-left:20px"> All post </a></div>
                  <form method="post">
                    <select name="state_search">
                      <option selected value=""> -- search by state -- </option>
                      <?php 
                        if($st->rowcount()<1){
                          echo 'No record yet';
                        }else{
                          while($stsearch = $st->fetch()){?>
                            <option value="<?php echo $stsearch['state_id'];?>"><?php echo $stsearch['state']. ', '. $stsearch['ctry_code'];?></option><?php 
                         }
                        } ?>
                    </select>
                    <select name="categ_search">
                      <option selected value=""> -- search with category -- </option>
                      <?php 
                      $ctg = $connect2db->prepare("SELECT * FROM category");$ctg->execute();
                        if($ctg->rowcount()<1){
                          echo 'No record yet';
                        }else{
                          while($ctgsearch = $ctg->fetch()){
                            echo "<option value='$ctgsearch[id]'>". $ctgsearch['category']. "</option>";
                         }
                        } ?>
                    </select>
                    <button type="submit" class="btn btn-info text-white kd-button" name="search_btn">
                    Search</button>
                  </form>
                </div>
                
                <!--  -->
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
                        echo "<li><a href='?category=$features[slug]'> $features[category] </a></li>";
                      }
                    }?>
                    
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
        </div>
      </section>
      <!--// Page Section //-->

    </div>
    <!--// Content //-->

  <?php include 'includes/footer.php'; ?>

  </body>

</html>