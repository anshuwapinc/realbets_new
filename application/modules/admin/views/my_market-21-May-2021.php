<div class="right_col" role="main" style="min-height: 321px;">
   <div class="row">
      <div class="col-md-12">
         <div class="title_new_at"> My Market</div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div id="divLoading"> </div>
         <!--Loading class -->
         <div class="table-scroll" id="filterdata">
            <table class="table table-striped jambo_table bulk_action">
               <thead>
                  <tr class="headings">
                     <th>S.No. </th>
                     <th>Match Name </th>
                     <th>Date</th>
                     <th>Sport Name</th>
                     <th>Match Status </th>
                     <th>Team A </th>
                     <th>Team B </th>
                     <th>Draw </th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if (!empty($list_events)) {
                     $i = 1;
                     foreach ($list_events as $list_event) {
                  ?>
                        <tr>
                           <td><?php echo $i++; ?></td>
                           <td><a href="<?php echo base_url(); ?>dashboard/eventDetail/<?php echo $list_event->match_id; ?>"><?php echo $list_event->event_name; ?></a></td>
                           <td><?php echo date('d/m/Y h:i:s a', strtotime($list_event->market_start_time)); ?></td>
                           <td><?php echo $list_event->sport_name; ?></td>
                           <td><?php echo $list_event->market_status; ?></td>
                           <td><?php echo isset($list_event->exposure_3) ? number_format($list_event->exposure_1,1) : 0; ?></td>
                           <td><?php echo isset($list_event->exposure_2) ? number_format($list_event->exposure_2,1) : 0; ?></td>
                           <td><?php echo isset($list_event->exposure_3) ? number_format($list_event->exposure_3,1) : 0; ?></td>


                        </tr>
                     <?php }
                  } else { ?>
                     <tr>
                        <th colspan="7">No record found</th>
                     </tr>

                  <?php }
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>