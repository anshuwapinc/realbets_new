<!-- <footer style="">

  <div class="copyright">

    <span>@copyright 2019</span>

  </div>

</footer> -->
<?php
$chips = getUserChips();

?>
<?php if(get_user_type() == "User")
{
  ?>
<a  class="whats-app" href="https://wa.me//919530201155" target="_blank">
    <i class="fab fa-whatsapp my-float"></i>
</a>
<?php
} ?>
<div id="chipUpdate" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header mod-header"><button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Chip Setting</h4>
      </div>
      <div class="modal-body">
        <div id="addUserMsg"></div>
        <form id="stockez_add" method="post" class="form-inline">
          <input type="hidden" name="user_id" class="form-control" required value="<?php echo get_user_id(); ?>" />
          <div class="modal-body" id="chip-moddal-body">
            <?php
            if (!empty($chips)) {
              $i = 0;
              foreach ($chips as $chip) {
                $i++;
            ?>
                <div class="fullrow">
                  <input type="hidden" name="user_chip_id[]" class="form-control" required value="<?php echo $chip['user_chip_id']; ?>" />
                  <div class="col-md-6 col-sm-6col-xs-6">
                    <div class="form-group"><label for="email">Chips Name <?php echo $i; ?>:</label><input type="text" name="chip_name[]" class="form-control" required value="<?php echo $chip['chip_name']; ?>"></div>
                  </div>
                  <div class=" col-md-6 col-sm-6col-xs-6">
                    <div class="form-group"><label for="pwd">Chip Value <?php echo $i; ?>:</label><input type="number" name="chip_value[]" class="form-control" required value="<?php echo $chip['chip_value']; ?>"></div>
                  </div>
                </div>
            <?php }
            }
            ?>

          </div>
          <div class="modal-footer">
            <div class="text-center" id="button_change">
              <div class="text-center" id="button_change">
                <button type="button" class="btn btn-success" id="updateUserChip" onclick="add_new_chip()" style="margin-bottom:10px;">Add New Chip </button>
                <button type="button" style="margin-bottom:10px;" class="btn btn-success" id="updateUserChip" onclick="submit_update_chip()"> Update Chip Setting </button>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




</div>
<?php
if ($_SESSION['my_userdata']['user_type'] == 'Master') { ?>

<footer>
    <ul class="menu-links">
      <li class="item"><a href="<?php echo base_url('payment-methods') ?>"><i class="fa fa-credit-card fanewfont"></i><span>Payment Setup</span></a></li>
      <li class="item"><a href="<?php echo base_url('admin/users/user') ?>"><i class="fa fa-users fanewfont"></i><span>Users</span></a></li>
      <li class="item home_nav_icon_footer" style="top:-3px;"><a href="<?php echo base_url(); ?>dashboard" class="site_title endcooki active"><img src="<?php echo base_url(); ?>assets/exchange/home.png"><span >Home</span></a></li>
      <li class="item"><a href="<?php echo base_url('deposit-requests'); ?>"><span class="badge badge-pill badge-primary" style="background:#000;position: absolute;right: 3px;"><?php echo empty($request_counts->count_deposit) ? "" : $request_counts->count_deposit ?></span><i class="fa fa-inr fanewfont"></i><span>Deposit Requests</span> </a></li>
      <li class="item"><a href="<?php echo base_url('withdraw-requests'); ?>"><span class="badge badge-pill badge-primary" style="background:#000;position: absolute;right: 3px;"><?php echo empty($request_counts->count_withdraw) ? "" :   $request_counts->count_withdraw ?></span><i class="fa fa-inr fanewfont"></i><span>Withdraw Requests </span></a></li>
    </ul>
  </footer>
<?php
} elseif ($_SESSION['my_userdata']['user_type'] == 'User') {
?>
  <footer>    
    <ul class="menu-links">
      <li class="item"><a href=""><i class="fa fa-gavel fanewfont"></i><span>Rules</span></a></li>
      <li class="item"><a href="<?php echo base_url('deposituser') ?>"><i class="fa fa-inr fanewfont"></i><span>Deposit</span></a></li>
      <li class="item home_nav_icon_footer" style="top:-3px;"><a href="<?php echo base_url(); ?>dashboard" class="site_title endcooki active"><img src="<?php echo base_url(); ?>assets/exchange/home.png"><span >Home</span></a></li>
      <li class="item"><a href="<?php echo base_url('withdrawuser'); ?>"><i class="fa fa-inr fanewfont"></i><span>Withdraw</span> </a></li>
      <li class="item"><a href="<?php echo base_url('refer-and-earn'); ?>"><i class="fa fa-share-alt fanewfont"></i><span>Refer & Earn </span></a></li>
    </ul>
  </footer>
<?php
}
?>


<script src="<?php echo base_url(); ?>assets/app/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/app/pnotify.js"></script>
<script src="<?php echo base_url(); ?>assets/app/menu.js"></script>
<script src="<?php echo base_url(); ?>assets/app/owl.carousel.min.js"></script>
<script src="<?php echo base_url(); ?>assets/app/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>assets/app/slick.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/app/custom.js"></script> -->
<script src="<?php echo base_url(); ?>assets/exchange/custom.js"></script>


