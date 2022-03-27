<?php include 'includes/header.php' ?>

    <!--// MainBanner //-->
    <div id="mainbanner">
      <ul class="bxslider">
        <li><img src="images/banner1.jpg" alt="" />
          <div class="kd-caption">
            <h2>Looking For Best Trip</h2>
            <h1>We Offer Best Services</h1>
            <div class="linksection"> <a href="#">Get Deal Now</a></div>
          </div>
        </li>
        <li><img src="images/banner2.jpg" alt="" />
          <div class="kd-caption">
            <h2>We Plan Your Trip</h2>
            <h1>Best Available Choice in town</h1>
            <div class="linksection"> <a href="#">Get started now</a></div>
          </div>
        </li>
        <li><img src="images/banner3.jpg" alt="" />
          <div class="kd-caption">
            <h2>Looking For Travel Agent</h2>
            <h1>We are available 24/7</h1>
            <div class="linksection"> <a href="#">Ask Now</a></div>
          </div>
        </li>
        <li><img src="images/banner4.jpg" alt="" />
          <div class="kd-caption">
            <h2>Family Trip Planner</h2>
            <h1>Thinking like a creative</h1>
            <div class="linksection"> <a href="#">Get started now</a></div>
          </div>
        </li>
      </ul>
 
    </div>
    <!--// MainBanner //-->

    <!--// Content //-->
    <div class="kd-content">


      <!--// Page Section //-->
      <section class="kd-pagesection pb-4">
        <div class="container">
          <div class="row">

            <div class="col-md-12">
              <div class="kd-modrentitle thememargin">
                <h3>Did you know?</h3>
                <div class="kd-divider"><span><i class="fa fa-home"></i></span></div>
                <br />
                <p> The project has been able to handle some challenges to its simplest form</p>
              </div>
            </div>

            <div class="col-md-12">
                  <div class="kd-divider divider5"><span></span></div>
                    <div class="kd-userservices kd-smallview">
                        <div class="row">
                          <article class="col-md-4">
                              <i class="fa fa-folder"></i>
                              <div class="services-info">
                                <h3>Easy Record Keeping</h3>
                                <p>We have been able to deal with all level of users' data thereby avoiding data lost, data has been the most fragile substance of every organization, here our user data are kept quite with ease.</p>
                              </div>
                            </article>
                            <article class="col-md-4">
                              <i class="fa fa-database"></i>
                              <div class="services-info">
                                <h3>Data Consistency </h3>
                                <p>This has been demostrated in the process of keeping every single information uniform as it moves across a unify address and between various applications pages on the computer.</p>
                              </div>
                            </article>
                            <article class="col-md-4">
                              <i class="fa fa-lock"></i>
                              <div class="services-info">
                                <h3>High Security </h3>
                                <p>Security has been our topmost priority, here we deal with all user data putting a high security measure in place, to authenticate all processing throughout the project </p>
                              </div>
                            </article>
                            <article class="col-md-4">
                              <i class="fa fa-thumbs-o-up"></i>
                              <div class="services-info">
                                <h3>Easy to Handle </h3>
                                <p>The project has been made so flexible and easy to understand by anyone, thereby more frequent and farmiliar words are used, to avoid complications is its area of operations. </p>
                              </div>
                            </article>
                            <article class="col-md-4">
                              <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                              <div class="services-info">
                                <h3>Data Redundancy</h3>
                                <p>Data redundancy has been avoided to some extent, there all unwanted data are cleared off, and duplicate user data in many places of operation of the project has be controlled to avoid issue that might result. </p>
                              </div>
                            </article>
                            <article class="col-md-4">
                              <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                              <div class="services-info">
                                <h3>Less Human Error </h3>
                                <p>With little or less human effort, the processes has been automate to produce a high quality result to the user with unnoticiable error. </p>
                              </div>
                            </article>
                        </div>
                      </div>
              </div>
            </div>

          </div>
      </section>
      <!--// Page Section //-->


      <!--// Page Section //-->
      <section class="kd-pagesection">
        <div class="container">
          <div class="row">

            <div class="col-md-12">
              <div class="kd-modrentitle thememargin">
                <h3>LATEST STORY UPDATE</h3>
                <div class="kd-divider"><div class="short-seprator"><span><i class="fa fa-home"></i></span></div></div>
                <br />
                <p>Lets others explore on your behalf, and get the full report at the comfort of your home </p>
              </div>
            </div>

            <div class="col-md-12">
              <div class="kd-services">
                <div class="row">
                  <?php 
                    $rw = $connect2db->prepare("SELECT * FROM story WHERE status=? order by id DESC LIMIT 4");
                    $rw->execute([1]);
                    if($rw->rowcount() <1){
                    }else{
                      while($row = $rw->fetch() ){
                        $getImage = $connect2db->prepare("SELECT file FROM story_file WHERE story_id = ? and type = ? ORDER BY rand()");
                          $getImage->execute([$row['id'], 'image']);
                          $image = $getImage->fetch()['file'];
                        ?>

                    
                  <article class="col-md-6">
                    <figure><a href="#"><img src="../story_files/<?php echo $image?>" alt=""></a></figure>
                    <div class="kd-serviceinfo">
                      <h2><a href="#"><?php echo $row['title']; ?></a></h2>
                      <div>
                        <?php echo substr($row['description'],0,170) .'...'; ?>
                      </div>
                      <a href="blog_details?slug=<?php echo $row['slug'] ;?>" class="kd-readmore thbg-colorhover">Read more</a>
                    </div>
                  </article>
                  <?php }
                      }
                    ?>
                    
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>
      <!--// Page Section //-->

      <!--// Page Section //-->
      
      <!--// Page Section //-->



      

      <!--// Page Section //-->
      
      <!--// Page Section //-->

      <!--// Page Section //-->
      <!-- <section class="kd-pagesection" style="background: url(extraimages/trip-gallerybg.jpg); background-size: cover; padding: 40px 0px 40px 0px; ">
        <div class="container">
          <div class="row">

            <div class="col-md-12">
              <div class="kd-modrentitle thememargin">
                <h3>Send Us Email</h3>
                <div class="kd-divider"><div class="short-seprator"><span><i class="fa fa-building"></i></span></div></div>
                <br />
                <p>Let us know how we can improve the project </p>
              </div>

              <div id="respond">
                      <?php 
                          if(isset($_POST['comment_btn'])){
                            if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['comment_box'])){
                              echo "<script> alert ('All field required');window.location='index'; </script>";
                              exit();
                            }else{
                              $name =trim($_POST['name']);
                              $email=trim($_POST['email']);
                              $comment = trim($_POST['comment_box']);

                              $qs = $connect2db->prepare("INSERT INTO feedback(name,email,text) VALUES(?,?,?)");
                              $qs->execute([$name,$email,$comment]);
                              if($qs){
                                echo "<script> alert ('Successful ! Thanks for your information ...');window.location='index'; </script>";
                                exit();
                              }else{
                                echo "<script> alert ('Error, something went wrong, try later');window.location='index'; </script>";
                                exit();
                              }
                            }
                          }
                          
                          ?>
                      <form method="post">
                        <p><input type="text" placeholder="Name *" name="name"></p>
                        <p><input type="text" placeholder="Email *" name="email"></p>
                        <p class="kd-textarea"><textarea placeholder="add your comment" name="comment_box"></textarea></p>
                        <p class="kd-button"><input type="submit" name="comment_btn" value="Submit" class="thbg-color"></p>
                      </form>
                  </div>


            </div>

          </div>
        </div>
      </section> -->
      <!--// Page Section //-->

    </div>
    <!--// Content //-->
<?php include 'includes/footer.php'; ?>
  </body>

</html>