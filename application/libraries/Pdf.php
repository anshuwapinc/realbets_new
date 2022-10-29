<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/dompdf_config.inc.php');

//    require_once (dirname(__FILE__) .'/dompdf-master/autoload.inc.php');
//
//    use Dompdf\Dompdf;
//use Dompdf\Options;
class Pdf
{
    function create_latest($inputfilename, $outputfilename, $stream = TRUE)
    {
        $this->_CI = &get_instance();
        $this->_CI->load->helper('file');

        $html    = read_file($inputfilename);

        $options = new Options();
        $options->setIsRemoteEnabled(TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        if ($stream) {
            $dompdf->stream();
        } else {

            $data = $dompdf->output();
            write_file($outputfilename, $data);
        }
    }

    function create($inputfilename, $outputfilename, $stream = TRUE)
    {
        $this->_CI = &get_instance();
        $this->_CI->load->helper('file');

        $html = read_file($inputfilename);
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper("a4", "portrait");
        $dompdf->render();
        if ($stream) {
            $dompdf->stream();
        } else {
            $data = $dompdf->output();
            write_file($outputfilename, $data);
        }
    }
}
