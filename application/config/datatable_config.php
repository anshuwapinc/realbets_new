<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!isset($config)) {
    $config = array();
}
$config['datatable_class'] = "dyntable table table-bordered table-hover dataTable dtr-inline";

$config['tax_listing_headers'] = array(
    'tax_id' => array(
        'jsonField' => 'tax_id',
        'width' => '10%'
    ),
    'title' => array(
        'jsonField' => 'title',
        'isLink' => true,
        'linkParams' => array('tax_id'),
        'linkTarget' => 'admin/addtax/',
        'width' => '10%'
    ),
    'tax_slab' => array(
        'jsonField' => 'tax_slab',
        'width' => '10%'
    ),
    'igst' => array(
        'jsonField' => 'igst',
        'width' => '10%'
    ),
    'cgst' => array(
        'jsonField' => 'cgst',
        'width' => '10%'
    ),
    'sgst' => array(
        'jsonField' => 'sgst',
        'width' => '10%'
    ),
    'view' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'VIEW_ICON',
        'isLink' => true,
        'linkParams' => array('tax_id'),
        'linkTarget' => 'admin/viewtax/',
        'width' => '5%',
        'align' => 'center'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('tax_id'),
        'linkTarget' => 'admin/addtax/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('tax_id'),
        'linkTarget' => 'admin/deletetax/',
        'width' => '5%',
        'align' => 'center'
    )
);


$config['units_listing_headers'] = array(
    'unit_id' => array(
        'jsonField' => 'unit_id',
        'width' => '10%'
    ),
    'Title' => array(
        'jsonField' => 'title',
        // 'isLink' => true,
        // 'linkParams' => array('unit_id'),
        // 'linkTarget' => 'admin/addtax/',
        'width' => '10%'
    ),
    'description' => array(
        'jsonField' => 'description',
        'width' => '10%'
    ),
    'view' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'VIEW_ICON',
        'isLink' => true,
        'linkParams' => array('unit_id'),
        'linkTarget' => 'admin/viewunit/',
        'width' => '5%',
        'align' => 'center'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('unit_id'),
        'linkTarget' => 'admin/addunit/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('unit_id'),
        'linkTarget' => 'admin/deleteunit/',
        'width' => '5%',
        'align' => 'center'
    )
);

$config['subcategory_listing_headers'] = array(
    'sub_category_id' => array(
        'jsonField' => 'sub_category_id',
        'width' => '5%'
    ),
    'subcategory_name' => array(
        'jsonField' => 'subcategory_name',
        'width' => '45%'
    ),
    'category_name' => array(
        'jsonField' => 'category_name',
        'width' => '45%'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('subcategory_id'),
        'linkTarget' => 'admin/subcategory/addsubcategory/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('subcategory_id'),
        'linkTarget' => 'admin/subcategory/deletesubcategory/',
        'width' => '5%',
        'align' => 'center'
    )
);
$config['city_listing_headers'] = array(
    'city_name' => array(
        'jsonField' => 'city_name',
        'width' => '30%'
    ),
    'state_name' => array(
        'jsonField' => 'state_name',
        'width' => '30%'
    ),
    'short_name' => array(
        'jsonField' => 'short_name',
        'width' => '30%'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('city_id'),
        'linkTarget' => 'admin/city/addcity/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('city_id'),
        'linkTarget' => 'admin/city/deletecity/',
        'width' => '5%',
        'align' => 'center'
    )
);

$config['category_listing_headers'] = array(
    'category_id' => array(
        'jsonField' => 'category_id',
        'width' => '5%'
    ),
    'title' => array(
        'jsonField' => 'title',
        'width' => '50%'
    ),
    'tax_title' => array(
        'jsonField' => 'tax_title',
        'width' => '20%'
    ),
    'tax_slab' => array(
        'jsonField' => 'tax_slab',
        'width' => '20%'
    ),
    'View' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'VIEW_ICON',
        'isLink' => true,
        'linkParams' => array('category_id'),
        'linkTarget' => 'admin/category/viewcategory/',
        'width' => '5%',
        'align' => 'center'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('category_id'),
        'linkTarget' => 'admin/category/addcategory/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('category_id'),
        'linkTarget' => 'admin/category/deleteCategory/',
        'width' => '5%',
        'align' => 'center'
    )
);

