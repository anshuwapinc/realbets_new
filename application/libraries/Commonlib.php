<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Commonlib
    {

        private $_CI;

        public function __construct()
        {

            $this->_CI = & get_instance();
        }

        /*         * ******************************** Useraccount Model **************************** */

        public function emailexists($user_email)
        {
            $this->_CI->load->model('Useraccount_model');
            return $this->_CI->Useraccount_model->user_email_exist($user_email);
        }

        // public function get_total_users()
        // {
        //     $this->_CI->load->model('Useraccount_model');
        //     return $this->_CI->Useraccount_model->get_total_users();
        // }

        public function usernamexists($username)
        {
            $this->_CI->load->model('Useraccount_model');
            return $this->_CI->Useraccount_model->user_name_exist($username);
        }

        public function get_user_byuserid($userid)
        {
            $this->_CI->load->model('Useraccount_model');
            return $this->_CI->Useraccount_model->getuserbyid($userid);
        }

        /*         * ******************************** State Model **************************** */        

        public function get_total_state()
        {
            $this->_CI->load->model('State_model');
            return $this->_CI->State_model->get_total_state();
        }

        public function getallstate_array()
        {
            $this->_CI->load->model('State_model');
            return $this->_CI->State_model->getallstate_array();
        }

        public function getstate_bycountryid($country_id)
        {
            $this->_CI->load->model('State_model');
            return $this->_CI->State_model->getstate_bycountryid($country_id);
        }

        public function getallstate_array_bycountryid($country_id)
        {
            $this->_CI->load->model('State_model');
            return $this->_CI->State_model->getallstate_array_bycountryid($country_id);
        }

        /*         * ******************************** City Model **************************** */

        // public function getallcity_array()
        // {
        //     $this->_CI->load->model('City_model');
        //     return $this->_CI->City_model->getallcity_array();
        // }

        // public function get_total_city()
        // {
        //     $this->_CI->load->model('City_model');
        //     return $this->_CI->City_model->get_total_city();
        // }

        // public function getcity_bystateid($state_id)
        // {
        //     $this->_CI->load->model('City_model');
        //     return $this->_CI->City_model->getcity_bystateid($state_id);
        // }

        // public function getallcity_array_bystateid($state_id)
        // {
        //     $this->_CI->load->model('City_model');
        //     return $this->_CI->City_model->getallcity_array_bystateid($state_id);
        // }

        // public function getallcity_withstatename_array()
        // {
        //     $this->_CI->load->model('City_model');
        //     return $this->_CI->City_model->getallcity_withstatename_array();
        // }
        // public function getallcity_array_bycountryid($country_id)
        // {
        //     $this->_CI->load->model('City_model');
        //     return $this->_CI->City_model->getallcity_array_bycountryid($country_id);
        // }
        // public function getcity_bycountryid($country_id)
        // {
        //     $this->_CI->load->model('City_model');
        //     return $this->_CI->City_model->getcity_bycountryid($country_id);
        // }

        /*         * ******************************** Emailtemplate Model **************************** */

         
        /*         * ******************************** Area Model **************************** */

        public function get_total_area()
        {
            $this->_CI->load->model('Area_model');
            return $this->_CI->Area_model->get_total_area();
        }

        public function getarea_bycityid($city_id)
        {
            $this->_CI->load->model('Area_model');
            return $this->_CI->Area_model->getarea_bycityid($city_id);
        }

        public function get_area_trans_array_byuserid_chosen($owner_id)
        {
            $this->_CI->load->model('Area_model');
            return $this->_CI->Area_model->get_area_trans_array_byuserid_chosen($owner_id);
        }

        public function getallarea_array_bycityid($city_id)
        {
            $this->_CI->load->model('Area_model');
            return $this->_CI->Area_model->getallarea_array_bycityid($city_id);
        }

        public function getarea_byuserid($owner_id)
        {
            $this->_CI->load->model('Area_model');
            return $this->_CI->Area_model->getarea_byuserid($owner_id);
        }

        /*         * ******************************** Category Model **************************** */

        public function get_total_category()
        {
            $this->_CI->load->model('Category_model');
            return $this->_CI->Category_model->get_total_category();
        }
        public function getcategorybyid($category_id)
        {
            $this->_CI->load->model('Category_model');
            return $this->_CI->Category_model->getcategorybyid($category_id);
        }

        public function getallcategory_array()
        {
            $this->_CI->load->model('Category_model');
            return $this->_CI->Category_model->getallcategory_array();
        }
         public function getallsubcategory_array()
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getallsubcategory_array();
        }
         public function getallsubcategory_array_byoderid()
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getallsubcategory_array_byoderid();
        }
        
        public function getallcategorydata($listing_per_page, $offset)
        {
            $this->_CI->load->model('Category_model');
            return $this->_CI->Category_model->getallcategorydata($listing_per_page, $offset);
        }
