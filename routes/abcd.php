<?php
// reference the Dompdf namespace
use Dompdf\Dompdf;
//get itinerary details
$country_json = file_get_contents(plugin_dir_url(plugin_dir_path(__DIR__)) . 'isocountry.json');
$bbi_countries = (array)json_decode($country_json);

$itinerary_id = get_query_var('bbi-id');

$itinerary_details = get_post($itinerary_id);
$meta_details = get_post_meta($itinerary_id);
$package_name = get_the_title($meta_details['bb_country_package'][0]);
$package_country = (isset($meta_details['bb_package_country'])) ? $bbi_countries[$meta_details['bb_package_country'][0]] : '';
// customer details
$customer_prefix = (isset($meta_details['bb_customer_prefix'])) ? $meta_details['bb_customer_prefix'][0] : '';
$customer_name = (isset($meta_details['bb_customer_name'])) ? $meta_details['bb_customer_name'][0] : '';
$country_dial_code = (isset($meta_details['bb_country_dial_code'])) ? $meta_details['bb_country_dial_code'][0] : '';
$customer_phone = (isset($meta_details['bb_customer_phone'])) ? $meta_details['bb_customer_phone'][0] : '';
$customer_email = (isset($meta_details['bb_customer_email'])) ? $meta_details['bb_customer_email'][0] : '';
//package details
$package_no_adults = (isset($meta_details['bb_package_no_adults'])) ? $meta_details['bb_package_no_adults'][0] : '';
$package_travel_date = (isset($meta_details['bb_package_travel_date'])) ? $meta_details['bb_package_travel_date'][0] : '';
$travel_date_day_month = !empty($package_travel_date) ? get_the_date('d F', $itinerary_id) : '';
$travel_date_day_month_year = !empty($package_travel_date) ? get_the_date('d/m/Y', $itinerary_id) : '';
$package_executed_from = (isset($meta_details['bb_package_executed_from'])) ? $meta_details['bb_package_executed_from'][0] : '';
$package_currency = (isset($meta_details['bb_package_currency'])) ? $meta_details['bb_package_currency'][0] : '';
$package_cost = (isset($meta_details['bb_package_cost'])) ? $meta_details['bb_package_cost'][0] : '';
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$plugin_pdf_asset_dir = plugin_dir_url(plugin_dir_path(__FILE__));
$plugin_pdf_img_dir = plugin_dir_url(plugin_dir_path(__FILE__)) . '/images/pdf/';
$tbl_img_1 = $plugin_pdf_img_dir . 'Dubai-Backgrounds.jpg';
$logo = $plugin_pdf_img_dir . 'logo.png';
$check_mark_img = $plugin_pdf_img_dir . 'check_mark.png';
$star_icon_img = $plugin_pdf_img_dir . 'star_icon.png';
$red_car_icon_img = $plugin_pdf_img_dir . 'red_car.png';
$plane_icon_img = $plugin_pdf_img_dir . 'plane.png';
$cross_icon_img = $plugin_pdf_img_dir . 'cross.png';
$skyline_icon_img = $plugin_pdf_img_dir . 'skyline.jpg';
$skyline_header_icon_img = $plugin_pdf_img_dir . 'skyline_header.png';
//extra details
$tour_inclusions = isset($meta_details['bb_tour_inclusions']) ? json_decode($meta_details['bb_tour_inclusions'][0]) : '';
$tour_exclusions = isset($meta_details['bb_tour_exclusions']) ? json_decode($meta_details['bb_tour_exclusions'][0]) : '';
$travel_inclusions = isset($meta_details['bb_travel_inclusions']) ? json_decode($meta_details['bb_travel_inclusions'][0]) : '';
$inclusive_addon = isset($meta_details['bb_inclusive_addon']) ? json_decode($meta_details['bb_inclusive_addon'][0]) : '';
$city_transfer = isset($meta_details['bb_city_transfer']) ? json_decode($meta_details['bb_city_transfer'][0]) : '';
global $wpdb;

