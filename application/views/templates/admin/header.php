<header class="">
   <div class="header-inner">
      <a onclick="openNav33();" class="bars">
         <span>
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 394.971 394.971" style="enable-background:new 0 0 394.971 394.971;" xml:space="preserve">
               <g>
                  <g>
                     <g>
                        <path d="M56.424,146.286c-28.277,0-51.2,22.923-51.2,51.2s22.923,51.2,51.2,51.2s51.2-22.923,51.2-51.2
                                          S84.701,146.286,56.424,146.286z M56.424,227.788L56.424,227.788c-16.735,0-30.302-13.567-30.302-30.302
                                          s13.567-30.302,30.302-30.302c16.735,0,30.302,13.567,30.302,30.302S73.16,227.788,56.424,227.788z"></path>
                        <path d="M379.298,187.037H143.151c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449h236.147
                                          c5.771,0,10.449-4.678,10.449-10.449S385.069,187.037,379.298,187.037z"></path>
                        <path d="M56.424,0c-28.277,0-51.2,22.923-51.2,51.2s22.923,51.2,51.2,51.2s51.2-22.923,51.2-51.2S84.701,0,56.424,0z
                                          M56.424,81.502c-16.735,0-30.302-13.567-30.302-30.302s13.567-30.302,30.302-30.302S86.726,34.465,86.726,51.2
                                          S73.16,81.502,56.424,81.502z"></path>
                        <path d="M143.151,61.649h236.147c5.771,0,10.449-4.678,10.449-10.449s-4.678-10.449-10.449-10.449H143.151
                                          c-5.771,0-10.449,4.678-10.449,10.449S137.38,61.649,143.151,61.649z"></path>
                        <path d="M56.424,292.571c-28.277,0-51.2,22.923-51.2,51.2c0,28.277,22.923,51.2,51.2,51.2s51.2-22.923,51.2-51.2
                                          C107.624,315.494,84.701,292.571,56.424,292.571z M86.726,343.771c0,16.735-13.567,30.302-30.302,30.302v0
                                          c-16.735,0-30.302-13.567-30.302-30.302c0-16.735,13.567-30.302,30.302-30.302S86.726,327.036,86.726,343.771L86.726,343.771z"></path>
                        <path d="M379.298,333.322H143.151c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449h236.147
                                          c5.771,0,10.449-4.678,10.449-10.449S385.069,333.322,379.298,333.322z"></path>
                     </g>
                  </g>
               </g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
               <g></g>
            </svg>
         </span>

      </a>
      <div class="balanceContainer">
         <a href="#" style="color:green;"><span>Balance</span><span class="mWallet"> <?php echo number_format(count_total_balance(get_user_id()), 2); ?></span></a>

         <a style="color:red;" href="<?php echo base_url(); ?>gameclientbet"><span>Exposure</span><span class="liability"><?php echo number_format(count_total_exposure(get_user_id()), 2); ?></span></a>


      </div>
      <div class="logo headerlogo">
         <a href="<?php echo base_url(); ?>dashboard" class="site_title endcooki">
            <img style="" src="<?php echo base_url(); ?>assets/app/logo.png" alt="">
         </a>
      </div>


      <div class="mike">
         <?php echo get_news(); ?>
      </div>
      <!-- <div class="notification">
         <input type="hidden" id="betNotifyVal" value="1">
         <a href="javascript:void(0)" onclick="betNotifySett()" class="betnotify"><i class="fa fa-bell fa-2x" aria-hidden="true"></i></a>

         <div class="dropdown theme-custom">
            <a class="dropdown-toggle" data-toggle="dropdown">
               <svg id="icons" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg">
                  <path d="m63 32h-10c0-5.801-2.35-11.051-6.15-14.851l7.07-7.069c5.61 5.609 9.08 13.359 9.08 21.92z" fill="#f6bb42"></path>
                  <path d="m53 32h10c0 8.55-3.46 16.3-9.08 21.909l-7.07-7.06c3.8-3.799 6.15-9.049 6.15-14.849z" fill="#8cc152"></path>
                  <path d="m53.92 53.909v.011c-5.61 5.609-13.35 9.08-21.92 9.08v-10c5.8 0 11.05-2.351 14.85-6.15z" fill="#37bc9b"></path>
                  <path d="m53.92 10.08-7.07 7.069c-3.8-3.799-9.05-6.149-14.85-6.149v-10c8.57 0 16.31 3.47 21.92 9.08z" fill="#e9573f"></path>
                  <path d="m53 32h-9.99-.01c0-3.04-1.23-5.79-3.22-7.78l7.069-7.07c3.801 3.799 6.151 9.049 6.151 14.85z" fill="#ffce54"></path>
                  <path d="m39.78 39.779 7.069 7.07c-3.799 3.8-9.049 6.151-14.849 6.151v-10c3.04 0 5.79-1.23 7.78-3.221z" fill="#48cfad"></path>
                  <path d="m32 53v10c-8.56 0-16.31-3.471-21.92-9.08l7.07-7.07c3.8 3.799 9.06 6.15 14.85 6.15z" fill="#4a89dc"></path>
                  <path d="m32 43v10c-5.79 0-11.05-2.351-14.85-6.15l7.069-7.07c1.991 1.99 4.751 3.22 7.781 3.22z" fill="#5d9cec"></path>
                  <path d="m32 11v10c-3.03 0-5.78 1.229-7.77 3.22h-.01l-7.069-7.07c3.799-3.8 9.059-6.15 14.849-6.15z" fill="#ed5565"></path>
                  <path d="m17.15 46.85-7.07 7.07c-5.61-5.61-9.08-13.36-9.08-21.92h10c0 5.8 2.35 11.05 6.15 14.85z" fill="#967adc"></path>
                  <path d="m43.01 32h9.99c0 5.8-2.35 11.05-6.15 14.85l-7.069-7.07c1.989-1.99 3.219-4.751 3.219-7.78z" fill="#a0d468"></path>
                  <path d="m17.15 17.149 7.069 7.07c-1.989 1.991-3.219 4.741-3.219 7.781h-10c0-5.801 2.35-11.051 6.15-14.851z" fill="#ec87c0"></path>
                  <path d="m24.22 39.779-7.069 7.07c-3.801-3.799-6.151-9.049-6.151-14.849h10c0 3.029 1.23 5.79 3.22 7.779z" fill="#ac92ec"></path>
                  <path d="m10.08 10.08 7.07 7.069c-3.8 3.8-6.15 9.05-6.15 14.851h-10c0-8.561 3.47-16.311 9.08-21.92z" fill="#d770ad"></path>
                  <path d="m46.85 17.149-7.069 7.07c-1.991-1.99-4.741-3.219-7.781-3.219v-10c5.8 0 11.05 2.35 14.85 6.149z" fill="#fc6e51"></path>
                  <path d="m32 1v10c-5.79 0-11.05 2.35-14.85 6.149l-7.07-7.069c5.61-5.61 13.36-9.08 21.92-9.08z" fill="#da4453"></path>
               </svg>

            </a>
            <ul class="dropdown-menu">
               <b>Theme Customizer</b>
               <li><a href="javascript:void(0);" onclick="themeChange(1)" ; class="orange-theme  <?php
                                                                                                   if (getTheme() == 1) {
                                                                                                      echo "active";
                                                                                                   } ?>" data-color="1"></a></li>
               <li><a href="javascript:void(0);" onclick="themeChange(2)" ; class="green-theme  <?php
                                                                                                if (getTheme() == 2) {
                                                                                                   echo "active";
                                                                                                } ?>" data-color="2"></a></li>
               <li><a href="javascript:void(0);" onclick="themeChange(3)" ; class="red-theme  <?php
                                                                                                if (getTheme() == 3) {
                                                                                                   echo "active";
                                                                                                } ?>" data-color="3"></a></li>
               <li><a href="javascript:void(0);" onclick="themeChange(4)" ; class="blue-theme 
               
               <?php
               if (getTheme() == 4) {
                  echo "active";
               } ?>
               " data-color="4"></a></li>
               <li><a href="javascript:void(0);" onclick="themeChange(5)" ; class="lightred-theme   <?php
                                                                                                      if (getTheme() == 5) {
                                                                                                         echo "active";
                                                                                                      } ?>" data-color="5"></a></li>
               <li><a href="javascript:void(0);" onclick="themeChange(6)" ; class="yellow-theme  <?php
                                                                                                   if (getTheme() == 6) {
                                                                                                      echo "active";
                                                                                                   } ?>" data-color="6"></a></li>
            </ul>
         </div>

         <span class="bettoggle" onclick="betopenNav()">
            <svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg">
               <path d="m184.296875 512c-4.199219 0-8.277344-1.644531-11.304687-4.691406-3.925782-3.925782-5.527344-9.582032-4.265626-14.976563l23.253907-98.667969c.679687-2.902343 2.152343-5.546874 4.265625-7.636718l203.648437-203.648438c18.109375-18.132812 49.75-18.15625 67.882813 0l30.164062 30.164063c9.066406 9.046875 14.058594 21.121093 14.058594 33.921875 0 12.820312-4.992188 24.894531-14.058594 33.941406l-203.648437 203.625c-2.113281 2.113281-4.757813 3.585938-7.636719 4.265625l-98.667969 23.253906c-1.234375.320313-2.472656.449219-3.691406.449219zm37.78125-106.582031-16.277344 69.078125 69.078125-16.277344 200.429688-200.425781c3.027344-3.03125 4.691406-7.039063 4.691406-11.308594 0-4.265625-1.664062-8.296875-4.691406-11.304687l-30.167969-30.167969c-6.25-6.226563-16.382813-6.25-22.632813 0zm60.910156 67.328125h.210938zm0 0"></path>
               <path d="m433.835938 337.898438c-4.097657 0-8.191407-1.558594-11.308594-4.691407l-75.433594-75.4375c-6.25-6.25-6.25-16.382812 0-22.632812s16.382812-6.25 22.632812 0l75.4375 75.433593c6.25 6.25 6.25 16.382813 0 22.636719-3.136718 3.132813-7.234374 4.691407-11.328124 4.691407zm0 0"></path>
               <path d="m145.921875 448h-97.921875c-26.476562 0-48-21.523438-48-48v-352c0-26.476562 21.523438-48 48-48h309.332031c26.476563 0 48 21.523438 48 48v98.773438c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-98.773438c0-8.832031-7.167969-16-16-16h-309.332031c-8.832031 0-16 7.167969-16 16v352c0 8.832031 7.167969 16 16 16h97.921875c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path>
               <path d="m389.332031 138.667969h-373.332031c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h373.332031c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path>
               <path d="m310.828125 245.332031h-294.828125c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h294.828125c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path>
               <path d="m202.667969 352h-186.667969c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h186.667969c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path>
               <path d="m202.667969 352c-8.832031 0-16-7.167969-16-16v-213.332031c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v213.332031c0 8.832031-7.167969 16-16 16zm0 0"></path>
            </svg>
         </span>
      </div> -->

      <!--<div style="display:none;"></div>-->

   </div>