//          public function getallsubcategorydata($listing_per_page, $offset)
//        {
//            $this->_CI->load->model('Subcategory_model');
//            return $this->_CI->Subcategory_model->getallsubcategorydata($listing_per_page, $offset);
//        }
           public function getallsubcategorydata()
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getallsubcategorydata();
        }
         public function getallsubcategorydata_byorder()
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getallsubcategorydata_byorder();
        }


        /*         * ******************************** Subcategory Model **************************** */

        public function get_total_subcategory()
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->get_total_subcategory();
        }

        public function get_total_rating()
        {
            $this->_CI->load->model('Rating_model');
            return $this->_CI->Rating_model->get_total_rating();
        }

        public function get_reply_byratingid($rating_id)
        {
            $this->_CI->load->model('Rating_model');
            return $this->_CI->Rating_model->get_reply_byratingid($rating_id);
        }
        
        public function getsubcategory_bycategoryid($category_id)
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getsubcategory_bycategoryid($category_id);
        }

        public function get_subcategory_trans_array_byuserid_chosen($owner_id)
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->get_subcategory_trans_array_byuserid_chosen($owner_id);
        }

        public function getallsubcategory_array_bycategoryid($category_id)
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getallsubcategory_array_bycategoryid($category_id);
        }

        public function get_subcategory_trans_byuserid($owner_id)
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->get_subcategory_trans_byuserid($owner_id);
        }
        public function getsubcategory_bycategoryid2($category_id)
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getsubcategory_bycategoryid2($category_id);
        }
        public function getallsubcategory_array_orderby($category_id)
        {
            $this->_CI->load->model('Subcategory_model');
            return $this->_CI->Subcategory_model->getallsubcategory_array_orderby($category_id);
        }

        /*         * ******************************** Business_owner Model **************************** */

        public function get_total_businessowner()
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_total_businessowner();
        }
        public function get_owner_bylobid()
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_owner_bylobid();
        }

        public function owner_emailexists($user_email)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->owner_email_exist($user_email);
        }

        public function get_bus_profileuserbyid($owner_id)
        {

            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_bus_profileuserbyid($owner_id);
        }

        public function get_owner_id_byslug($slug)
        {

            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_owner_id_byslug($slug);
        }

        public function get_ownerrating_byuser_ownerid($owner_id, $user_id)
        {

            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_ownerrating_byuser_ownerid($owner_id, $user_id);
        }

        public function get_favorite_byuser_ownerid($owner_id, $user_id)
        {

            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_favorite_byuser_ownerid($owner_id, $user_id);
        }
        public function get_favorite_byowner_jobid($job_id, $owner_id)
        {

            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_favorite_byowner_jobid($job_id, $owner_id);
        }

        public function getownerreviewscore($owner_id)
        {

            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->getownerreviewscore($owner_id);
        }

        public function get_owner_bycategoryid($category_id, $limit, $start)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_owner_bycategoryid($category_id, $limit, $start);
        }
        public function get_ownerlist_bysubcategory_cityid($cate_id,$city_id)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_ownerlist_bysubcategory_cityid($cate_id,$city_id);
        }
        public function get_owner_by_category_and_rating($category_id)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_owner_by_category_and_rating($category_id);
        }
        public function get_owner_by_category_detail($category_id, $item_per_page, $page_position,$owner_name,$sort)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_owner_by_category_detail($category_id, $item_per_page, $page_position,$owner_name,$sort);
        }

        public function get_total_businessowner_bycategoryid($category_id)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_total_businessowner_bycategoryid($category_id);
        }
        public function get_total_businessowner_bycategoryid_cityid($category_id)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_total_businessowner_bycategoryid_cityid($category_id);
        }

        public function get_rating_owner($owner_id, $minvalue, $maxvalue)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_rating_owner($owner_id, $minvalue, $maxvalue);
        }

        public function get_total_rating_owner($owner_id)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_total_rating_owner($owner_id);
        }
        public function get_total_rating_owner_publish($owner_id)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_total_rating_owner_publish($owner_id);
        }

        public function get_reviews_byownerid($owner_id, $start, $limit,$sorting)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_reviews_byownerid($owner_id, $start, $limit,$sorting);
        }

        public function get_total_owner_bycategoryid($category_id)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_total_owner_bycategoryid($category_id);
        }
        public function get_total_owner_bycategoryid_ownername($category_id,$owner_name)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_total_owner_bycategoryid_ownername($category_id,$owner_name);
        }

        public function get_owner_bybusinessname($name, $listing_per_page, $offset)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_owner_bybusinessname($name, $listing_per_page, $offset);
        }

        public function get_totalowner_bybusinessname($name)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->get_totalowner_bybusinessname($name);
        }
        public function owner_view_exists($viewerid, $viewedid,$viewertype)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->owner_view_exists($viewerid, $viewedid,$viewertype);
        }
        public function saveownerviwe($ownerviewdata)
        {
            $this->_CI->load->model('businessowner_model');
            return $this->_CI->businessowner_model->saveownerviwe($ownerviewdata);
        }
        /*         * ******************************** Packages Model **************************** */

        public function get_total_package()
        {
            $this->_CI->load->model('Package_model');
            return $this->_CI->Package_model->get_total_package();
        }

        /*         * ******************************** Skill Model **************************** */

        public function get_total_skill()
        {
            $this->_CI->load->model('Skill_model');
            return $this->_CI->Skill_model->get_total_skill();
        }

        public function getallskill_array()
        {
            $this->_CI->load->model('Skill_model');
            return $this->_CI->Skill_model->getallskill_array();
        }

        public function get_skill_trans_array_byuserid_chosen($owner_id)
        {
            $this->_CI->load->model('Skill_model');
            return $this->_CI->Skill_model->get_skill_trans_array_byuserid_chosen($owner_id);
        }

        public function getallskill_trans_byownerid($owner_id)
        {
            $this->_CI->load->model('Skill_model');
            return $this->_CI->Skill_model->getallskill_trans_byownerid($owner_id);
        }

        public function get_total_jobpost()
        {
            $this->_CI->load->model('Jobpost_model');
            return $this->_CI->Jobpost_model->get_total_jobpost();
        }

        public function get_total_country()
        {
            $this->_CI->load->model('Country_model');
            return $this->_CI->Country_model->get_total_country();
        }
        

        public function get_total_contact()
        {
            $this->_CI->load->model('Contact_model');
            return $this->_CI->Contact_model->get_total_contact();
        }

        /*         * ******************************** Project Model **************************** */

        public function get_job_by_userid($user_id, $listing_per_page, $offset)
        {
            $this->_CI->load->model('Project_model');
            return $this->_CI->Project_model->get_job_by_userid($user_id, $listing_per_page, $offset);
        }

        public function get_total_quotation_byjodid($job_id)
        {
            $this->_CI->load->model('Project_model');
            return $this->_CI->Project_model->get_total_quotation_byjodid($job_id);
        }

        public function get_total_jobviewcount_byjobid($job_id)
        {
            $this->_CI->load->model('Project_model');
            return $this->_CI->Project_model->get_total_jobviewcount_byjobid($job_id);
        }

        public function get_quotation_detail_byjobid($job_id)
        {
            $this->_CI->load->model('Project_model');
            return $this->_CI->Project_model->get_quotation_detail_byjobid($job_id);
        }

        public function get_total_job()
        {
            $this->_CI->load->model('Project_model');
            return $this->_CI->Project_model->get_total_job();
        }

        public function get_total_job_byuserid($user_id)
        {
            $this->_CI->load->model('Project_model');
            return $this->_CI->Project_model->get_total_job_byuserid($user_id);
        }
        public function get_total_favjob_byownerid($owner_id)
        {
            $this->_CI->load->model('Project_model');
            return $this->_CI->Project_model->get_total_favjob_byownerid($owner_id);
        }

        /*         * ******************************** Freuentlyaskedquestions Model **************************** */

        public function get_all_fq()
        {
            $this->_CI->load->model('Frequentlyaskedquestions_model');
            return $this->_CI->Frequentlyaskedquestions_model->get_all_fq();
        }
        
        /****************************************** Country Model ************************************/
        
        public function getallcountry_array()
        {
            $this->_CI->load->model('Country_model');
            return $this->_CI->Country_model->getallcountry_array();
        }
        
        /****************************************** Areaofexperitise  Model ************************************/
        
        public function get_areaexp_trans_array_byuserid($userid)
        {
            $this->_CI->load->model('Areaofexperitise_model');
            return $this->_CI->Areaofexperitise_model->getdrop_areaexp_byuserid($userid);
        }
        
        public function getallareaexp_array_bysubcategory_id($subcategory_id)
        {
            $this->_CI->load->model('Areaofexperitise_model');
            return $this->_CI->Areaofexperitise_model->getallareaexp_array_bysubcategory_id($subcategory_id);
        }
        
        public function getallareaexp_trans_byownerid($owner_id)
        {
            $this->_CI->load->model('Areaofexperitise_model');
            return $this->_CI->Areaofexperitise_model->getallareaexp_trans_byownerid($owner_id);
        }

    }
    