$config['sub_category_listing_headers'] = array(
    'sub_category_id' => array(
        'jsonField' => 'sub_category_id',
        'width' => '5%'
    ),
    'title' => array(
        'jsonField' => 'title',
        'width' => '50%'
    ),
    'category_title' => array(
        'jsonField' => 'category_title',
        'width' => '20%'
    ),
    'tax_title' => array(
        'jsonField' => 'tax_title',
        'width' => '20%'
    ),
    'tax_slab' => array(
        'jsonField' => 'tax_slab',
        'width' => '20%'
    ),
    'View' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'VIEW_ICON',
        'isLink' => true,
        'linkParams' => array('sub_category_id'),
        'linkTarget' => 'admin/viewsubcategory/',
        'width' => '5%',
        'align' => 'center'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('sub_category_id'),
        'linkTarget' => 'admin/addsubcategory/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('sub_category_id'),
        'linkTarget' => 'admin/deletesubcategory/',
        'width' => '5%',
        'align' => 'center'
    )
);



$config['product_listing_headers'] = array(
    'item_code' => array(
        'jsonField' => 'item_code',
        'width' => '10%'
    ),
    'title' => array(
        'jsonField' => 'title',
        'width' => '20%'
    ),
    // 'hsn_code' => array(
    //     'jsonField' => 'hsn_code',
    //     'width' => '10%'
    // ),
    'category_title' => array(
        'jsonField' => 'category_title',
        'width' => '20%'
    ),
    'sub_category_title' => array(
        'jsonField' => 'sub_category_title',
        'width' => '20%'
    ),
    'mrp_rate' => array(
        'jsonField' => 'mrp_rate',
        'width' => '20%'
    ),
    'sdp' => array(
        'jsonField' => 'sdp',
        'width' => '20%'
    ),
    'selling_price' => array(
        'jsonField' => 'selling_price',
        'width' => '20%'
    ), 'special_rate' => array(
        'jsonField' => 'special_rate',
        'width' => '20%'
    ),
    'view' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'VIEW_ICON',
        'isLink' => true,
        'linkParams' => array('product_id'),
        'linkTarget' => 'admin/viewproduct/',
        'width' => '5%',
        'align' => 'center'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('product_id'),
        'linkTarget' => 'admin/addproduct/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('product_id'),
        'linkTarget' => 'admin/deleteproduct/',
        'width' => '5%',
        'align' => 'center'
    )
);

$config['user_listing_headers'] = array(
    'user_name' => array(
        'jsonField' => 'user_name',
        'width' => '15%'
    ),

    'contact_no' => array(
        'jsonField' => 'contact_no',
        'width' => '10%'
    ),
    'whatsapp_no' => array(
        'jsonField' => 'whatsapp_no',
        'width' => '10%'
    ),

    'address' => array(
        'jsonField' => 'address',
        'width' => '20%'
    ),
    'status' => array(
        'jsonField' => 'user_id',
        'isSortable' => TRUE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_status',
        'width' => '15%',
        'align' => 'left'
    ),

    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('user_id'),
        'linkTarget' => 'admin/adduser/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('user_id'),
        'linkTarget' => 'admin/deleteuser/',
        'width' => '5%',
        'align' => 'center'
    )
);