<script>
  function myFunction() {
    var x = document.getElementById("tvshow");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
</script>
<script>
  function myFunctions() {
    var x = document.getElementById("livetv");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
</script>
<script>
  $(".alert-danger").fadeTo(5000, 500).slideUp(500, function() {
    $(".alert-danger").slideUp(500);
  });
  $(".alert-success").fadeTo(5000, 500).slideUp(500, function() {
    $(".alert-success").slideUp(500);
  });
  $(document).ready(function() {
    /*End for end cookie for refresh page dashboard*/
    $('#datatable').DataTable();
    $('#datatableResult').DataTable({
      aaSorting: [
        [5, 'DESC']
      ]
    });

  });
</script>

<script>
  $("#menu a.trigger").on("click", function(event) {
    var current = $(this).next();
    var grandparent = $(this).parent().parent();
    if ($(this).hasClass('left-caret') || $(this).hasClass('right-caret'))
      $(this).toggleClass('right-caret left-caret');
    grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
    grandparent.find('.dropdown-submenu:visible').not(current).hide();
    current.toggle();
    event.stopPropagation();
  });
  $("#menu a:not(.trigger)").on("click", function() {
    var root = $(this).closest('.dropdown');
    root.find('.left-caret').toggleClass('right-caret left-caret');
    root.find('.dropdown-submenu:visible').hide();
  });
</script>
<script>
  function openNav33() {
    document.getElementById("sidebar").style.width = "100%";
  }

  function closeNav33() {
    document.getElementById("sidebar").style.width = "0";
  }
</script>

<script>
  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
  }
</script>

<script>
  $(document).ready(function() {
    $('.owl-carousel').owlCarousel({
      items: 8,
      //itemsDesktopSmall : [1199,3],
      itemsTablet: [767, 5],
      itemsMobile: [340, 4],
      loop: true,
      margin: 10,
      responsiveClass: true,
      navigation: true,
      responsive: {
        0: {
          items: 3,
          nav: true
        },
        600: {
          items: 3,
          nav: false
        },
        1000: {
          items: 6,
          nav: true,
          loop: false,
          margin: 20
        }
      }
    })
  })

  $(document).ready(function() {
    $(".slide-toggle").click(function() {
      $(".box").animate({
        width: "toggle"
      });
    });


  });
</script>
<script>
  $(document).ready(function() {
    $('#close,.cls-btn').click(function() {
      $('#tv-box-popup').hide();
      $('.MatchTvHideShow').hide();
      $('#tvshow').hide();
      $('#livetv').hide();
    });
    $(document).on("click", ".fancyTouch", function() {
      console.log($(this).next());
      $(this).next('.myDIV').toggle();

    });
  });
</script>


<script>
  $("ul.nav-tabs a").click(function(e) {
    e.preventDefault();
    $(this).tab('show');
  });
</script>
<script>
  $(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
    if (
      $(this)
      .parent()
      .hasClass("active")
    ) {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .parent()
        .removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .next(".sidebar-submenu")
        .slideDown(200);
      $(this)
        .parent()
        .addClass("active");
    }
  });
</script>

<script>
  $('.slick', '.vertical-slider').slick({
    vertical: true,
    verticalSwiping: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
  });
</script>


<div id="passcodeModal"></div>

<script type="text/javascript">
  document.onkeydown = function(e) {
    if (event.keyCode == 123) {
      return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
      return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
      return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
      return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
      return false;
    }
  }
</script>
<script>
  function changetv(id, sr) {

    if (sr == 1 || $(".MatchTvHideShow").is(':empty')) {
      $.ajax({
        url: site_url + 'User/gettv/' + id,
        dataType: 'html',
        success: function(output) {

          $(".MatchTvHideShow").html(output);

        }
      });
    }
  }


  function showAnimated() {
    closeNav33();
    $(".MatchLiveTvHideShow").toggle();

  }
</script>
<script>
  $(document).ready(function() {
    $(".toggle-btn").click(function() {
      $("body").toggleClass("sm-nav");
    });
  });


  function showEditStakeModel() {
    $('#chipUpdate').modal('show');
  }



  function add_new_chip() {
    var html = '';
    html += '<div class="fullrow">'
    html += '<input type="hidden" name="user_chip_id[]" class="form-control" required />';
    html += '<div class="col-md-6 col-sm-6col-xs-6">';
    html += '<div class="form-group"><label for="email">Chips Name :</label><input type="text" name="chip_name[]" class="form-control" required value=""></div>';
    html += '</div>';
    html += '<div class=" col-md-6 col-sm-6col-xs-6">';
    html += '<div class="form-group"><label for="pwd">Chip Value :</label><input type="number" name="chip_value[]" class="form-control" required value=""></div>';
    html += '</div>';
    html += '</div>';

    $('#chip-moddal-body').append(html);
  }
</script>