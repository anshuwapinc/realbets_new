<style>
   .blockPage{
      border:none !important;
      background-color: unset !important; 
   }
</style>
<div class="main-content" role="main">
   <div class="main-inner">

      <section class="match-content">
         <div class="table_tittle">
            <span class="lable-user-name">
               My Market
            </span>
            <button class="btn btn-xs btn-primary" onclick="goBack()">Back</button>
            <div style="float:right">
               <span class="counter" id="counter" style="padding-right:6px">
                  15
               </span>
               <button class="btn btn-xs btn-primary" onclick="refresh_market_analysis()"> <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; Refresh</button>
            </div>
         </div>
         <!--Loading class -->
         <div class="table-scroll my_market_table">
            <?php echo $my_market_table ?>
         </div>
      </section>
   </div>
</div>

<script>
   function blockUI() {
      $.blockUI({
         message: ' <img src="<?php echo base_url() ?>spinner.gif" />'
      });
   }

   function startCounter(display) {
      setInterval(function() {
       var   count = display.text() - 1;
         display.html(count);

         if (count == 1) {
            refresh_market_analysis();
            count = 61;
         }
      }, 1000);
   }

   function refresh_market_analysis() {
      blockUI();
      $.ajax({
         url: "<?php echo base_url('refreshMarketAnalysis'); ?>",
         type: "post",
         success: function(response) {
            $.unblockUI();
            display = $("#counter").text('15');
            
            $(".my_market_table").html(response);
         }
      });
   }

   window.onload = function() {

      display = $("#counter");
      startCounter(display);
   };
</script>