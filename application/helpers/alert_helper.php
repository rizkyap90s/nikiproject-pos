<?php
/**
 *
 * Author    : Fauzan Falah ( Anang )
 * File      : alert_cms_helper.php
 * Web Name  : Kasir Cafe
 * Version   : v1.0.0
 * Website   : https://www.codekop.com/
 * License   : MIT
 * Framework : CodeIgniter v3.1.11
 * Facebook  : https://www.facebook.com/fauzan.falah2
 * HP/WA	 : 089618173609
 * E-mail 	 : codekop157@gmail.com / fauzancodekop@gmail.com / fauzan1892@codekop.com
 * Ket       : Berisi tentang fungsi-fungsi alert alert yg digunakan
 *
 *
 */

if (!function_exists('alert_failed')) {
    function alert_failed($html)
    {
        $alert = '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        '.$html.'
                    </div>';
        return $alert;
    }
}

if (!function_exists('alert_success')) {
    function alert_success($html)
    {
        $alert = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        '.$html.'
                    </div>';
        return $alert;
    }
}

function cek_id($table, $col, $val)
{
    $sql = "SELECT * FROM $table WHERE $col = ? ORDER BY id DESC LIMIT 1";
    $ci =& get_instance();
    $cek = $ci->db->query($sql, [$val])->num_rows();
    if ($cek > 0) {
        return time();
    } else {
        return $val;
    }
}
