<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    /**
     * Base model for the application
     * 
     */
    class MY_Model extends CI_Model
    {

        private $_foundRows = 0;
        protected $_table = '';

        /**
         * Constructor.
         * @return 
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Function that returns resultset from result object. Used in many models, moved to base model.
         */
        public function getResultSet($query)
        {
            $result = null;
            if ($query && $query->num_rows() > 0)
            {
                $result = $query->result();
            }
            return $result;
        }

        /**
         * Function that returns array from mapping Object for update query. Used in many models, moved to base model.
         */
        function updateDataMapping($dataArray = null)
        {
            $updateMappingArray = array();
            foreach ($dataArray as $key => $value)
            {
                if (isset($this->dataMappingArray[$key]))
                {
                    $updateMappingArray[$this->getColumnName($key)] = $value;
                }
            }
            return $updateMappingArray;
        }

        /**
         * function will return the total rows for the query and the result set as an array. 
         * this will be used for calculation total rows for the query which helps us 
         * in calculation the total number of possible pages as per the offset.
         * 
         */
        public function get_with_count($table = '', $limit = null, $offset = null)
        {
            $result = null;
            if (in_array($this->db->dbdriver, array('mysql', 'mysqli')))
            {
//                $this->db->select('SQL_CALC_FOUND_ROWS 1', false); //This is important coz escaping is necessary here
//                array_unshift($this->db->ar_select, array_pop($this->db->ar_select));

                $query = $this->db->get($table, $limit, $offset); //echo $this->db->last_query();exit;

                $result = array(
                    'foundRows' => $this->found_rows(),
                    'resultSet' => $this->getResultSet($query),
                );
            }


            return $result;
        }

        /**
         *  this function will returns the total number of rows for the last executed query.
         */
        public function found_rows()
        {
            if (!in_array($this->db->dbdriver, array('mysql', 'mysqli')))
            {
                throw new Exception('found rows is currently available for mysql drivers only');
            }
            $total_rows = 0;
            $query = $this->db->query('select found_rows() as total_rows'); // this query needs to be skipped from last_query function
            $result = $this->getResultSet($query);

            if (!empty($result))
            {
                $total_rows = empty($result[0]->total_rows) ? 0 : $result[0]->total_rows;
            }

            // skipping the found rows query from last_query function by removing this query from $this->db->queries array.
            // this is helpful when we want to see actual query using last_query function that will returns the last executed query.
            // if this is not done then we always get the 'select found_rows() as total_rows' query as output of last_query function.
            $totalQueries = count($this->db->queries);
            if ($totalQueries > 0)
            {
                if (isset($this->db->queries[$totalQueries - 1]))
                {
                    unset($this->db->queries[$totalQueries - 1]);
                }
            }


            return $total_rows;
        }

        /**
         * Add paging and sorting clauses in query
         * 
         * @param array $pagingParams as returned by MY_Controller::getPagingParams()
         * @param array $validSortColumns allowed columns/aliases in order by clause
         * @param string $defaultColumn default column to be used for sorting if not in paging array
         * @param string $defaultDirection default order by direction if not in paging array
         */
        public function addPagingSorting(array $pagingParams, array $validSortColumns, $defaultColumn, $defaultDirection = 'ASC')
        {
            if (!empty($pagingParams['order_by']) && is_string($pagingParams['order_by']) && in_array($pagingParams['order_by'], $validSortColumns))
            {
                $sort = $pagingParams['order_by'];
                if (empty($pagingParams['order_direction']) || !in_array(strtolower($pagingParams['order_direction']), array('asc', 'desc')))
                {
                    $order = $defaultDirection;
                }
                else
                {
                    $order = $pagingParams['order_direction'];
                }
                $this->db->order_by($sort, $order);
            }
            else
            {
                if (!empty($defaultColumn) && !empty($defaultDirection))
                {
                    $this->db->order_by($defaultColumn, $defaultDirection);
                }
            }

            if (!empty($pagingParams['records_per_page']))
            {
                if (!empty($pagingParams['offset']))
                {
                    $this->db->limit(intval($pagingParams['records_per_page']), intval($pagingParams['offset']));
                }
                else
                {
                    $this->db->limit(intval($pagingParams['records_per_page']));
                }
            }
        }

        public function isDuplicate($tableName, $field, $value, $conditionField = null, $conditionValue = null)
        {
            $this->db->where($field, $value);
            if (!empty($conditionField) && !empty($conditionValue))
            {
                $this->db->where("$conditionField <>  $conditionValue");
            }

            $record = $this->db->get($tableName);

            return (bool) $record->num_rows();
        }

        public function getFileType($objectIdArray, $imageTypeFieldName, $tableName = NULL)
        {
            if (empty($tableName))
            {
                $tableName = $this->_table;
            }

            $this->db->select($imageTypeFieldName);
            $imageType = $this->db->get_where($tableName, $objectIdArray)->row($imageTypeFieldName);

            return $imageType;
        }

    }
    