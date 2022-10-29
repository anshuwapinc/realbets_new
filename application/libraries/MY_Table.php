<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class MY_Table extends CI_Table
    {

        var $classes = array();
        var $widths = array();
        var $auto_class = false;

        function __construct()
        {
            parent::__construct();
            // load table template from table config
            $CI = & get_instance();
            if ($CI->config->load('table', false, true))
            {
                $this->template = $CI->config->item('template');
            }

            log_message('debug', "MY Table Class Initialized");
        }

        /**
         * Set the template
         *
         * @access	public
         * @param	array
         * @return	void
         */
        function set_template($template)
        {
            if (!is_array($template))
            {
                return FALSE;
            }

            $this->template = $template;
            //$this->template = array_merge($this->template, $template);
        }

        // --------------------------------------------------------------------

        /**
         * Set the table widths and classes
         *
         * Can be passed as an array or discreet params
         *
         * @access	public
         * @param	mixed
         * @return	void
         */
        function set_classes()
        {
            $args = func_get_args();
            $this->classes = (is_array($args[0])) ? $args[0] : $args;
        }

        function set_widths()
        {
            $args = func_get_args();
            $this->widths = (is_array($args[0])) ? $args[0] : $args;
        }

        // --------------------------------------------------------------------


        function generate($table_data = NULL)
        {

            // The table data can optionally be passed to this function
            // either as a database result object or an array
            if (!is_null($table_data))
            {
                if (is_object($table_data))
                {
                    $this->_set_from_object($table_data);
                } elseif (is_array($table_data))
                {
                    $set_heading = (count($this->heading) == 0 AND $this->auto_heading == FALSE) ? FALSE : TRUE;
                    $this->_set_from_array($table_data, $set_heading);
                }
            }

            // Is there anything to display?  No?  Smite them!
            if (count($this->heading) == 0 AND count($this->rows) == 0)
            {
                return 'Undefined table data';
            }

            // Compile and validate the template date
            $this->_compile_template();

            // set a custom cell manipulation function to a locally scoped variable so its callable
            $function = $this->function;

            // Build the table!

            $out = $this->template['table_open'];
            $out .= $this->newline;

            // Add any caption here
            if ($this->caption)
            {
                $out .= $this->newline;
                $out .= '<caption>' . $this->caption . '</caption>';
                $out .= $this->newline;
            }

            // Is there a table heading to display?
            if (count($this->heading) > 0)
            {
                $out .= $this->template['thead_open'];
                $out .= $this->newline;
                $out .= $this->template['heading_row_start'];
                $out .= $this->newline;

                foreach ($this->heading as $key => $heading)
                {
                    $temp = $this->template['heading_cell_start'];

                    // MOD --------------------
                    // add in column classes and widths in THEAD cells
                    if (!empty($this->widths[$key]))
                        $temp = str_replace('<th', "<th width='{$this->widths[$key]}'", $temp);

                    // auto-generate classes
                    if ($this->auto_class)
                    {
                        $classes = array();
                        for ($i = 0; $i < count($this->heading); $i++)
                        {
                            $classes[] = 'c' . $i;
                        }
                        $this->set_classes($classes);
                    }

                    if (!empty($this->classes[$key]))
                        $temp = str_replace('<th', "<th class='{$this->classes[$key]}'", $temp);
                    // MOD END  ---------------

                    foreach ($heading as $key => $val)
                    {
                        if ($key != 'data')
                        {
                            $temp = str_replace('<th', "<th $key='$val'", $temp);
                        }
                    }

                    $out .= $temp;
                    $out .= isset($heading['data']) ? $heading['data'] : '';
                    $out .= $this->template['heading_cell_end'];
                }

                $out .= $this->template['heading_row_end'];
                $out .= $this->newline;
                $out .= $this->template['thead_close'];
                $out .= $this->newline;
            }

            // Build the table rows
            if (count($this->rows) > 0)
            {
                $out .= $this->template['tbody_open'];
                $out .= $this->newline;

                $i = 1;
                foreach ($this->rows as $row)
                {
                    if (!is_array($row))
                    {
                        break;
                    }

                    // We use modulus to alternate the row colors
                    $name = (fmod($i++, 2)) ? '' : 'alt_';

                    $rowtemp = $this->template['row_' . $name . 'start'];

                    // MOD --------------------
                    if (array_key_exists('row_id', $row))
                    {
                        // see if we're passing row_id, if so add it to tr tag
                        $row_id = $row['row_id']['data'];
                        unset($row['row_id']);

                        $find = "<tr";
                        $replace = "{$find} id='tr-{$row_id}' ";
                        $rowtemp = str_replace($find, $replace, $rowtemp);
                    }

                    // see if we're passing row_class, if so add it to tr tag
                    if (array_key_exists('row_class', $row))
                    {
                        $row_class = $row['row_class']['data'];
                        unset($row['row_class']);

                        // look for a class attribute first
                        $find = "/(class=[\"\'])/";
                        $replace = "$1{$row_class} ";
                        $rowtemp = preg_replace($find, $replace, $rowtemp, -1, $count);
                        // otherwise, add it to the tr tag
                        if (empty($count))
                        {
                            $find = "/(\<tr)/";
                            $replace = '<tr class="' . $row_class . '"';
                            $rowtemp = preg_replace($find, $replace, $rowtemp);
                        }
                    }
                    // MOD END--------------------

                    $out .= $rowtemp . $this->newline;

                    $j = 0;
                    foreach ($row as $cell)
                    {
                        $temp = $this->template['cell_' . $name . 'start'];

                        // MOD --------------------
                        // if we didn't do heading, then add widths to first row of cells
                        if (!empty($this->widths[$key]) && count($this->heading) == 0 && $j == 0)
                            $temp = str_replace('<td', "<td width='{$this->widths[$key]}'", $temp);

                        // now add our classes to cells
                        if (!empty($this->classes[$j]))
                        {
                            $temp = str_replace('<td', "<td class='{$this->classes[$j]}'", $temp);
                        }
                        $j++;
                        // MOD END --------------------

                        foreach ($cell as $key => $val)
                        {
                            if ($key != 'data')
                            {
                                $temp = str_replace('<td', "<td $key='$val'", $temp);
                            }
                        }

                        $cell = isset($cell['data']) ? $cell['data'] : '';
                        $out .= $temp;

                        if ($cell === "" OR $cell === NULL)
                        {
                            $out .= $this->empty_cells;
                        } else
                        {
                            if ($function !== FALSE && is_callable($function))
                            {
                                $out .= call_user_func($function, $cell);
                            } else
                            {
                                $out .= $cell;
                            }
                        }

                        $out .= $this->template['cell_' . $name . 'end'];
                    }

                    $out .= $this->template['row_' . $name . 'end'];
                    $out .= $this->newline;
                }

                $out .= $this->template['tbody_close'];
                $out .= $this->newline;
            }

            $out .= $this->template['table_close'];

            return $out;
        }

    }
    