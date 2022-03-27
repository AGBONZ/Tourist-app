<?php
include 'includes/connection.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Tourism System :| Home</title>

    <!-- Css Folder -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/color.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/themetypo.css" rel="stylesheet">
    <link href="css/bxslider.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <script>
    $(document).ready(function(){
        var maxLength = 300;
        $(".show-read-more").each(function(){
            var myStr = $(this).text();
            if($.trim(myStr).length > maxLength){
                var newStr = myStr.substring(0, maxLength);
                var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                $(this).empty().html(newStr);
                $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
                $(this).append('<span class="more-text">' + removedStr + '</span>');
            }
        });
        $(".read-more").click(function(){
            $(this).siblings(".more-text").contents().unwrap();
            $(this).remove();
        });
    });
    </script>
    <style>
        .show-read-more .more-text{
            display: none;
        }
    </style>
  </head>
  <body>
    
    <header id="mainheader">
      <!--// Top Baar //-->
      <div class="kd-topbar">
        <div class="container">
          <div class="row">
            <div class="col-md-7">
              <ul class="kd-topinfo">
                <li>
                  <i class="fa fa-phone"></i> Phone: +234 812 345 6789
                </li>
                <li>
                  <i class="fa fa-envelope-o"></i> <a href="#">Email: Info@tourist.center</a>
                </li>
              </ul>
            </div>
           
          </div>
        </div>
      </div>
      <!--// Top Baar //-->

      <!--// Header Baar //-->
      <div class="kd-headbar">
        <div class="container">
          <div class="row">
            <div class="col-md-3"><a href="index.html" class="logo"><img src="images/logo.png" alt=""></a></div>
            <div class="col-md-9">
              <div class="kd-rightside">
                <nav class="navbar navbar-default navigation">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                  </div>

                  <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav">
                      <li><a href="index">Home</a>
                      </li>
                      <li><a href="about-us">About Us</a></li>
                      <li><a href="blog_post">Blog</a>
                      </li>
                      <!-- <li><a href="index#team_member">Team</a> -->
                      </li>
                      <li><a href="gallery">Gallery</a>
                      </li>
                      <!-- <li><a href="index#contact-us">contact us</a></li> -->
                    </ul>
                  </div>
                    <!-- /.navbar-collapse -->
                </nav>
                <!-- <div class="kd-search">
                  <!-- <a href="#" class="kd-searchbtn" data-toggle="modal" data-target="#searchmodalbox"><i class="fa fa-search"></i></a> --
                  <!-- Modal --
                  <div class="modal fade kd-loginbox" id="searchmodalbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-body">
                          <a href="#" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                          <div class="kd-login-title">
                            <h2>Search Your KeyWord</h2>
                          </div>

                          <form>
                            <p><i class="fa fa-search"></i> <input type="text" placeholder="Enter Your Keyword"></p>
                            <p><input type="submit" value="Search" class="thbg-color"> </p>
                          </form>

                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--// Header Baar //-->

    </header>