<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] =  'login/Admin/login';
$route['login'] = 'login/Admin/login';
$route['logout'] = 'login/Admin/logout';
$route['changepassword'] = 'admin/ChangePassword/changepassword';
$route['sign-up'] =  'login/Admin/signUp';
$route['forgot-password'] =  'login/Admin/forgot_password';

$route['admin/dashboard'] = 'admin/Dashboard/index';

/***************************Teams******************************/
$route['admin/teams'] = 'admin/Teams/listteams';
$route['admin/addteam'] = 'admin/Teams/addteam';
$route['admin/addteam/(:num)'] = 'admin/Teams/addteam/$1';
$route['admin/deleteteam/(:num)'] = 'admin/Teams/deleteteam/$1';
/***************************Teams******************************/

/***************************Players******************************/
$route['admin/players'] = 'admin/Players/listplayers';
$route['admin/addplayer'] = 'admin/Players/addplayer';
$route['admin/addplayer/(:num)'] = 'admin/Players/addplayer/$1';
$route['admin/deleteplayer/(:num)'] = 'admin/Players/deleteplayer/$1';
/***************************Players******************************/


/***************************Employees******************************/
$route['admin/users/?(:any)'] = 'admin/User/listUsers/$1';
$route['getUserBalance'] = 'admin/User/getUserBalance';
$route['admin/downline/?(:any)/?(:any)'] = 'admin/User/downline/$1/$2';

$route['admin/adduser'] = 'admin/User/addUser';
$route['admin/adduser/(:num)'] = 'admin/User/addUser/$1';
$route['admin/deleteuser/(:num)'] = 'admin/User/deleteUser/$1';
$route['admin/addbulkuser'] = 'admin/User/addbulkuser';
$route['admin/usertemplateupload'] = 'admin/User/usertemplateupload';
$route['admin/userbulkentrysubmit'] = 'admin/User/userbulkentrysubmit/';



/***************************Products******************************/


// ***********************************Tax******************************/
$route['admin/matches'] = 'admin/Matches/listmatch';
$route['admin/addmatch'] = 'admin/Matches/addMatch';
$route['admin/addmatch/(:num)'] = 'admin/Matches/addMatch/$1';
$route['admin/predictionentry/(:num)'] = 'admin/Matches/predictionentry/$1';

$route['admin/deletematch/(:num)'] = 'admin/Matches/deletematch/$1';
$route['admin/deletemasterfield/(:num)'] = 'admin/Matches/deletemasterfield/$1';


/************************************Tax******************************/


$route['dashboard'] = 'admin/Dashboard/index';
$route['dashboard/(:any)'] = 'admin/Dashboard/index/$1';
$route['dashboard/index/(:any)/(:any)'] = 'admin/Dashboard/index2/$1/$2';


$route['chip'] = 'admin/Chip/index';
$route['message/send'] = 'admin/Chip/send';
$route['accountinfo'] = 'admin/Reports/accountinfo';
$route['acStatement/(:num)'] = 'admin/Reports/acStatement/$1';
$route['bethistory'] = 'admin/Reports/bethistory';
$route['bethistory/(:num)'] = 'admin/Reports/bethistory/$1';
$route['profitloss'] = 'admin/Reports/profitloss';
$route['gameclientbet'] = 'admin/Reports/gameclientbet';
$route['gameclientbet/(:num)'] = 'admin/Reports/gameclientbet/$1';


$route['admin/acStatement/(:num)/(:num)'] = 'admin/Reports/acStatement/$1/$2';
$route['admin/profitloss/(:num)/(:num)'] = 'admin/Reports/profitloss/$1/$2';
$route['admin/accountinfo'] = 'admin/Reports/accountinfo/';
$route['admin/acStatement'] = 'admin/Reports/acStatement/';
$route['acStatement'] = 'admin/Reports/acStatement/';

$route['admin/viewinfo/(:num)'] = 'admin/User/viewinfo/$1';

$route['admin/closedusers/?(:any)'] = 'admin/User/closedUsersList/$1';


$route['admin/settlement'] = 'admin/Settlement/listmarkets';
$route['admin/settlement/events/(:num)'] = 'admin/Settlement/listevents/$1';
$route['admin/settlement/events/settlemenEventEntry/(:num)'] = 'admin/Settlement/settlemenEventEntry/$1';
$route['admin/settlement/entrysubmit'] = 'admin/Settlement/entrySubmit';

$route['new_chipsummary'] = 'admin/Reports/chip_summarynew1';
$route['new_chipsummary1/(:any)'] = 'admin/Reports/chip_summarynew1/$1';

$route['old_chipsummary'] = 'admin/Reports/chip_summary';
$route['new_chipsummary/(:num)'] = 'admin/Reports/chip_summarynew1/$1';
$route['old_chipsummary/(:num)'] = 'admin/Reports/chip_summary/$1';

