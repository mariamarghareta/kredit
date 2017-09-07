<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Sistem Kredit</title>

    <?php include 'import.php' ?>
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <?php include('header.php');?>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <?php include('sidebar-master.php');?>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Blank Page</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>Place your content here.</p>
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
      
      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Alvarez.is
              <a href="blank.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

  <script>
      //custom select box
      $(document).ready(function(){
            /*
            $(".sidebar-toggle-box").click(function(){

                if($("#sidebar").css('margin-left') == "0px"){
                    $("#sidebar").css("margin-left", -210);
                    $("#main-content").css('margin-left', 0);
                }else{
                    $("#sidebar").css('margin-left', 0);
                    $("#main-content").css('margin-left', 210);
                }

            });*/
            $("#menu_tanah").addClass('active');
            $("#err_msg").addClass('text-center');
            //$('#tbkaryawan').dataTable();
            $(".sldown").slideDown("slow");
            $(".slup").slideUp("slow");
            $(".slfadein").fadeIn("slow");
            $(".slhide").hide();
            $(".slshow").show();
        
      });
      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