$config['party_listing_headers'] = array(
    // 'customer_code' => array(
    //     'jsonField' => 'customer_code',
    //     'width' => '5%'
    // ),
    'owner_name' => array(
        'jsonField' => 'owner_name',
        'width' => '10%'
    ),
    'company_name' => array(
        'jsonField' => 'company_name',
        'width' => '10%'
    ),


    'whatsapp_number' => array(
        'jsonField' => 'whatsapp_number',
        'width' => '10%'
    ),
    'email' => array(
        'jsonField' => 'email',
        'width' => '10%'
    ),
    'disable_reason' => array(
        'jsonField' => 'disable_reason',
        'width' => '20%'
    ),
    'status' => array(
        'jsonField' => 'party_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_party_status',
        'width' => '5%',
        'align' => 'left'
    ),
    'view' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'VIEW_ICON',
        'isLink' => true,
        'linkParams' => array('party_id'),
        'linkTarget' => 'admin/viewparty/',
        'width' => '5%',
        'align' => 'center'
    ),
    'edit' => array(
        // 'isSortable' => false,
        // 'systemDefaults' => true,
        // 'type' => 'EDIT_ICON',
        // 'isLink' => true,
        // 'linkParams' => array('party_id'),
        // 'linkTarget' => 'admin/addparty/',
        // 'width' => '5%',
        // 'align' => 'center'
        'jsonField' => 'party_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_party_edit',
        'width' => '15%',
        'align' => 'left'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('party_id'),
        'linkTarget' => 'admin/deleteparty/',
        'width' => '5%',
        'align' => 'center'
    )
);


$config['trash_party_listing_headers'] = array(
    'owner_name' => array(
        'jsonField' => 'owner_name',
        'width' => '10%'
    ),

    'company_name' => array(
        'jsonField' => 'company_name',
        'width' => '10%'
    ),

    'whatsapp_number' => array(
        'jsonField' => 'whatsapp_number',
        'width' => '10%'
    ),
    'email' => array(
        'jsonField' => 'email',
        'width' => '10%'
    ),
    'Restore' => array(
        'jsonField' => 'party_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_party_restore',
        'width' => '5%',
        'align' => 'left'
    ),
);



$config['order_listing_headers'] = array(
    'quotation_number' => array(
        'jsonField' => 'quotation_number',
        'width' => '5%'
    ),
    'owner_name' => array(
        'jsonField' => 'owner_name',
        'width' => '10%'
    ),
    'quotation_date' => array(
        'jsonField' => 'quotation_date',
        'width' => '10%',
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'quotation_dateformat',
        'width' => '10%',
        // 'align' => 'left'
    ),

    'grand_total' => array(
        'jsonField' => 'grand_total',
        'width' => '10%'
    ),
    'order_id' => array(
        'jsonField' => 'order_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'send_on_whatsapp',
        'width' => '5%',
        'align' => 'left'
    ),
    'status' => array(
        'jsonField' => 'status',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_order_status',
        'width' => '15%',
        'align' => 'left'
    ),
    // 'view' => array(
    //     'isSortable' => false,
    //     'systemDefaults' => true,
    //     'type' => 'COPY_ICON',
    //     'isLink' => true,
    //     'linkParams' => array('order_id'),
    //     'linkTarget' => 'admin/orderprint/',
    //     'target' => '_blank',
    //     'width' => '5%',
    //     'align' => 'center',
    // ),

    'Real/MRP/NRP' => array(
        'jsonField' => 'order_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_order_view',
        'width' => '15%',
        'align' => 'center'
    ),

    'Edit' => array(
        'jsonField' => 'order_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_order_edit',
        'width' => '5%',
        'align' => 'left'
    ),
    // 'edit' => array(
    //     'isSortable' => false,
    //     'systemDefaults' => true,
    //     'type' => 'EDIT_ICON',
    //     'isLink' => true,
    //     'linkParams' => array('order_id'),
    //     'linkTarget' => 'admin/addorder/partydetails/',

    //     'width' => '5%',
    //     'align' => 'center'
    // ),
    'delete' => array(
        'jsonField' => 'order_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_order_delete',
        'width' => '5%',
        'align' => 'left'
        // 'isSortable' => false,
        // 'systemDefaults' => true,
        // 'type' => 'DELETE_ICON',
        // 'confirmBox' => true,
        // 'isLink' => true,
        // 'linkParams' => array('order_id'),
        // 'linkTarget' => 'admin/deleteorder/',
        // 'width' => '5%',
        // 'align' => 'center'
    )
);

