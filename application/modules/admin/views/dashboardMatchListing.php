 <div id="user_row_" class="lotus-title sportrow-4">
    <div class="head-matchname">
       <div class="match-head"><?php echo $type; ?></div>
       <div class="match-odds-right">
          <div class="items-up-odds">1</div>
          <div class="items-up-odds">x</div>
          <div class="items-up-odds">2</div>
       </div>
    </div>
 </div>


 <?php

   $user_type = get_user_type();
   if ($user_type == 'Operator') {
      if (isset($crickets) && !empty($crickets)) {

         foreach ($crickets as $cricket) {
            $tomorrow = date("Y-m-d", time() + 86400);
            $market_types = isset($cricket['market_types']) ? $cricket['market_types'] : array();


            if (!empty($market_types)) {
               $i = 0;
               $fancy_bets = $cricket['fancy_bets'];
               $match_bets = $cricket['match_bets'];

                
               foreach ($market_types as $market_type) {
                  $i++;
                  if ($i > 1) {
                     continue;
                  }
                  // p($market_type);
   ?>
                <div id="user_row_" class="sport_row sportrow  matchrow-<?php echo $cricket['event_id']; ?>" title="Match OODS">
                   <div class="sport_name">


                      <time><?php echo date('d M Y H:i:s', strtotime($cricket['open_date'])); ?></time>

                      <?php
                        if ($cricket['is_favourite']) { ?>
                         <span id='fav<?php echo $cricket['event_id']; ?>'><i class='fa fa-star' aria-hidden='true' onclick="favouriteSport(<?php echo $cricket['event_id']; ?>)"></i></span>

                      <?php } else { ?>
                         <span id='fav<?php echo $cricket['event_id']; ?>'><i class='fa fa-star-o' aria-hidden='true' onclick="favouriteSport(<?php echo $cricket['event_id']; ?>)"></i></span>

                      <?php }


                        ?>
                      <a href="<?php echo base_url(); ?>admin/settlement/events/settlemenEventEntry/<?php echo $cricket['list_event_id']; ?>">
                         <?php echo $cricket['event_name'] ?> </a>
                   </div>
                   <div class="match_status">

                      <?php


                        if ($market_type['inplay']) { ?>
                         <span class="inplay_txt">In-play </span>
                      <?php     } else if ($market_type['status'] == 'SUSPENDED') { ?>
                         <span class="going_inplay">Finished </span>
                      <?php     } else { ?>
                         <span class="going_inplay">Going In-play</span>
                      <?php }
                        ?>
                   </div>

                   <div class="match_odds_front">
                      <span class="back-cell" id="back-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][0]['selection_id']) ? $market_type['runners'][0]['selection_id'] : ''; ?>"><?php echo isset($market_type['runners'][0]['back_1_price']) ? $market_type['runners'][0]['back_1_price'] : ''; ?></span>


                      <span class="lay-cell" id="lay-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][0]['selection_id']) ? $market_type['runners'][0]['selection_id'] : ''; ?>"> <?php echo isset($market_type['runners'][0]['lay_1_price']) ?  $market_type['runners'][0]['lay_1_price'] : ''; ?></span>

                      <span class="back-cell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      <span class="lay-cell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                      <span class="back-cell" id="back-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][1]['selection_id']) ? $market_type['runners'][1]['selection_id'] : ''; ?>"><?php echo isset($market_type['runners'][1]['back_1_price']) ? $market_type['runners'][1]['back_1_price'] : ''; ?></span>
                      <span class="lay-cell" id="lay-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][1]['selection_id']) ? $market_type['runners'][1]['selection_id'] : ''; ?>"><?php echo isset($market_type['runners'][1]['lay_1_price']) ? $market_type['runners'][1]['lay_1_price'] : ''; ?></span>
                   </div>

                    
                    
                </div>

          <?php  }
            }
            ?>
          <?php }
      }
   } else {
      if (isset($crickets) && !empty($crickets)) {

         foreach ($crickets as $cricket) {
            $tomorrow = date("Y-m-d", time() + 86400);
            $market_types = isset($cricket['market_types']) ? $cricket['market_types'] : array();


            if (!empty($market_types)) {
               $i = 0;

               foreach ($market_types as $market_type) {
                  $i++;
                  if ($i > 1) {
                     continue;
                  }

                  // p($market_type);
            ?>
                <div id="user_row_" class="sport_row sportrow  matchrow-<?php echo $cricket['event_id']; ?>" onclick="MarketSelection(`<?php echo $market_type['market_id']; ?>`,<?php echo $cricket['event_id']; ?>,<?php echo $cricket['event_type']; ?>);" title="Match OODS">
                   <div class="sport_name">
                     

                      <time>
                         
                      <?php //echo date('d M Y H:i:s', strtotime($cricket['open_date'])); ?>
                     
                         <ul class="counter-list" id="example_<?php echo $cricket['event_id']; ?>">
                            <li><span class="days">00</span>
                               <p class="days_text">D</p>
                            </li>
                            <li class="seperator">:</li>
                            <li><span class="hours">00</span>
                               <p class="hours_text">H</p>
                            </li>
                            <li class="seperator">:</li>
                            <li><span class="minutes">00</span>
                               <p class="minutes_text">M</p>
                            </li>
                            <li class="seperator">:</li>
                            <li><span class="seconds">00</span>
                               <p class="seconds_text">S</p>
                            </li>
                         </ul>

                         <script class="source" type="text/javascript">
		var now = new Date(Date.parse('<?php echo date('d M Y H:i:s', strtotime($cricket['open_date'])); ?>'));
		
       var day = now.getDate();
		var month = now.getMonth()+1;
		var year = now.getFullYear();
		var hour = now.getHours();
		var minute = now.getMinutes();
		var seconds = now.getSeconds();



		var nextyear = month + '/' + day + '/' + year + ' '+hour+':'+minute+':'+seconds;
            

 		$('#example_<?php echo $cricket['event_id']; ?>').countdown({
			date: nextyear, // TODO Date format: 07/27/2017 17:00:00
			offset: +2, // TODO Your Timezone Offset
			day: 'Day',
			days: 'Days',
			hideOnComplete: false
		}, function (container) {
			// alert('Done!');
		});
	</script>
                      
                     </time>
                      <?php
                        if ($cricket['is_favourite']) { ?>
                         <span id='fav<?php echo $cricket['event_id']; ?>'><i class='fa fa-star' aria-hidden='true' onclick="favouriteSport(<?php echo $cricket['event_id']; ?>)"></i></span>

                      <?php } else { ?>
                         <span id='fav<?php echo $cricket['event_id']; ?>'><i class='fa fa-star-o' aria-hidden='true' onclick="favouriteSport(<?php echo $cricket['event_id']; ?>)"></i></span>

                      <?php }
                        ?>
                      <a href="javascript:;">
                         <?php echo $cricket['event_name'] ?> </a>
                   </div>
                   <div class="match_status">

                      <?php
                        if ($market_type['inplay']) { ?>
                         <span class="inplay_txt">In-play </span>
                      <?php     } else { ?>
                         <span class="going_inplay">Going In-play</span>
                      <?php }
                        ?>
                   </div>

                   <div class="match_odds_front">
                      <span class="back-cell" id="back-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][0]['selection_id']) ? $market_type['runners'][0]['selection_id'] : ''; ?>"><?php echo isset($market_type['runners'][0]['back_1_price']) ? $market_type['runners'][0]['back_1_price'] : ''; ?></span>


                      <span class="lay-cell" id="lay-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][0]['selection_id']) ? $market_type['runners'][0]['selection_id'] : ''; ?>"> <?php echo isset($market_type['runners'][0]['lay_1_price']) ?  $market_type['runners'][0]['lay_1_price'] : ''; ?></span>

                      <span class="back-cell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                      <span class="lay-cell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

                      <span class="back-cell" id="back-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][1]['selection_id']) ? $market_type['runners'][1]['selection_id'] : ''; ?>"><?php echo isset($market_type['runners'][1]['back_1_price']) ? $market_type['runners'][1]['back_1_price'] : ''; ?></span>
                      <span class="lay-cell" id="lay-cell-<?php echo $cricket['event_id']; ?>-<?php echo isset($market_type['runners'][1]['selection_id']) ? $market_type['runners'][1]['selection_id'] : ''; ?>"><?php echo isset($market_type['runners'][1]['lay_1_price']) ? $market_type['runners'][1]['lay_1_price'] : ''; ?></span>
                   </div>
                </div>

          <?php  }
            }
            ?>
 <?php }
      }
   }

   ?>