$customer_email_html = '';
if (!empty($customer_email)) {
    $customer_email_html .= '
                  <p>
                        <strong>Email:</strong>
                        ' . $customer_email . '
                 </p>
    ';
}
//tour inclusions
$tour_inclusions_html = '';
$tour_inclusion_heading_td = '';
$country_tour_inclusions_tbl = $wpdb->prefix . 'country_tour_inclusions';
if (!empty($tour_inclusions)) {
    $tour_inclusions_html .= '<h3 style="font-size: 15px;margin: 10px 0;" class="bb-primary-color">Tour Inclusions:</h3>';
    foreach ($tour_inclusions as $key => $value) {
        $inclusion = $wpdb->get_row("SELECT * FROM $country_tour_inclusions_tbl WHERE id= '" . $value . "'
    ");

        $tour_inclusions_html .= '
        <div class="bb__icon__content">
            <img src="' . $check_mark_img . '" alt="">
            <p>' . $inclusion->content . '</p>
            <div class="clear-both"></div>
        </div>
        ';
    }
}
//tour exclusions
$tour_exclusions_html = '';
$country_tour_exclusions_tbl = $wpdb->prefix . 'country_tour_exclusions';
if (!empty($tour_exclusions)) {
    $tour_exclusions_html .= '
    <h3 style="font-size: 15px;margin: 10px 0;" class="bb-primary-color">Tour Exclusion:</h3>
    ';
    foreach ($tour_exclusions as $key => $value) {
        $exclusion = $wpdb->get_row("SELECT * FROM $country_tour_exclusions_tbl WHERE id= '" . $value . "'
    ");

        $tour_exclusions_html .= '
        <div class="bb__icon__content">
            <img src="' . $cross_icon_img . '" alt="">
            <p>' . $exclusion->content . '</p>
            <div class="clear-both"></div>
        </div>
        ';
    }
}

$tour_inclusion_exclusion_data = $tour_inclusions_html . $tour_exclusions_html;


//travel inclusions
$travel_inclusions_html = '';
$country_travel_inclusions_tbl = $wpdb->prefix . 'country_travel_inclusions';
if (!empty($travel_inclusions)) {
    $travel_inclusions_html .= '
    <h3 style="font-size: 15px;margin: 10px 0;" class="bb-primary-color">Travel Inclusion:</h3>
    ';
    foreach ($travel_inclusions as $key => $value) {
        $inclusion = $wpdb->get_row("SELECT * FROM $country_travel_inclusions_tbl WHERE id= '" . $value . "'
    ");

        $travel_inclusions_html .= '
        <div class="bb__icon__content">
            <img src="' . $plane_icon_img . '" alt="">
            <p>' . $inclusion->content . '</p>
            <div class="clear-both"></div>
        </div>
        ';
    }
}
//travel exclusive addon
$country_exclusive_addon_html = '';
$country_exclusive_addon_tbl = $wpdb->prefix . 'country_exclusive_addon';
if (!empty($inclusive_addon)) {
    $country_exclusive_addon_html .= '
    <h3 style="font-size: 15px;margin: 10px 0;" class="bb-primary-color">Exclusive Add-on:</h3>
    ';
    foreach ($inclusive_addon as $key => $value) {
        $exclusion = $wpdb->get_row("SELECT * FROM $country_exclusive_addon_tbl WHERE id= '" . $value . "'
    ");

        $country_exclusive_addon_html .= '
    <div class="bb__icon__content">
        <img src="' . $star_icon_img . '" alt="">
        <p>' . $exclusion->content . '</p>
        <div class="clear-both"></div>
    </div>
    ';
    }
}

$travel_inclusions_country_exclusive_addon_data = $travel_inclusions_html . $country_exclusive_addon_html;

//extra details city trnsfer
$city_transfer_html = '';
$country_city_transfer_tbl = $wpdb->prefix . 'country_city_transfer';
if (!empty($city_transfer)) {
    $city_transfer_html .= '
    <h3 style="font-size: 15px;margin: 10px 0;" class="bb-primary-color">City Transfer:</h3>
    ';
    foreach ($city_transfer as $key => $value) {
        $city_transfer = $wpdb->get_row("SELECT * FROM $country_city_transfer_tbl WHERE id= '" . $value . "'
    ");
        $city_transfer_html .= '
    <div class="bb__icon__content">
        <img src="' . $red_car_icon_img . '" alt="">
        <p>' . $city_transfer->content . '</p>
        <div class="clear-both"></div>
    </div>
    ';
    }
}
$city_transfer_data = $city_transfer_html;


$customer_mobile_phone_html = '';
if (!empty($customer_phone)) {
    $customer_mobile_phone_html .= '
     <p>
           <span>
            <strong>Mobile:</strong>
            +' . $country_dial_code . ' ' . $customer_phone . '
        </p>
    ';
}
$colspan_2_html = '';
if (!empty($customer_phone)) {
    $colspan_2_html .= 'colspan="2"';
} else {
    $colspan_2_html .= 'colspan="12"';
}

//Hotel details
$hotel_details_para = '';
$hotel_details = $meta_details['bb_hotel_details'][0];
$hotel_details = (array)json_decode($hotel_details);
if (!empty($hotel_details)) {
    $hotel_details_para .= '
        <tr>
            <td class="bb-heading" colspan="2">
                <h4 class="bb-text-left bb-text-left-details" style="margin-top: 0;">Accommodation </h4>
            </td>
            <td></td>
        </tr>
    ';
    foreach ($hotel_details as $k => $v) {
        $count = $k + 1;
        $hotel_name = get_the_title($v->hotel_id);
        $hotel_city_location = '<span class=""><strong style="padding-right: 1px;">City / Location</strong><span>:</span> </span>';
        if (!empty($v->hotel_city)) {
            $hotel_city_location .= ' <span style="margin-left: 10px;">' . $v->hotel_city . '</span>';
        }
        if (!empty($v->hotel_city) && !empty($v->hotel_country)) {
            $hotel_city_location .= ' / ';
        }
        if (empty($v->hotel_country)) {
            $hotel_city_location .= ' <br> ';
        }
        if (!empty($v->hotel_country)) {
            $hotel_country = $bbi_countries[$v->hotel_country];
            $hotel_city_location .= '<span>' . $hotel_country . '</span><br>';
        }
        $hotel_meal_plan = '';
        if (!empty($v->bb_hotel_meal_plan)) {
            $hotel_meal_plan = '<span><strong>Meal Plan</strong><span class="divider-gap-37" style="padding-right: 21px;">:</span></span>';
            $hotel_meal_plan .= '<span>' . $v->bb_hotel_meal_plan . '</span>';
        }

        $no_of_pax = '';
        $is_any_pax = 0;
        $no_of_pax .= '<span>' . $v->hotel_no_of_pax . ' Pax</span>';
        if ($v->hotel_no_of_adults != 0) {
            if ($is_any_pax == 0) {
                $pax_sym = '=';
            } else {
                $pax_sym = '+';
            }
            $is_any_pax++;
            $no_of_pax .= '<span> ' . $pax_sym . ' ' . $v->hotel_no_of_adults . ' Adults</span>';
        }
        if ($v->hotel_no_of_childs != 0) {
            if ($is_any_pax == 0) {
                $pax_sym = '=';
            } else {
                $pax_sym = '+';
            }
            $is_any_pax++;
            $no_of_pax .= '<span> ' . $pax_sym . ' ' . $v->hotel_no_of_childs . ' Childs</span>';
        }
        if ($v->hotel_no_of_infants != 0) {
            if ($is_any_pax == 0) {
                $pax_sym = '=';
            } else {
                $pax_sym = '+';
            }
            $is_any_pax++;
            $no_of_pax .= '<span> ' . $pax_sym . ' ' . $v->hotel_no_of_infants . ' Infants</span>';
        }
        $hotel_no_of_rooms = '';
        $hotel_no_of_rooms .= '
            <span><strong style="padding-right: 2px;">No. of Rooms</strong><span class="divider-gap-6">:</span> </span><span style="margin-left: 4px;">' . $v->hotel_no_of_rooms;
        $is_any_pax = 0;
        if (!empty($v->hotel_no_of_rooms_one)) {
            if ($is_any_pax == 0) {
                $pax_sym = '=';
            } else {
                $pax_sym = '+';
            }
            $is_any_pax++;
            $hotel_no_of_rooms .= ' ' . $pax_sym . ' ' . $v->hotel_no_of_rooms_one . ' x ' . $v->hotel_occupancy_type;
        }
        if (!empty($v->hotel_no_of_rooms_two)) {
            if ($is_any_pax == 0) {
                $pax_sym = '=';
            } else {
                $pax_sym = '+';
            }
            $is_any_pax++;
            $hotel_no_of_rooms .= ' ' . $pax_sym . ' ' . $v->hotel_no_of_rooms_two . ' x ' . $v->hotel_occupancy_type_two;
        }
        $hotel_no_of_rooms .= '</span><br>';
        $notes = '';
        if (!empty($v->bb_hotel_notes)) {
            $notes .= '<p class="bb-mt-20 bb-text-center"><strong>' . $v->bb_hotel_notes . '</strong></p><br>';
        }
        $occupancy_type = '';
        if (!empty($v->hotel_occupancy_type)) {
            $occupancy_type .= '
            <span><strong>Room Type</strong><span class="divider-gap">:</span> </span><span>' . $v->hotel_occupancy_type . '</span>
            ';
        }
        if (!empty($v->hotel_occupancy_type_two)) {
            $occupancy_type .= '
            <span>Room Type<span class="divider-gap">:</span></span><span>' . $v->hotel_occupancy_type_two . '</span>
            ';
        }
        $hotel_details_para .= '
                <tr class="bb__hotel__details__border">
                    <td class="bb-heading-first-row" colspan="2">
                        <div>
                            <br>
                            ' . $hotel_city_location . '
                            <span><strong>Hotel Name</strong><span class="divider-gap-23">:</span> </span> <span>' . $hotel_name . '</span><br>';
        if ($v->hotel_duration != 0) {
            $hotel_details_para .= '
                                <span><strong>No. of night</strong><span class="divider-gap-22">:</span> </span> <span>' . $v->hotel_duration .  '</span><br>';
        }
        $hotel_details_para .= '
                            <span><strong>No. of Pax</strong><span class="divider-gap-33" style="padding-right: 18px;">:</span><span>' . $no_of_pax . '<br>
                            ' . $hotel_no_of_rooms . '
                            ' . $hotel_meal_plan . '<br>
                            ' . $notes . '
                        </div>
                    </td>
                    <td></td>
                 </tr>
        ';
    }
}

$htmldata = '

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dom PDF</title>
    <style>
    * {
        text-decoration: none;
        box-sizing: border-box;
        list-style: none;
        margin: 0;
        padding: 0;
        font-family: "Roboto", sans-serif;
    }

    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Zeyada&display=swap");
    @font-face {
        font-family: "Akaya Kanadaka";
        font-style: normal;
        font-weight: normal;
        src: url(https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&display=swap) format("truetype");
      }
    .bb-all-table-main-parent {
        padding: 30px 0;
        padding-top: 0;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .bb_second_table{
        padding: 50px;
    }
    .bb_second_table .bb_second_table-td-one p {
        font-size: 16px;
        font-weight: 400;
        color: rgb(0, 0, 0, 0.7);
        margin-bottom: 20px;
        text-align: justify;
    }

    .bb_third_table tr td {
        padding: 8px;
    }

    .bb_third_table {
        border-collapse: collapse;
        width: 100%;
        padding: 50px;
        padding-top: 5px;
    }
    .bb_third_table tr td:last-child {
        border-right: unset;
    }

    .bb_third_table tr td:first-child {
        border-left: unset;
    }

    .bb_third_table tr:first-child td {
        border-top: unset;
    }

    .bb_third_table h4, .bb-package-table h4 {
        font-weight: 700;
    }
    .bb_third_table h4 span, .bb-package-table h4 span{
        font-family: Akaya Kanadaka;
        font-style: italic;
    }

    .bb-text-center {
        text-align: center;
    }

    .bb-fourth-table tr td {
        vertical-align: top;
        width: 400px;
    }

    .bb-fourth-table {
        //margin-top: 100px;
        padding: 50px;
    }

    .bb-fourth-table p {
        font-size: 15px;
        line-height: 28px;
        float: left;
        width: 90%;
    }

    .bb-fourth-table img {
        width: 15px;
        display: block;
        float: left;
        margin-right: 5px;
        margin-top: 6px;
    }

    .clear-both {
        clear: both;
    }

    .bb-fourth-table h3 {
        font-size: 18px;
        font-weight: 900;
        margin-bottom: 30px;
        text-decoration: underline;
    }

    .bb_first_table {
        background-image: url("' . $tbl_img_1 . '");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 30%;
        width: 100%;
        padding-top: 160px;
        height: 900px;
    }

    .bb_first_table_rotate {
        background: #59719F;
        width: 160px;
        padding: 10px;
        transform: rotate(-90deg);
        transform-origin: 0% 0%;
    }

    .bb_first_table_rotate p {
        text-align: center;
        color: #fff;
        font-weight: 300;
        line-height: 25px;
    }

    .bb_first_table .logo img {
        width: 180px;
        margin-left: 25px;
    }

    .bb_first_table tr:first-child td:first-child {
        width: 300px;
    }
    .bb_first_table h2 {
        color: #fff;
        text-align: center;
        font-size: 25px;
        width: 540px;
        margin-left: auto;
        margin-right: auto;
        height: 577.49px;
    }

    .bb_first_table h3 {
        font-family: "Zeyada", cursive;
        color: #fff;
        text-align: center;
        font-size: 25px;
    }

    .bb_first_table h4 {
        color: #fff;
        text-align: center;
        font-size: 35px;
        font-weight: 500;
        margin-top: 20px;
    }
    .bb_first_table h5 {
        text-align: center;
        color: #fff;
        margin-bottom: 10px;

    }

    img {
        max-width: 100%;
        height: auto;
    }

    .bb-second-logo {
        margin-left: auto;
        margin-right: auto;
        width: 350px;
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: center;
        font-size: 30px;
        color: #fff;
        font-weight: 900;
    }

    .bb-first-table-line {
        width: 500px;
        height: 2px;
        background: #fff;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 10px;
    }

    .bb_first_table_label2 {
        margin-bottom: 100px;
        margin-top: 20px;
        width: 100%;
    }

    .bb_first_table_label2 p {
        text-align: center;
    }

    .bb-fourth-table h2,
    .bb_second_table-td-one h2 {
        text-align: center;
        font-size: 50px;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    .bb-full-width {
        width: 100%;
        padding: 10px;
    }

    .bb-fourth-table h2 {
        font-size: 40px;
        font-weight: 500;
    }

    .bb_first_table h5 {
        font-size: 18px;
    }

    .bb_first_table_last {
        padding-top: 30px;
    }

    .bb_first_table_last .logo {
        width: max-content;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 100px;
    }

    .bb_first_table_last .bb-second-logo {
        width: 150px;
        margin-left: auto;
        margin-right: auto;
    }

    .bb_first_table_label2-last {
        margin-bottom: 0;
    }

    .bb-curated {
        text-align: center;
        color: #fff;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .bb-curated span {
        color: red;
    }
    .bb-pt-20{
        font-size: 15px;
    }
    .bb-mt-20{
        margin-top: 20px;
    }
    .bb-mb-20{
        margin-bottom: 20px;
    }

    .bb_new_contact_table-add {
        width: 100%;
        box-sizing: border-box;
    }
    .bb_new_contact_table-add td {
        width: 30%;
    }

    .bb_new_contact_table-add .td-last {
        width: 40%;
    }

    .bb_new_contact_table-add .td-last .bb_new_table_border {
        border-right: 0px solid transparent;
    }

    .bb_new_contact_table-add .bb_new_table_border {
        padding-left: 10px;
        padding-right: 10px;
        border-right: 1px solid #fff;
    }

    .bb_new_contact_table-add .bb_new_table_border i,
    .bb_new_contact_table-add .bb_new_table_border span,
    .bb_new_contact_table-add .bb_new_table_border strong {
        color: #fff;
    }
    .bb_new_contact_table-add .bb_new_table_border strong {
        font-size: 16px;
    }

    .bb_new_contact_table-add .bb_new_table_border span {
        font-size: 12px;
    }
    .bb_new_contact_table-add .bb_new_table_border img {
        width: 16px;
        margin-right: 5px;
    }

    .date_quote_parent {
        float: right;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .bb_second_table .date_quote_parent p {
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        margin-bottom: 0;
    }

    .clear {
        clear: both;
    }

    .left__phone_parent {
        padding-left: 30px;
        float: left;
        padding-bottom: 30px;
    }

    .left_border {
        margin-left: 10px;
        padding-left: 10px;
        border-left: 1px solid #fff;
    }
    .right__gmail_parent span,
    .left__phone_parent span {
        color: #fff;
    }

    .bb-icon-bg-parent {
        width: 25px;
        height: 25px;
        background: #fff;
        border-radius: 50%;
        display: inline-block;
        position: relative;
        margin-right: 5px;
        top: 7px;
    }
    .bb-icon-bg-parent img {
        width: 15px;
        height: 15px;
        margin: auto;
        position: absolute;
        left: 50%;
        top:50%;
        transform: translate(-50%, -50%);
    }

    .right__gmail_parent {
        padding-bottom: 30px;
        padding-right: 30px;
        float: right;
    }
    .bb-bold{
        font-weight: 900;
    }
    .bb-heading{
        border: unset !important;
        padding: unset !important;
    }

    .bb-text-left {
        background-color: #00496f;
        color: #fff;
        padding: 10px;
        margin-top: 30px;
    }
    .bb-heading-first-row{
        border-top: none !important;
        border-bottom: 2px dotted #000 !important;
    }
    .bb-d-block{
        display:block;
    }
    .bb-m-auto{
        margin: 0 auto;
    }
    .bb-text-danger{
        color: red;
    }
    .bb-text-danger__border{
        color: red;
        border-right: 2px dotted red;
        border-bottom: 2px dotted red;
        padding-right: 5px;
        display:inline-block;
    }
    .bb-fourth-table .bb-heading{
        padding: 8px;
    }
    .bb-text-white{
        color: #fff;
    }
    .bb-important-list{
        margin-left: 20px;
    }
    .bb-important-list li{
        list-style-type: disc;
        line-height: 24px;
        font-size: 12px;
    }
    .bb_first_table_last{
        background-position: right;
    }

    .bb_second_table .border_bottom_unset {
        border-bottom: none;
    }

    .bb_second_table .bb_table__footer td {
        border-bottom: unset !important;
        border-left: unset !important;
        border-right: unset !important;
    }

    .bb__footer_width {
        width: 25%;
        float: left;
    }

    .bb_margin_top {
        background: #00496F;
        overflow: hidden;
        padding:15px 10px;
    }

    .bb_third_table_unset_border tr td {
        border: unset !important;
        vertical-align: top;
    }

    .bb__footer_width_last {
        float: left;
        width: 50%;
        border-right: unset !important;
    }

    .bb_table__footer td {
        padding: unset !important;
    }

    .bb__icon__content img {
        width: 14px;
        float:left;
        margin-right: 5px;
        position:relative;
        top: 1.6px;
    }
    .bb__icon__content p {
        float:left;
        font-size: 14px;
    }

    .bb_new_table_border strong,
    .bb_new_table_border span {
        color: #fff;
        font-size: 14px;
    }

    .bb_new_table_border img {
        width: 15px;
    }

    .bb_new_table_border {
        padding: 0 10px;
    }

    .bb__hotel__details__border .bb-heading-first-row {
        border: unset !important;
    }

    .bb__hotel__details__border .bb-heading-first-row {
        border-bottom: 2px dotted #000 !important;
    }

    .bb-curated i {
        color: red;
    }

    .bb-pt-20,
    .bbb__margin__top__inc {
        font-size: 15px;
        position: relative;
        bottom: -12px;
    }

    .bb-Skyline-tours-travel {
        color:#fff;
        text-align: center;
    }

    .bb-last-table-content-position {
        position:relative;
        top: 500px;
    }
    .bb-primary-color{
        color: #00496f !important;
    }

    .fixed-footer { position: fixed; bottom: 0px; left: 0px; right: 0px; background-color: lightblue;}
    .bb-page-break { page-break-after: always; }
    .bb-page-break:last-child { page-break-after: never; }
    .divider-gap-6{padding-left:6px;padding-right:10px;}
    .divider-gap-10{padding-left:45px;padding-right:10px;}
    .divider-gap-15{padding-left:15px;padding-right:10px;}
    .divider-gap-23{padding-left:23px;padding-right:10px;}
    .divider-gap-20{padding-left:20px;padding-right:10px;}
    .divider-gap-21{padding-left:21px;padding-right:10px;}
    .divider-gap-22{padding-left:22px;padding-right:10px;}
    .divider-gap-25{padding-left:25px;padding-right:10px;}
    .divider-gap-30{padding-left:30px;padding-right:10px;}
    .divider-gap-32{padding-left:32px;padding-right:10px;}
    .divider-gap-29{padding-left:29px;padding-right:10px;}
    .divider-gap-33{padding-left:33px;padding-right:10px;}
    .divider-gap-35{padding-left:35px;padding-right:10px;}
    .divider-gap-37{padding-left:37px;padding-right:10px;}
    .divider-gap-40{padding-left:40px;padding-right:10px;}
    .divider-gap-45{padding-left:45px;padding-right:10px;}
    .divider-gap-50{padding-left:50px;padding-right:10px;}
    .divider-gap-67{padding-left:67px;padding-right:10px;}
    body {
        background-image: url(' . $skyline_icon_img . ');
        background-repeat: no-repeat;
        background-position: center center;
        background-size: contain;
        padding-top: 60px;
    }
    .skyline-header-img {
        max-width: 100%;
        height: auto;
        width: 100%;
        position: absolute;
        top: 0;
    }
    .bb-package-table {
        width: 88%;
        margin: 0 auto;
    }

    // .bb-package-table p {
    //     float: left;
    //     width: 350px;
    //     word-wrap: break-word; /* Add this line */
    // }

    // .bb-package-table td::after {
    //     content: "";
    //     clear: both;
    // }

    </style>
</head>

<body>
    <img class="skyline-header-img" src="' . $skyline_header_icon_img . '" alt="">
    <div class="bb-all-table-main-parent">
            <table style="text-align: justify;padding: 0 50px;padding-top: 173px;">
                <tr>
                    <td colspan="6">
                        <div class="date_quote_parent">
                        <p>Quote No: <span>SKY' . $itinerary_id . '</span></p>
                        <p>Date: <span>' . $travel_date_day_month_year . '</span></p>
                        </div>
                        <div class="clear"></div>
                        <p>Dear ' . $customer_name . ',</p>
                        <p style="font-weight: bold;font-size: 16px;">Greetings from Skyline Tours n Travels! We hope you are well.</p>
                        <p>Thank you for choosing to work with us. Skyline Tours n Travels has been helping our customers craft
                        memorable travel experiences for years, and hope that you will find your upcoming holiday to be
                        nothing short of amazing!</p>
                    </td>
                </tr>
            </table>
            <table class="bb-package-table">
                <tr>
                    <td class="bb-heading " colspan="12">
                        <h4 style="margin-top: 0;" class="bb-text-left bb-mb-20">Package : <span style="font-weight: bold;font-size: 17px;">' . $package_name . '</span></h4>
                    </td>
                    <td></td>
                </tr>
                <tr>
                     <td style="width:55%">
                        <span>
                            <strong>Name:</strong>
                            ' . $customer_prefix . ' ' . $customer_name . '
                        </span>
                    </td>

                    <td colspan=5">

                        ' . $customer_mobile_phone_html . '
                    </td>
                </tr>
               <tr>
                    <td style="width:55%">
                        ' . $customer_email_html . '
                    </td>
                    <td style="width:45%">

                        <span>
                            <strong>No. of Pax:</strong>
                            ' . $package_no_adults . '
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width:55%">
                        <span>
                            <strong>Travel Date:</strong>
                            ' . date("d/m/Y", strtotime($package_travel_date)) . '
                        </span>
                    </td>
                    <td style="width:45%">

                        <span>
                            <strong>Executed From:</strong>
                            ' . $package_executed_from . '
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>
                            <strong>Package Cost:</strong>
                            ' . $package_currency . ' ' . $package_cost . '
                        </span>
                    </td>
                    <td><td>
                </tr>
        </table>
                 ' . $hotel_details_para . '
                        <h4 class="bb-text-left" style="margin-left: 50px;margin-right: 50px;">Highlights</h4>
                    <div style="padding-left: 50px;">
                    ' . $tour_inclusions_html . $country_exclusive_addon_html . $city_transfer_html . $travel_inclusions_html . $tour_exclusions_html . '
                    </div>
                    <div class="bb-mt-20" style="padding-left: 50px;">
                            <h4 class="bb-mt-20 bb-text-danger"><strong> Terms & Conditions -</strong></h4>
                            <ul class="bb-d-block bb-important-list bb-mt-20">
                                <li>Early check-in or late check-out from hotels (unless explicitly mentioned as an inclusion) </li>
                                <li>Optional enhancements like room or fight upgrades, or local camera or video fees </li>
                                <li>Any international and/or domestic Fights (Unless Explicitly Mentioned as an Inclusion) </li>
                                <li>Breakfast, lunches, dinners and drinks (alcoholic and non-alcoholic) (Unless Explicitly Mentioned as an Inclusion) </li>
                                <li>Additional sightseeing, activities and experiences outside of the itinerary </li>
                                <li>Passport fees, immunization costs, city taxes at the hotel and local departure taxes (wherever applicable) </li>
                                <li>Vehicals are Not on a Disposal Basis. </li>
                                <li>All Transfers and sightseeing on would be (point to a point basis). </li>
                                <li>Above is the Quote only and not Holding any Rooms/Reservation for the same. Fairs are Dynamic in nature And Can be Change Anytime. </li>
                                <li>Package Cost is on Current ROE Basis. If any Changes in ROE will affect the Current Cost. </li>
                                <li>Package Cost is time bound and can be Recheck at the time of Confirming </li>
                                <li>Excess Baggage charges, and where applicable, Baggage not included in your fare </li>
                                <li>Tips for Services and Experiences. </li>
                                <li>Any Gratuities Charges (Unless Explicitly Mentioned as an Inclusion) Port Charges (Unless Explicitly Mentioned as an Inclusion) </li>
                                <li>Any Visa Required. (Unless Explicitly Mentioned as an Inclusion) </li>
                                <li>Read useful information and terms for more on what is Included and Excluded We Reserve the Right to Cancel any Tour or Activites in case </li>
                                <li>we believe that we are unable to fulfil the services for any technical reasons or due to Flood,War,Strikes,Natural Calamities or any Unforeseen Circumstances </li>
                                <li>For Queries Regarding Cancellations and Refunds, please refer to our Cancellation Policy</li>
                                <li>Visa Charges. UAE Tourism Dirham Fee. Ok to Board Charges Not Included (Unless Explicitly Mentioned as an Inclusion)</li>
                                <li>For detailed terms and conditions visit www.skylinetnt.com</li>
                            </ul>

                            <p class="bb-mt-20 bb-text-center"><strong>If you would like to make changes or wants to customize more Contact Us!</strong></p>
                        </div>

    </div>
</body>

</html>

';
// echo $htmldata;
// exit();
$dompdf->loadHtml($htmldata);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('Skyline Itinerary - SKY' . $itinerary_id . '.pdf');
