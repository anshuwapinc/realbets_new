<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Excel
    {

        private $excel;

        public function __construct()
        {
            require_once APPPATH.'third_party/PHPExcel/PHPExcel.php';
            $this->excel = new PHPExcel();
        }

        public function load($path)
        {
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $this->excel = $objReader->load($path);
        }

        public function save($path)
        {
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save($path);
        }

        public function stream($filename, $data = null)
        {
            if ($data != null)
            {
                $col = 'A';
                foreach ($data[0] as $key => $val)
                {
                    $objRichText = new PHPExcel_RichText();
                    $objPayable = $objRichText->createTextRun(str_replace("_", " ", $key));
                    $this->excel->getActiveSheet()->getCell($col.'1')->setValue($objRichText);
                    $col++;
                }
                $rowNumber = 2;
                foreach ($data as $row)
                {
                    $col = 'A';
                    foreach ($row as $cell)
                    {
                        $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $cell);
                        $col++;
                    }
                    $rowNumber++;
                }
            }
            header('Content-type: application/ms-excel');
            header("Content-Disposition: attachment; filename=\"".$filename."\"");
            header("Cache-control: private");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save("static/export/$filename");
            header("location: ".base_url()."static/export/$filename");
            unlink(base_url()."static/export/$filename");
        }

        public function manual_stream($filename, $data = null, $type = '')
        {
            if ($data != null)
            {
                $objRichText = new PHPExcel_RichText();

                if ($type != 'departure_report')
                {
                    $this->excel->getActiveSheet()
                        ->setCellValue('A1', 'MNGID')
                        ->setCellValue('B1', 'Username')
                        ->setCellValue('C1', 'Distributor ID')
                        ->setCellValue('D1', 'Product Category')
                        ->setCellValue('E1', 'Airport')
                        ->setCellValue('F1', 'Arrival Time')
                        ->setCellValue('G1', 'Arrival Flight #')
                        ->setCellValue('H1', 'Departure Time')
                        ->setCellValue('I1', 'Departure Flight #')
                        ->setCellValue('J1', 'Adult Tickets')
                        ->setCellValue('K1', 'Child Tickets')
                        ->setCellValue('L1', 'Comp. Tickets')
                        ->setCellValue('M1', 'Charged Amount')
                        ->setCellValue('N1', 'Auth #')
                        ->setCellValue('O1', 'Cardholder Name')
                        ->setCellValue('P1', 'Card #')
                        ->setCellValue('Q1', 'Reference #')
                        ->setCellValue('R1', 'Ticket #')
                        ->setCellValue('S1', 'Passenger Details');
                }
                else
                {
                    $this->excel->getActiveSheet()
                        ->setCellValue('A1', 'Reservation #')
                        ->setCellValue('B1', 'Username')
                        ->setCellValue('C1', 'Distributor ID')
                        ->setCellValue('D1', 'Product Category')
                        ->setCellValue('E1', 'Airport')
                        ->setCellValue('F1', 'Flight Time')
                        ->setCellValue('G1', 'Flight #')
                        ->setCellValue('H1', 'Adult Tickets')
                        ->setCellValue('I1', 'Child Tickets')
                        ->setCellValue('J1', 'Comp. Tickets')
                        ->setCellValue('K1', 'Charged Amount')
                        ->setCellValue('L1', 'Auth #')
                        ->setCellValue('M1', 'Cardholder Name')
                        ->setCellValue('N1', 'Card #')
                        ->setCellValue('O1', 'Reference #')
                        ->setCellValue('P1', 'Ticket #')
                        ->setCellValue('Q1', 'Passenger Details');
                }

                $rowNumber = 2;
                foreach ($data as $row)
                {
                    $ticketNumber = '';
                    if (!empty($row['ticketnumber']))
                    {
                        $tmp = explode('|', $row['ticketnumber']);
                        foreach ($tmp as $key => $value)
                        {
                            $tmp2 = explode(', ', $value);
                            if ($ticketNumber != '')
                            {
                                $ticketNumber .= ', '.$tmp2[0];
                            }
                            else
                            {
                                $ticketNumber = $tmp2[0];
                            }
                        }
                    }

                    $col = 'A';
                    foreach ($row as $cell)
                    {
                        if ($col == 'A')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['MNGID']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Reservation #']);
                        }
                        elseif ($col == 'B')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Distributor Name']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Distributor Name']);
                        }
                        elseif ($col == 'C')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Distributor ID']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Distributor ID']);
                        }
                        elseif ($col == 'D')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Product']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Product']);
                        }
                        elseif ($col == 'E')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Airport']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Airport']);
                        }
                        elseif ($col == 'F')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Flight Time']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Flight Time']);
                        }
                        elseif ($col == 'G')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Flight #']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Flight #']);
                        }
                        elseif ($col == 'H')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, ($row['Departure Date/Time'] == '0000-00-00 00:00:00' ? 'NA' : $row['Departure Date/Time'])) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Adult Tickets']);
                        }
                        elseif ($col == 'I')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, ($row['Departure Flight #'] == '' ? 'NA' : $row['Departure Flight #'])) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Child Tickets']);
                        }
                        elseif ($col == 'J')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Adult Tickets']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Comp. Tickets']);
                        }
                        elseif ($col == 'K')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Child Tickets']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Charged Amount']);
                        }
                        elseif ($col == 'L')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Comp. Tickets']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Auth #']);
                        }
                        elseif ($col == 'M')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Charged Amount']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Cardholder Name']);
                        }
                        elseif ($col == 'N')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Auth #']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Card #']);
                        }
                        elseif ($col == 'O')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Cardholder Name']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['referencenumber']);
                        }
                        elseif ($col == 'P')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Card #']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $ticketNumber);
                        }
                        elseif ($col == 'Q')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['referencenumber']) : $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Passenger']);
                        }
                        elseif ($col == 'R')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $ticketNumber) : FALSE;
                        }
                        elseif ($col == 'S')
                        {
                            $type != 'departure_report' ? $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['Passenger']) : FALSE;
                        }

                        $col++;
                    }
                    $rowNumber++;
                }
            }
            header('Content-type: application/ms-excel');
            header("Content-Disposition: attachment; filename=\"".$filename."\"");
            header("Cache-control: private");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save("static/export/$filename");
            header("location: ".base_url()."static/export/$filename");
            unlink(base_url()."static/export/$filename");
        }

        public function commission_manual_stream($filename, $data = NULL)
        {
            if ($data != NULL)
            {
                $objRichText = new PHPExcel_RichText();

                $this->excel->getActiveSheet()
                    ->setCellValue('A1', 'Airport')
                    ->setCellValue('B1', 'Product')
                    ->setCellValue('C1', 'Confirmation #')
                    ->setCellValue('D1', 'Reservation #')
                    ->setCellValue('E1', 'Contact Name')
                    ->setCellValue('F1', 'Transaction Date')
                    ->setCellValue('G1', 'Source')
                    ->setCellValue('H1', 'Adult Ticket(s)')
                    ->setCellValue('I1', 'Child(ren) Ticket(s)')
                    ->setCellValue('J1', 'Adult Rate')
                    ->setCellValue('K1', 'Child Rate')
                    ->setCellValue('L1', 'Commission Amount');

                $rowNumber = 2;
                foreach ($data as $row)
                {
                    $col = 'A';
                    foreach ($row as $cell)
                    {
                        if ($col == 'A')
                        {
                            $airport = constant($row['airportid']);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $airport);
                        }
                        else if ($col == 'B')
                        {
                            $product = constant($row['productid']);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $product);
                        }
                        else if ($col == 'C')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['confirmationnumber']);
                        }
                        else if ($col == 'D')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['reservationnumber']);
                        }
                        else if ($col == 'E')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['contactname']);
                        }
                        else if ($col == 'F')
                        {
                            $date = date('d-M-Y', strtotime($row['transactiondate']));
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $date);
                        }
                        else if ($col == 'G')
                        {
                            if ($row['onlineentry'] == "N")
                            {
                                $source = "Reservation Team";
                            }
                            else
                            {
                                $source = "Online";
                            }
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $source);
                        }
                        else if ($col == 'H')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['adulttickets']);
                        }
                        else if ($col == 'I')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['childtickets']);
                        }
                        else if ($col == 'J')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, number_format($row['adultcommissionamount'], 2));
                        }
                        else if ($col == 'K')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, number_format($row['childcommissionamount'], 2));
                        }
                        else if ($col == 'L')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, number_format($row['commissionamount'], 2));
                        }