$config['prediction_listing_headers'] = array(
    'prediction_title' => array(
        'jsonField' => 'prediction_title',
        'width' => '50%'
    ),
    'prediction_entry_from' => array(
        'jsonField' => 'prediction_entry_from',
        'width' => '20%'
    ),
    'prediction_entry_to' => array(
        'jsonField' => 'prediction_entry_to',
        'width' => '20%'
    ),
    'entry' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('prediction_master_id'),
        'linkTarget' => 'admin/predictionentry/',
        'width' => '5%',
        'align' => 'center'
    ),
    'Bulk User Entry' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('prediction_master_id'),
        'linkTarget' => 'admin/predictionbulkentry/',
        'width' => '5%',
        'align' => 'center'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('prediction_master_id'),
        'linkTarget' => 'admin/addmatch/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('prediction_master_id'),
        'linkTarget' => 'admin/deletematch/',
        'width' => '5%',
        'align' => 'center'
    )
);


$config['team_listing_headers'] = array(
    'team_name' => array(
        'jsonField' => 'team_name',
        'width' => '50%'
    ),
    'team_logo' => array(
        'jsonField' => 'team_logo',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_team_image',
        'width' => '5%',
        'align' => 'left'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('team_id'),
        'linkTarget' => 'admin/addteam/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('team_id'),
        'linkTarget' => 'admin/deleteteam/',
        'width' => '5%',
        'align' => 'center'
    )
);



$config['player_listing_headers'] = array(
    'player_name' => array(
        'jsonField' => 'player_name',
        'width' => '50%'
    ),
    'team_name' => array(
        'jsonField' => 'team_name',
        'width' => '20%'
    ),
    'edit' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'EDIT_ICON',
        'isLink' => true,
        'linkParams' => array('player_id'),
        'linkTarget' => 'admin/addplayer/',
        'width' => '5%',
        'align' => 'center'
    ),
    'delete' => array(
        'isSortable' => false,
        'systemDefaults' => true,
        'type' => 'DELETE_ICON',
        'confirmBox' => true,
        'isLink' => true,
        'linkParams' => array('player_id'),
        'linkTarget' => 'admin/deleteplayer/',
        'width' => '5%',
        'align' => 'center'
    )
);


$config['masters_listing_headers_1'] = array(
    'user_checkbox' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_checkbox',
        'width' => '10%',
        'align' => 'left'
    ),
    'view_more' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_view_more_option',
        'width' => '10%',
        'align' => 'left'
    ),
    'user_name' => array(
        // 'jsonField' => 'user_name',
        // 'isLink' => true,
        // 'linkParams' => array('user_id','user_type'),
        // 'linkTarget' => 'admin/downline/',
        // 'width' => '10%'
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_name_html',
        'width' => '10%',
        'align' => 'left'
    ),
    'seperate_password' => array(
        'isSortable' => TRUE,

        'jsonField' => 'seperate_password',
        'width' => '10%'
    ),
    'winings' => array(
        'isSortable' => TRUE,

        'jsonField' => 'user_id',
        'width' => '10%',
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_winnings_amt',
        'width' => '10%',
        'align' => 'left'
    ),
    'credit_limit' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_credit_limit',
        'width' => '10%',
        'align' => 'left'
    ),
    'exposure' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_exposure',
        'width' => '10%',
        'align' => 'left'
    ),
    'balance' => array(
        'jsonField' => 'user_id',
        'isSortable' => TRUE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_balance',
        'width' => '10%',
        'align' => 'left'
    ),
    'partnership' => array(
        'jsonField' => 'partnership',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_partnership',
        'width' => '10%',
        'align' => 'left'
    ),
    // 'teenpati_partnership' => array(
    //     'isSortable' => FALSE,

    //     'jsonField' => 'teenpati_partnership',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_user_partnership',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    // 'casino_partnership' => array(
    //     'isSortable' => FALSE,

    //     'jsonField' => 'casino_partnership',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_user_partnership',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    'master_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'master_commision',
        'width' => '10%'
    ),
    'sessional_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'sessional_commision',
        'width' => '10%'
    ),
  
);