$route['my_market'] = 'admin/My_market/index';
$route['refreshMarketAnalysis'] = 'admin/My_market/refreshMarketAnalysis';
$route['clientpl'] = 'admin/reports/client_pl';

$route['marketpl'] = 'admin/reports/market_pl';
$route['userpl'] = 'admin/reports/user_pl';
$route['sportspl'] = 'admin/reports/sports_pl';
$route['admin/my_market'] = 'admin/My_market/index';
// $route['admin/match_list_block/(:num)'] = 'admin/Event_type/match_list_block';


$route['admin/Events/getCasinoLastResult'] = 'admin/Events/getCasinoLastResult';


$route['admin/bettings/listmarkets'] = 'admin/Bettings/listmarkets';
$route['admin/bettings/events/(:num)'] = 'admin/Bettings/listevents/$1';
$route['admin/bettings/bettinglists/(:num)'] = 'admin/Bettings/bettinglists/$1';
$route['admin/bettings/deletebet/(:num)'] = 'admin/Bettings/deletebet/$1';

$route['admin/blockmarket'] = 'admin/BlockMarket/listmarkets';
$route['admin/match_list_block/(:num)'] = 'admin/BlockMarket/match_list_block/$1';
$route['admin/market_list_block/(:num)/(:num)'] = 'admin/BlockMarket/market_list_block/$1/$2';
$route['admin/fancy_event_list_block/(:num)/(:num)'] = 'admin/BlockMarket/fancy_event_list_block/$1/$2';



$route['admin/settled'] = 'admin/Settled/listmarkets';
$route['admin/settled/events/(:num)'] = 'admin/Settled/listevents/$1';
$route['admin/settled/events/settledEventEntry/(:num)'] = 'admin/Settled/settledEventEntry/$1';
$route['admin/settled/entrysubmit'] = 'admin/Settled/entrySubmit';


$route['news'] = 'admin/News/index';
$route['message/send'] = 'admin/Chip/send';


$route['profitloss/bethistorey/(:num)/(:any)/(:num)/(:any)'] = 'admin/Reports/profitLossbethistory/$1/$2/$3/$4';
// $route['bethistory/(:num)'] = 'admin/Reports/bethistory/$1';

$route['dashboard/eventDetail/(:any)'] = 'admin/Dashboard/eventDetail/$1';
$route['casino/(:any)'] = 'admin/Casino/index/$1';
$route['addCasinoEvent/(:any)'] = 'admin/Events/addCasinoEvents/$1';
$route['casinoBetSettle/(:any)'] = 'admin/Casino/casinoBetSettle/$1';

$route['admin/casinoblockmarket'] =  'admin/BlockMarket/casinolistmarkets';
$route['admin/deleteOldCasinoData'] =  'admin/Casino/deleteOldCasinoData';
$route['admin/settled_failed'] = 'admin/Settled/settled_failed';
$route['admin/user_detail'] =  'admin/User/userDetail';
$route['profitloss/bethistory/(:num)/(:any)/(:num)/(:any)'] = 'admin/Reports/profitLossbethistory/$1/$2/$3/$4';
$route['admin/casinobettings/listmarkets'] = 'admin/Bettings/casinolistmarkets';


// $route['myledger'] = 'admin/Reports/myledger';

$route['client/txn-client'] = 'admin/Reports/txnclient';
$route['client/txn-agent'] = 'admin/Reports/txnagent';
$route['client/txn-super'] = 'admin/Reports/txnsuper';
$route['client/txn-master'] = 'admin/Reports/txnmaster';
$route['client/txn-sba'] = 'admin/Reports/txnsba';

$route['sports-details'] = 'admin/Reports/sportsdetails';
$route['agent-match-session-plus-minus/(:num)'] = 'admin/Reports/agentMatchSessionPL/$1';
$route['master-match-session-plus-minus/(:num)'] = 'admin/Reports/masterMatchSessionPL/$1';
$route['super-agent-match-session-plus-minus/(:num)'] = 'admin/Reports/superMatchSessionPL/$1';
$route['sub-admin-match-session-plus-minus/(:num)'] = 'admin/Reports/subAdminMatchSessionPL/$1';
$route['master-agent-match-session-plus-minus/(:num)'] = 'admin/Reports/masterAgentMatchSessionPL/$1';
$route['admin-match-session-plus-minus/(:num)'] = 'admin/Reports/adminMatchSessionPL/$1';

$route['addfunds'] =  'admin/User/addFunds';


$route['chip_summarynew_data/(:any)'] = 'admin/Reports/chip_summarynew_data/$1';

$route['myledgerdata'] = 'admin/Reports/myledgerdata';


