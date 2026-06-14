<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/phpqrcode.php';

class MY_Qrcode
{
    public function generate($data, $size = 4)
    {
        ob_start();
        QRcode::png($data, false, QR_ECLEVEL_L, $size, 1);
        $image_data = ob_get_clean();
        return $image_data;
    }
}