$config['masters_listing_headers'] = array(
    'user_checkbox' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_checkbox',
        'width' => '10%',
        'align' => 'left'
    ),
    'view_more' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_view_more_option',
        'width' => '10%',
        'align' => 'left'
    ),
    'user_name' => array(
        // 'jsonField' => 'user_name',
        // 'isLink' => true,
        // 'linkParams' => array('user_id','user_type'),
        // 'linkTarget' => 'admin/downline/',
        // 'width' => '10%'
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_name_html',
        'width' => '10%',
        'align' => 'left'
    ),
    'seperate_password' => array(
        'isSortable' => TRUE,

        'jsonField' => 'seperate_password',
        'width' => '10%'
    ),
    'winings' => array(
        'isSortable' => TRUE,

        'jsonField' => 'user_id',
        'width' => '10%',
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_winnings_amt',
        'width' => '10%',
        'align' => 'left'
    ),
    'credit_limit' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_credit_limit',
        'width' => '10%',
        'align' => 'left'
    ),
    'exposure' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_exposure',
        'width' => '10%',
        'align' => 'left'
    ),
    'balance' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_balance',
        'width' => '10%',
        'align' => 'left'
    ),
    'partnership' => array(
        'jsonField' => 'partnership',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_partnership',
        'width' => '10%',
        'align' => 'left'
    ),
    // 'teenpati_partnership' => array(
    //     'isSortable' => FALSE,

    //     'jsonField' => 'teenpati_partnership',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_user_partnership',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    // 'casino_partnership' => array(
    //     'isSortable' => FALSE,

    //     'jsonField' => 'casino_partnership',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_user_partnership',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    'master_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'master_commision',
        'width' => '10%'
    ),
    'sessional_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'sessional_commision',
        'width' => '10%'
    ),
     
);




$config['users_listing_headers_1'] = array(
    'user_checkbox' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_checkbox',
        'width' => '10%',
        'align' => 'left'
    ),
    'view_more' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_view_more_option',
        'width' => '10%',
        'align' => 'left'
    ),
    'user_name' => array(
        // 'jsonField' => 'user_name',
        // 'isLink' => true,
        // 'linkParams' => array('user_id','user_type'),
        // 'linkTarget' => 'admin/downline/',
        // 'width' => '10%'
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_name_html',
        'width' => '10%',
        'align' => 'left'
    ),
    'seperate_password' => array(
        'isSortable' => TRUE,

        'jsonField' => 'seperate_password',
        'width' => '10%'
    ),
    'winings' => array(
        'isSortable' => TRUE,

        'jsonField' => 'user_id',
        'width' => '10%',
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_winnings_amt',
        'width' => '10%',
        'align' => 'left'
    ),
    'credit_limit' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_credit_limit',
        'width' => '10%',
        'align' => 'left'
    ),
    'exposure' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_exposure',
        'width' => '10%',
        'align' => 'left'
    ),
    'balance' => array(
        'jsonField' => 'user_id',
        'isSortable' => TRUE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_balance',
        'width' => '10%',
        'align' => 'left'
    ),
    'master_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'master_commision',
        'width' => '10%'
    ),
    'sessional_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'sessional_commision',
        'width' => '10%'
    )
);