$route['master-details'] = 'admin/Dashboard/masterDetails';
$route['reports'] = 'admin/Dashboard/reports';
$route['ledgers'] = 'admin/Dashboard/ledgers';
$route['cash-transactions'] = 'admin/Dashboard/cashTransactions';
$route['sports-bettings'] = 'admin/Dashboard/sportsBettings';
$route['sports'] = 'admin/Dashboard/sports';
$route['dashboard/(:any)'] = 'admin/Dashboard/eventdashboard/$1';
$route['eventdashboard/(:any)'] = 'admin/Dashboard/eventdashboard2/$1/$2';

$route['casinos'] = 'admin/Dashboard/casinos';

$route['myledger'] = 'admin/Reports/myledger1';

$route['other-details'] = 'admin/Dashboard/otherDetails';
$route['change-password'] = 'admin/User/changePasswordForm';
$route['clientpl/(:any)'] = 'admin/reports/client_pl/$1';


$route['dashboard/getEventsMarketExpsure/(:any)'] = 'admin/Dashboard/getEventsMarketExpsure/$1';


$route['dashboard/tvEventDetail/(:any)'] = 'admin/Dashboard/tvEventDetail/$1';

$route['admin/manual/event-types'] =  'admin/Manual/eventTypes';
$route['admin/manual/events/(:num)'] =  'admin/Manual/eventsLists/$1';
$route['admin/manual/eventbets/(:num)'] =  'admin/Manual/eventBets/$1';

$route['admin/manual/market-types/(:num)/(:num)'] =  'admin/Manual/marketTypes/$1/$2';
$route['admin/manual/market-book-runners/(:num)/(:any)'] =  'admin/Manual/marketBookRunners/$1/$2';


// Payments  Admin
$route['payment-methods'] = 'admin/Payments/paymentMethods';
$route['add-payment-method'] = 'admin/Payments/addPaymentMethod';
$route['add-payment-method/(:num)'] = 'admin/Payments/addPaymentMethod/$1';
$route['delete-payment-method/(:num)'] = 'admin/Payments/deletePaymentMethod/$1';
$route['change-payment-method-status/(:any)/(:num)'] = 'admin/Payments/changePaymentMethodStatus/$1/$2';


$route['deposit-requests'] = 'admin/Payments/depositRequests';
$route['withdraw-requests'] = 'admin/Payments/withdrawRequests';
$route['confirm-withdraw/(:num)/(:num)/(:any)'] = 'admin/User/confirm_withdraw/$1/$2/$3';
$route['confirm-deposit/(:num)/(:num)/(:any)'] = 'admin/User/confirm_deposit/$1/$2/$3';
$route['change-withdraw-request-status/(:any)/(:num)/(:any)'] = 'admin/Payments/changeWithdrawRequestStatus/$1/$2/$3';

$route['change-deposit-request-status/(:any)/(:num)/(:any)'] = 'admin/Payments/changeDepositRequestStatus/$1/$2/$3';



// Payments User
$route['get-payment-detail'] = "admin/Payments/get_payment_detail";
$route['deposituser'] = "admin/Payments/addPaymentRequest/Deposit";
$route['withdrawuser'] = "admin/Payments/addPaymentRequest/Withdraw";

//tranasction 
$route['transaction-history'] = "admin/Transactions/get_transaction_history";
$route['transaction-history/(:any)'] = "admin/Transactions/get_transaction_history/$1";

$route['transaction-history-admin'] = "admin/Transactions/get_transaction_history_admin";
$route['transaction-history-admin/(:any)'] = "admin/Transactions/get_transaction_history_admin/$1";


// refer 
$route['refer-and-earn'] = "admin/Refer/refer_and_earn";
$route['refered-users'] = 'admin/Refer/refered_users_list';
$route['refered-users/(:num)'] = 'admin/Refer/refered_users_list/$1';

// $route['refered-users'] = 'admin/Refer/listReferedUsers';
// $route['refered-users/(:num)'] = 'admin/Refer/listReferedUsers/$1';

$route['welcome-note-banner'] = 'admin/Dashboard/welcome_note_banner';
$route['delete-welcome-note-banner/(:num)'] = 'admin/Dashboard/delete_welcome_note_banner/$1';

$route['user-detail/(:num)'] = 'admin/User/get_user_detail/$1';
$route['income-report'] = 'admin/Reports/income_report';

$route['cancel-withdraw-request-status/(:num)'] = 'admin/Payments/cancelWithdrawRequestStatus/$1';

//bonus
$route['bonus-settings'] = 'admin/Bonus/bonus_setting';


//header banners 
$route['header-banners'] = 'admin/Banner/header_banners';
$route['add-header-banner'] = 'admin/Banner/add_header_banner';
$route['add-header-banner/(:num)'] = 'admin/Banner/add_header_banner/$1';
$route['change-header-banner-status/(:any)/(:num)'] = 'admin/Banner/change_header_banner_status/$1/$2';
$route['delete-header-banner/(:num)'] = 'admin/Banner/delete_header_banner/$1';