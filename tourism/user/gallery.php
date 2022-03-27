<?php include 'includes/header.php'; 

if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 20;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $result = $connect2db->prepare("SELECT COUNT(*) FROM story_file");$result->execute();
        $total_rows = $result->fetch()[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = $connect2db->query("SELECT * FROM story_file");
?>

    <!--// Sub Header //-->
    <div class="kd-subheader">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="subheader-info">
              <h1>Gallery List</h1>
             
            </div>
            <div class="kd-breadcrumb">
              <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Gallery</a></li>
                <li><a href="#">Our Gallery</a></li>
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

              <!--// Gallery //-->
              <div class="kd-gallery-list">
                <ul class="row">
                  <?php 
                  while($row = $sql->fetch()){?>
                    <a href="../story_files/<?php echo $row['file']?>">
                      <li class="col-md-3">
                        <figure>
                          <img src="../story_files/<?php echo $row['file']?>" alt="" height="250px">
                          <figcaption><h5> Gallery List</h5></figcaption>
                        </figure>
                      </li></a>
                <?php }?>
                  
                </ul>
              </div>
              <!--// Gallery //-->

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

          </div>
        </div>
      </section>
      <!--// Page Section //-->

    </div>
    <!--// Content //-->
<?php include 'includes/footer.php'; ?>
  </body>

</html>