$config['users_listing_headers'] = array(
    'user_checkbox' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_checkbox',
        'width' => '10%',
        'align' => 'left'
    ),
    'view_more' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_view_more_option',
        'width' => '10%',
        'align' => 'left'
    ),
    'user_name' => array(
        // 'jsonField' => 'user_name',
        // 'isLink' => true,
        // 'linkParams' => array('user_id','user_type'),
        // 'linkTarget' => 'admin/downline/',
        // 'width' => '10%'
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_name_html',
        'width' => '10%',
        'align' => 'left'
    ),
    'seperate_password' => array(
        'isSortable' => TRUE,

        'jsonField' => 'seperate_password',
        'width' => '10%'
    ),
    'winings' => array(
        'isSortable' => TRUE,

        'jsonField' => 'user_id',
        'width' => '10%',
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_winnings_amt',
        'width' => '10%',
        'align' => 'left'
    ),
    'credit_limit' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_credit_limit',
        'width' => '10%',
        'align' => 'left'
    ),
    'exposure' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_exposure',
        'width' => '10%',
        'align' => 'left'
    ),
    'balance' => array(
        'jsonField' => 'user_id',
        'isSortable' => TRUE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_balance',
        'width' => '10%',
        'align' => 'left'
    ),
    'master_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'master_commision',
        'width' => '10%'
    ),
    'sessional_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'sessional_commision',
        'width' => '10%'
    )
);



$config['masters_closed_user_listing_headers'] = array(
    'user_checkbox' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_checkbox',
        'width' => '10%',
        'align' => 'left'
    ),
    'user_name' => array(
        // 'jsonField' => 'user_name',
        // 'isLink' => true,
        // 'linkParams' => array('user_id','user_type'),
        // 'linkTarget' => 'admin/downline/',
        // 'width' => '10%'
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_name_html',
        'width' => '10%',
        'align' => 'left'
    ),
    'winings' => array(
        'isSortable' => TRUE,

        'jsonField' => 'winings',
        'width' => '10%'
    ),
    'credit_limit' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_credit_limit',
        'width' => '10%',
        'align' => 'left'
    ),
    'exposure' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_exposure',
        'width' => '10%',
        'align' => 'left'
    ),
    'balance' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_balance',
        'width' => '10%',
        'align' => 'left'
    ),
    'partnership' => array(
        'jsonField' => 'partnership',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_partnership',
        'width' => '10%',
        'align' => 'left'
    ),
    // 'teenpati_partnership' => array(
    //     'isSortable' => FALSE,

    //     'jsonField' => 'teenpati_partnership',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_user_partnership',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    // 'casino_partnership' => array(
    //     'isSortable' => FALSE,

    //     'jsonField' => 'casino_partnership',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_user_partnership',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    'master_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'master_commision',
        'width' => '10%'
    ),
    'sessional_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'sessional_commision',
        'width' => '10%'
    ),

);



$config['users_closed_user_listing_headers'] = array(
    'user_checkbox' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_checkbox',
        'width' => '10%',
        'align' => 'left'
    ),
    'user_name' => array(
        // 'jsonField' => 'user_name',
        // 'isLink' => true,
        // 'linkParams' => array('user_id','user_type'),
        // 'linkTarget' => 'admin/downline/',
        // 'width' => '10%'
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_name_html',
        'width' => '10%',
        'align' => 'left'
    ),
    'winings' => array(
        'isSortable' => TRUE,

        'jsonField' => 'winings',
        'width' => '10%'
    ),
    'credit_limit' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_credit_limit',
        'width' => '10%',
        'align' => 'left'
    ),
    'exposure' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_exposure',
        'width' => '10%',
        'align' => 'left'
    ),
    'balance' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_balance',
        'width' => '10%',
        'align' => 'left'
    ),
    'master_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'master_commision',
        'width' => '10%'
    ),
    'sessional_commision' => array(
        'isSortable' => FALSE,

        'jsonField' => 'sessional_commision',
        'width' => '10%'
    ),

);