</header>
<div class="main-wrapper">
   <div class="wrapper">
      <style>
         .user_bal span {
            display: block;
            margin-bottom: 5px;
         }
      </style>
      <div class="page-wrapper chiller-theme toggled ">
         <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
               <a href="javascript:void(0)" class="closebtn33" onclick="closeNav33()">×</a>
               <div class="user-card_box boxs-left">
                  <div class="user_detial">
                     <!-- <img src="https://pdmexch.com/img/user-img.png"> -->
                     <svg class="user-dummy" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                        <path class="cls-1" d="M52.2586,72.67626l6.74487,8.99455-5.05971,43.75525H5.567S5.90819,106.48062,7.83352,95.249a11.98538,11.98538,0,0,1,6.45842-8.69964c11.23157-5.599,35.87708-13.8731,35.87708-13.8731Z"></path>
                        <path class="cls-1" d="M122.433,125.42605h-47.113L68.99648,81.675l6.74487-8.99876h2.08542s24.64972,8.27413,35.88135,13.8731a11.99594,11.99594,0,0,1,6.45837,8.69964C122.09176,106.48062,122.433,125.42605,122.433,125.42605Z"></path>
                        <path class="cls-1" d="M64,64.62753h0a22.227,22.227,0,0,1-21.81889-17.987L38.78137,29.1458A23.419,23.419,0,0,1,61.98722,2.57395h4.02555A23.419,23.419,0,0,1,89.21863,29.1458L85.81891,46.64051A22.227,22.227,0,0,1,64,64.62753Z"></path>
                     </svg>
                     <span class="userName"><?php echo get_user_name(); ?></span>
                  </div>
                  <div class="user_bal">
                     <a href="#"><span>Balance</span><span class="mWallet"> <?php echo number_format(count_total_balance(get_user_id()), 2); ?></span></a>
                  </div>

                  <?php
                  if (get_user_type() == 'User') { ?>
                     <div class="user_bal" style="display: flex;
    justify-content: space-between;">
                        <a href="<?php echo base_url(); ?>gameclientbet"><span>Exposure</span><span class="liability"> <?php echo number_format(count_total_exposure(get_user_id()), 2); ?></span></a>
                        <!-- <a><span>Bonus</span><span class=""> <?php echo number_format(count_total_bonus(get_user_id()), 2); ?></span></a> -->
                     </div>
                  <?php }

                  ?>


                  <?php
                  $isDemo =  $_SESSION['is_demo'];

                  if ($isDemo == "No") {
                  ?>
                     <div class="log-pass-div">
                        <a class="logout_btn" href="<?php echo base_url(); ?>change-password">
                           Change Password
                        </a>
                     </div>
                  <?php } else { ?>
                     <div style="display: none;" class="log-pass-div">
                        <a class="logout_btn" href="<?php echo base_url(); ?>change-password">
                           Change Password
                        </a>
                     </div>
                  <?php } ?>


                  <div class="log-pass-div">
                     <a class="logout_btn active" href="<?php echo base_url(); ?>logout">
                        Log Out
                     </a>
                  </div>
               </div>
               <div class="sidebar-menu user-card_box boxs-left">
                  <ul class="nav">
                     <li class=""><a class="head-link endcooki" href="<?php echo base_url(); ?>dashboard"> <span><i class="fas fa-home"></i>Home</span></a></li>

                     <?php
                     if (get_user_type() != 'User') { ?>
                        <li class="sidebar-dropdown">



                           <a href="#"><span><i class="fas fa-users"></i></span>Client Listing</a>
                           <div class="sidebar-submenu">
                              <ul>

                                 <?php
                                 if (get_user_type() == 'Super Admin') { ?>
                                    <li><a href="<?php echo base_url(); ?>admin/users/admin"> Super Admin </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/hypersupermaster"> Admin </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/supermaster"> Super Master </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/master"> Master </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/user"> User </a> </li>

                                 <?php } else if (get_user_type() == 'Admin') { ?>

                                    <li><a href="<?php echo base_url(); ?>admin/users/hypersupermaster"> Admin </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/supermaster"> Super Master </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/master"> Master </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/user"> User </a> </li>

                                 <?php } else if (get_user_type() == 'Hyper Super Master') { ?>



                                    <li><a href="<?php echo base_url(); ?>admin/users/supermaster"> Super Master </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/master"> Master </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/user"> User </a> </li>

                                 <?php } else if (get_user_type() == 'Super Master') { ?>




                                    <li><a href="<?php echo base_url(); ?>admin/users/master"> Master </a> </li>
                                    <li><a href="<?php echo base_url(); ?>admin/users/user"> User </a> </li>
                                 <?php } else if (get_user_type() == 'Master') { ?>
                                    <li><a href="<?php echo base_url(); ?>admin/users/user"> User </a> </li>

                                 <?php }
                                 ?>

                                 <li><a href="<?php echo base_url(); ?>admin/closedusers/<?php
                                                                                          if (get_user_type() == 'Super Admin') {
                                                                                             echo 'admin';
                                                                                          } else if (get_user_type() == 'Admin') {
                                                                                             echo 'hypersupermaster';
                                                                                          } else if (get_user_type() == 'Hyper Super Master') {
                                                                                             echo 'supermaster';
                                                                                          } else if (get_user_type() == 'Super Master') {
                                                                                             echo 'master';
                                                                                          } else if (get_user_type() == 'Master') {
                                                                                             echo 'user';
                                                                                          } ?>"> Delete User </a> </li>

                              </ul>
                           </div>
                        </li>
                     <?php }
                     ?>
                     <?php
                     if (get_user_type() == 'Super Admin' || get_user_id() == '32222') { ?>
                        <li class="sidebar-dropdown">
                           <a href="#"> <span><i class="fas fa-inr"></i></span>Payments</a>
                           <div class="sidebar-submenu">
                              <ul>
                                 <li><a href="<?php echo base_url('payment-methods'); ?>">Payment Setup</a></li>
                                 <li><a href="<?php echo base_url('deposit-requests'); ?>">Deposit Requests</a></li>
                                 <li><a href="<?php echo base_url('withdraw-requests'); ?>">Withdraw Requests</a></li>
                              </ul>
                           </div>
                        </li>
                     <?php } ?>
                     <?php
                     if (get_user_type() != 'User') { ?>
                        <li class="sidebar-dropdown">
                           <a href="#"> <span><i class="fas fa-cog"></i></span>Setting</a>
                           <div class="sidebar-submenu">
                              <ul>
                                 <?php


                                 if (get_user_type() == 'Super Admin'  || get_user_id() == '32222') { ?>
                                    <li><a href="<?php echo base_url(); ?>admin/manual/event-types">Manual Odds</a></li>
                                 <?php }
                                 ?>
                                 <li><a href="<?php echo base_url(); ?>admin/blockmarket">Block Market</a></li>

                                 <?php
                                 if (get_user_type() == 'Super Admin'  || get_user_id() == '32222') { ?>
                                    <li><a href="<?php echo base_url(); ?>admin/chip">Chip</a></li>
                                 <?php }
                                 ?>
                                 <?php
                                 if (get_user_type() == 'Super Admin'  || get_user_id() == '32222') { ?>
                                    <li><a href="<?php echo base_url(); ?>admin/bettings/listmarkets">Bettings</a></li>
                                 <?php }
                                 ?>

                                 <?php
                                 if (get_user_type() == 'Super Admin'  || get_user_id() == '32222') { ?>
                                    <li><a href="<?php echo base_url(); ?>news">News</a></li>
                                 <?php }
                                 ?>

                                 <?php
                                 if (get_user_type() == 'Super Admin' || get_user_id() == '32222') { ?>
                                    <li><a href="<?php echo base_url(); ?>addfunds">Add Funds</a></li>
                                    <li><a href="<?php echo base_url('bonus-settings'); ?>">Bonus Setting</a></li>
                                    <li><a href="<?php echo base_url('welcome-note-banner'); ?>">Welcome Note Banner</a></li>
                                    <li><a href="<?php echo base_url('header-banners'); ?>">Header Banners</a></li>

                                 <?php }
                                 ?>

                              </ul>
                           </div>
                        </li>
                     <?php }
                     ?>
                     <?php
                     if (get_user_type() == 'User') { ?>
                        <li class=""><a class="head-link endcooki" href="<?php echo base_url('deposituser'); ?>"> <span><i class="fas fa-inr"></i>Deposit</span></a></li>
                        <li class=""><a class="head-link endcooki" href="<?php echo base_url('withdrawuser'); ?>"> <span><i class="fas fa-inr"></i>Withdraw</span></a></li>
                     <?php } ?>
                     <li><a href="<?php echo base_url(); ?>admin/my_market"><i class="fa fa-book" aria-hidden="true"></i>
                           Market Analysis</a></li>
                     <?php
                     if (get_user_type() == 'User') { ?>
                        <li class=""><a class="head-link endcooki" href="<?php echo base_url('transaction-history/All'); ?>"> <span><i class="fas fa-file"></i>Transaction History</span></a></li>
                        <li class=""><a class="head-link endcooki" href="<?php echo base_url('refered-users'); ?>"> <span><i class="fas fa-file"></i>Refered User</span></a></li>
                     <?php } ?>
                     <li class="sidebar-dropdown">
                        <a href="javascript:;" class="user-profile dropdown-toggle"> <span><i class="fas fa-sliders-h"></i></span>Report</a>
                        <div class="sidebar-submenu">
                           <ul>
                              <li><a href="<?php echo base_url(); ?>admin/acStatement">Account Statement </a></li>

                              <?php
                              if (get_user_type() != 'User') { ?>
                                 <li><a href="<?php echo base_url(); ?>new_chipsummary">Balance Sheet </a> </li>


                                 <li><a href="<?php echo base_url(); ?>clientpl">Client P L</a> </li>
                                 <!-- <li><a href="<?php echo base_url(); ?>sportspl">Sport P L</a> </li> -->
                                 <li><a href="<?php echo base_url(); ?>admin/Reports/fancyStack">Fancy Stack</a> </li>
                              <?php } ?>

                              <li><a href="<?php echo base_url(); ?>profitloss">Profit &amp; Loss</a> </li>
                              <li><a href="<?php echo base_url(); ?>bethistory">Bet History</a> </li>
                              <li><a href="<?php echo base_url(); ?>gameclientbet">Live game bet history</a> </li>
                              <?php
                              if (get_user_type() == 'Super Admin' || get_user_id() == '32222') { ?>
                                 <li><a href="<?php echo base_url('transaction-history-admin'); ?>">Transaction History</a> </li>
                                 <li><a href="<?php echo base_url('income-report'); ?>">Income Report</a> </li>
                              <?php } ?>
                           </ul>
                        </div>
                     </li>
                     <li class="hidden-lg"><a class="UserChipData" href="javascript:void(0);" onclick="showEditStakeModel()"></i>
                           Edit Stake</a>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
      </div>


      <script>
         $(document).ready(function() {

            $.ajax({
               url: '<?php echo base_url() ?>login/Admin/get_register_Data',
               type: 'GET',
               dataType: 'json',
               success: function(data) {
                  // alert('hi');
                  var user = data.user_list.is_demo;

                  var is_Demo = "<?php echo $_SESSION['is_demo'] ?>";

                  if (user != is_Demo) {
                     window.location = "<?php echo base_url(); ?>logout";
                  }


               }
            })
         })
      </script>