//                        elseif ($col == 'L') {
//                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber,$row['commissionamount']);
//                        }

                        $col++;
                    }
                    $rowNumber++;
                }
            }
            header('Content-type: application/ms-excel');
            header("Content-Disposition: attachment; filename=\"".$filename."\"");
            header("Cache-control: private");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save("static/export/$filename");
            header("location: ".base_url()."static/export/$filename");
            unlink(base_url()."static/export/$filename");
        }

        public function order_manual_stream($filename, $data = NULL)
        {
            if ($data != NULL)
            {
                $objRichText = new PHPExcel_RichText();

                $this->excel->getActiveSheet()
                    ->setCellValue('A1', 'Reservation ID')
                    ->setCellValue('B1', 'Product')
                    ->setCellValue('C1', 'Contact Name')
                    ->setCellValue('D1', 'Contact Phone')
                    ->setCellValue('E1', 'Email');

                $rowNumber = 2;
                foreach ($data as $row)
                {
                    $col = 'A';
                    foreach ($row as $cell)
                    {
                        $row = (array) $row;
                        if ($col == 'A')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['reservationid']);
                        }
                        else if ($col == 'B')
                        {
                            $product = constant($row['productid']);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $product);
                        }
                        else if ($col == 'C')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['contactname']);
                        }
                        else if ($col == 'D')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['contactphone']);
                        }
                        else if ($col == 'E')
                        {
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $row['contactemail']);
                        }
                        $col++;
                    }
                    $rowNumber++;
                }
            }
            header('Content-type: application/ms-excel');
            header("Content-Disposition: attachment; filename=\"".$filename."\"");
            header("Cache-control: private");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save("static/export/$filename");
            header("location: ".base_url()."static/export/$filename");
            unlink(base_url()."static/export/$filename");
        }

        public function bill_manual_stream($filename, $data = NULL)
        {

            if ($data != NULL)
            {
                $objRichText = new PHPExcel_RichText();

                $this->excel->getActiveSheet()
                    ->setCellValue('A1', 'Start Date')
                    ->setCellValue('B1', 'End Date')
                    ->setCellValue('C1', 'Bill Date')
                    ->setCellValue('D1', 'Due Date')
                    ->setCellValue('E1', 'Opening Balance')
                    ->setCellValue('F1', 'Payments')
                    ->setCellValue('G1', 'Adjustment')
                    ->setCellValue('H1', 'Balance B/F')
                    ->setCellValue('I1', 'Current Charges')
                    ->setCellValue('J1', 'Total Due');

//                        ->setCellValue('K1', 'Paid')
//                        ->setCellValue('L1', 'Bill Payable Amount');

                $rowNumber = 2;
                foreach ($data as $row)
                {
                    $col = 'A';
                    foreach ($row as $cell)
                    {
                        $bill_details = (array) $row;
                        if ($col == 'A')
                        {
                            $date = date('Y-m-d', strtotime($bill_details['startdate']));
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $date);
                        }
                        else if ($col == 'B')
                        {
                            $end_date = date('Y-m-d', strtotime($bill_details['enddate']));
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $end_date);
                        }
                        else if ($col == 'C')
                        {
                            $bill_date = date('Y-m-d', strtotime($bill_details['billdate']));
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $bill_date);
                        }
                        else if ($col == 'D')
                        {
                            $due_date = date('Y-m-d', strtotime($bill_details['duedate']));
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $due_date);
                        }
                        else if ($col == 'E')
                        {
                            $op_bal = number_format($bill_details['openingbalance'], 2);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $op_bal);
                        }
                        else if ($col == 'F')
                        {
                            $op_bal = number_format($bill_details['paymentamount'], 2);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $op_bal);
                        }
                        else if ($col == 'G')
                        {
                            $op_bal = number_format($bill_details['adjustmentamount'], 2);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $op_bal);
                        }
                        else if ($col == 'H')
                        {
                            $op_bal = number_format($bill_details['broughtforwardamount'], 2);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $op_bal);
                        }
                        else if ($col == 'I')
                        {
                            $op_bal = number_format($bill_details['billamount'], 2);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $op_bal);
                        }
                        else if ($col == 'J')
                        {
                            $op_bal = number_format($bill_details['outstandingamount'], 2);
                            $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $op_bal);
                        }
//                    else if ($col == 'K')
//                    {
//                        $op_bal = number_format($bill_details['paidamount'],2);
//                        $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $op_bal);
//                    }
//                    else if ($col == 'L')
//                    {
//                        $op_bal = number_format($bill_details['billpayableamount'],2);
//                        $this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $op_bal);
//                    }

                        $col++;
                    }
                    $rowNumber++;
                }
            }
            header('Content-type: application/ms-excel');
            header("Content-Disposition: attachment; filename=\"".$filename."\"");
            header("Cache-control: private");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//        $objWriter->save("static/export/$filename");
            $objWriter->save('php://output');
            header("location: ".base_url()."static/export/$filename");
            unlink(base_url()."static/export/$filename");
        }

        public function __call($name, $arguments)
        {
            if (method_exists($this->excel, $name))
            {
                return call_user_func_array(array($this->excel, $name), $arguments);
            }
            return null;
        }

    }
    