$config['betting_listing_headers'] = array(
    'betting_check_box' => array(
        'fieldtype' => "CheckBox",
        'fieldtype_attributes' => array('class' => 'betting_select_all'),
        'isSortable' => FALSE,
        'jsonField' => 'betting_id',
        'width' => '5%',
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_betting_check_box',
    ),
    'sn' => array(
        'isSortable' => TRUE,
        'jsonField' => 'sn',
        'width' => '1%',
    ),
    'betting_id' => array(
        'isSortable' => TRUE,
        'jsonField' => 'betting_id',
        'width' => '15%',
    ),
    'place_name' => array(
        'isSortable' => TRUE,
        'jsonField' => 'place_name',
        'width' => '15%'
    ),
    'user_name' => array(
        'isSortable' => TRUE,
        'jsonField' => 'user_name',
        'width' => '15%'
    ),
    'created_at' => array(
        'isSortable' => TRUE,
        'jsonField' => 'bat_dt',
        'width' => '15%'
    ),
    'stake' => array(
        'isSortable' => TRUE,
        'jsonField' => 'stake',
        'width' => '10%'
    ),
    'price_val' => array(
        'isSortable' => TRUE,
        'jsonField' => 'price_val',
        'width' => '10%'
    ),
    'bet_result' => array(
        'isSortable' => TRUE,
        'jsonField' => 'bet_result',
        'width' => '20%'
    ),
    'Action' => array(
        'isSortable' => FALSE,
        'systemDefaults' => TRUE,
        'jsonField' => 'betting_id',
        'linkParams' => array('betting_id', 'list_event_id'),
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_betting_delete_link'
    )
);
$config['betting_listing_headers_new'] = array(
    'betting_check_box' => array(
        'fieldtype' => "CheckBox",
        'fieldtype_attributes' => array('class' => 'betting_select_all'),
        'isSortable' => FALSE,
        'jsonField' => 'betting_id',
        'width' => '5%',
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_betting_check_box',
    ),
    'sn' => array(
        'isSortable' => TRUE,
        'jsonField' => 'sn',
        'width' => '1%',
    ),
    'betting_id' => array(
        'isSortable' => TRUE,
        'jsonField' => 'betting_id',
        'width' => '15%',
    ),
    'place_name' => array(
        'isSortable' => TRUE,
        'jsonField' => 'place_name',
        'width' => '15%'
    ),
    'user_name' => array(
        'isSortable' => TRUE,
        'jsonField' => 'user_name',
        'width' => '15%'
    ),
    'created_at' => array(
        'isSortable' => TRUE,
        'jsonField' => 'bat_dt',
        'width' => '15%'
    ),
    'stake' => array(
        'isSortable' => TRUE,
        'jsonField' => 'stake',
        'width' => '10%'
    ),
    'price_val' => array(
        'isSortable' => TRUE,
        'jsonField' => 'price_val',
        'width' => '10%'
    ),
    'bet_result' => array(
        'isSortable' => TRUE,
        'jsonField' => 'bet_result',
        'width' => '20%'
    ),
    // 'Action' => array(
    //     'isSortable' => FALSE,
    //     'systemDefaults' => TRUE,
    //     'jsonField' => 'betting_id',
    //     'linkParams' => array('betting_id', 'list_event_id'),
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_betting_delete_link'
    // )
);


$config['refered_users_listing_headers'] = array(
    // 'user_checkbox' => array(
    //     'jsonField' => 'user_id',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_user_checkbox',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    // 'view_more' => array(
    //     'jsonField' => 'user_id',
    //     'isSortable' => FALSE,
    //     'callBack' => TRUE,
    //     'callBackType' => 'helper',
    //     'callBackClass' => 'common_helper',
    //     'callBackFunction' => 'get_view_more_option',
    //     'width' => '10%',
    //     'align' => 'left'
    // ),
    'user_name' => array(
        // 'jsonField' => 'user_name',
        // 'isLink' => true,
        // 'linkParams' => array('user_id','user_type'),
        // 'linkTarget' => 'admin/downline/',
        // 'width' => '10%'
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_refered_user_link',
        'width' => '10%',
        'align' => 'left'
    ),
   
    'total_deposit_count' => array(
        'isSortable' => false,
        'jsonField' => 'total_deposit_count',
        'width' => '10%'
    ),

    'balance' => array(
        'jsonField' => 'user_id',
        'isSortable' => FALSE,
        'callBack' => TRUE,
        'callBackType' => 'helper',
        'callBackClass' => 'common_helper',
        'callBackFunction' => 'get_user_balance',
        'width' => '10%',
        'align' => 'left'
    ),
   
);