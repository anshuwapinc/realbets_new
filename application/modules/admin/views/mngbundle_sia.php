<?php
$totalPerson = $data['adulttickets'] + $data['childtickets'] + $data['infanttickets'];
$bookingkey = $data['bookingkey'];
$referencenumber = $data['referencenumber'];
$greetingMessage = $totalPerson == 1 ? $data['passengername'][0]['firstname'] . ' ' . $data['passengername'][0]['lastname'] : $data['passengername'][0]['firstname'] . ' ' . $data['passengername'][0]['lastname'] . ' & Guests';
if ($data['productname'] == PRODUCT_ARRIVAL) {
    $ticketno = $data['mngid'];
} else if ($data['productname'] == PRODUCT_DEPARTURE) {
    $ticketno = $data['confirmationnumber'];
} else if ($data['productname'] == PRODUCT_BUNDLE) {
    $ticketno = $data['mngid'];
}
if (empty($output_html_for_email)) {
    $width = 575;
} else {
    $width = 1000;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>VIP Attractions</title>
    <style>
        @page {
            margin: 5px 10px;
        }

        html {
            margin: 5px 10px
        }

        body {
            margin: 0;
            padding: 0;

        }

        .footnote span {
            color: #000000;
        }

        .footnote {
            color: #999;
        }

        .footnote {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <table bgcolor="#fcfcfc" align="center" width="<?php echo $width; ?>" cellspacing="0" cellpadding="0" border="0" style=" font-family: Arial, sans-serif; float:none; border:#F5F5F5 1px solid;">
        <thead>
            <tr>
                <td style="text-align: center;">
                    <img src="<?php echo base_url() ?>static/etickets/images/banner.jpg" width="100%" style="height:160px;" />
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="font-weight:bold; padding:10px 20px 10px 10px;">
                    Dear <?php echo $greetingMessage ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold; font-size:12px; padding:0px 20px 5px 20px;">
                    <u><span style="background:#FF3;"> Please take a moment to confirm the accuracy of the details provided below:</span></u>
                </td>
            </tr>
            <tr>
                <td>
                    <table frame="border" style="font-size:12px; font-family: Arial, sans-serif; border:none; width:100%; background:#FFF; padding:10px;" align="center" width="100%">
                        <?php
                        if ($referencenumber != "") {
                        ?>
                            <tr>
                                <td colspan="3" style="font-weight:bold; font-size:12px; padding:5px 0px 0px 20px;">
                                    Booking/Reference #:&nbsp;<span style="color:#F00;">
                                        <?php echo $referencenumber ?></span>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td width="25%" style="padding:5px 0px 0px 20px;" colspan="3">
                                <b><span>Confirmation #:</span>
                                    <font style="color: red;"><?php echo $data['mngid']; ?></font>
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; font-size:12px; padding:5px 0px 0px 20px;">
                                Arrival ID:&nbsp;<span style="color:#F00;"><?php echo $data['arrivalid']; ?></span>
                            </td>
                            <td nowrap="nowrap" style="font-weight:bold; font-size:12px; padding:5px 0px 0px 10px;">
                                Service Booked:&nbsp;<span style="color:#F00;"> Club Mobay Arrival Bundle Service </span>
                            </td>
                            <td style="font-weight:bold; font-size:12px; padding:5px 5px 0px 10px;">
                                No. of Persons:&nbsp;<span style="color:#F00;"><?php echo $totalPerson; ?></span>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold; font-size:12px; padding:5px 0px 0px 20px;">
                                Arrival Date :&nbsp;<span style="color:#F00;"><?php echo strtoupper(date('d-M-Y', strtotime($data['date']))) ?></span>
                            </td>
                            <td style="font-weight:bold; font-size:12px; padding:5px 0px 0px 10px;">
                                Arrival Flight
                                :&nbsp;<span style="color:#F00;"><?php echo $data['airline'] . " - " . $data['flightnumber'] ?></span>
                            </td>
                            <td style="font-weight:bold; font-size:12px; padding:5px 5px 0px 10px;">
                                Time of Arrival
                                :&nbsp;<span style="color:#F00;"><?php echo $data['time']; ?></span>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold; font-size:12px; padding:5px 0px 0px 20px;">
                                Departure Date
                                :&nbsp;<span style="color:#F00;"><?php echo strtoupper(date('d-M-Y', strtotime($data['returndate']))) ?></span>
                            </td>
                            <td style="font-weight:bold; font-size:12px; padding:5px 0px 0px 10px;">
                                Departure Flight
                                :&nbsp;<span style="color:#F00;"><?php echo $data['returnairline'] . " - " . $data['returnflightnumber'] ?></span>
                            </td>
                            <td style="font-weight:bold; font-size:12px; padding:5px 5px 0px 10px;">
                                Time of Departure
                                :&nbsp;<span style="color:#F00;"><?php echo $data['returntime']; ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold; font-size:12px; padding:5px 0px 0px 20px;">
                    <u>Please follow the steps below to
                        ensure an expedited and smooth
                        arrival process:</u>
                </td>
            </tr>
            <tr>
                <td style="font-weight:300; font-size:12px; padding:5px 20px 5px 5px;">
                    <ol type="1">
                        <li>
                            Upon disembarking the plane,
                            please descend to the bottom
                            of the ramp where you will be
                            greeted by your Club Mobay
                            Representative holding a
                            personalized sign.
                        </li>
                        <li style="margin-top:8px">
                            Please identify yourself to
                            your Club Mobay Representative
                            who will ensure that your
                            Immigration/Customs forms have
                            been accurately completed.
                        </li>
                        <li style="margin-top:8px">
                            You will then be escorted to
                            the VIP Immigration fast track
                            line, where your arrival
                            documents will be processed by
                            the authorities. Your
                            Representative will always be
                            within close vicinity to
                            assist with any queries.
                        </li>
                        <li style="margin-top:8px">
                            Once through Immigration, your
                            Club Mobay Representative will
                            escort you to the Baggage Hall
                            where they will assist with
                            your baggage claim.
                        </li>
                        <li style="margin-top:8px">
                            You will then proceed along
                            with your Representative to
                            the VIP Fast Track line in the
                            Customs hall.
                        </li>
                        <li style="margin-top:8px">
                            Once you have cleared Customs,
                            you will be escorted to the
                            Club Mobay Arrivals lounge
                            where you will be greeted with
                            a cold towel and refreshments.
                        </li>
                        <li style="margin-top:8px">
                            If your hotel offers an
                            arrivals lounge, our
                            Representative will escort you
                            there to await transportation
                            to your destination.
                        </li>
                        <li style="margin-top:8px">
                            If you are being hosted by our
                            Club Mobay Lounge, our
                            Representative will guide you
                            to your ground transportation.
                        </li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="font-weight:300; font-size:12px; padding:10px 10px 10px 30px;">
                    As part of your bundled service, your representative will present you with documentation and detailed instructions for accessing our Club MoBay Departure lounge. Please secure this documentation as it may be required for entry into the Lounge.
                </td>
            </tr>
            <tr>
                    <td style="font-weight:300; font-size:12px; padding:10px 10px 10px 30px;">As Jamaica moves to become more environmentally friendly, our landing process is now paperless so you can easily complete your immigration and customs forms online to facilitate your entry into the island. Just go to <a href="https://c5online.pica.gov.jm/apply/">https://c5online.pica.gov.jm/apply/</a> or <a href="https://c5online.pica.gov.jm/apply/">click here</a> at any time before you travel to access the forms online.</td>
                </tr>
            <!-- <tr>
                <td style="font-size:12px;font-weight: 600;padding:10px 10px 10px 30px"><span style="background:#FF3;">
                    For direct access to making Club MoBay/Club Kingston reservations for your next travel, simply use your internet enabled smart device to
                        scan our QR code below to download our booking app.</span>
                </td>
            </tr> -->
            <tr>
                <td align="center">
                    <h3 style="margin:0px;"><u>IMPORTANT</u>
                    </h3>
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold; font-size:12px; padding:0px 30px 0px 20px; margin-left: 30px">
                    <ul style="list-style-type:disc">
                        <!-- <li style="margin-top:3px">
                                For refunds and cancellations terms and conditions apply, please see website for further details.
                            </li> -->
                        <li style="margin-top:8px">Please
                            print this confirmation letter
                            and present to your Club Mobay
                            Representative upon arrival.
                        </li>

                        <li style="margin-top:8px">VIP ATTRACTIONS - CLUB MOBAY RESERVES THE RIGHT TO DENY ENTRY TO CLIENTS WHO FAIL TO PROVIDE PROPER PROOF OF PURCHASE UPON CHECK-IN.</li>

                        <li style="margin-top:8px">Kindly
                            note it is the responsibility
                            of our valued customers to
                            inform lounge
                            of any changes or flight
                            updates made to the original
                            itinerary. Should you have any
                            update/changes/queries please
                            <!--                    <a href="mailto:<?php echo get_white_label_config('email', 'support') ?>?subject=Urgent%20Flight%20Change"
                                                       style="color:#F00">-->
                            <a href="<?php echo base_url(); ?>update_booking/<?php echo $bookingkey; ?>" target="_blank" style="color:#F00">click here</a> or contact via:
                            <ul style="list-style-type:disc">
                                <li style="margin-top:8px">
                                    Email: <span style="color:#F00"><?php echo get_white_label_config('email', 'support') ?></span>
                                    with the subject noted
                                    <span style="color:#F00">Urgent Flight Change</span>.
                                </li>
                                <li>Phone: <span style="color:#F00">1 876 619-1565</span>
                                    for Jamaica or <span style="color:#F00">(954) 837-6290</span>
                                    for USA/Canada.
                                </li>
                            </ul>
                        </li>
                        <li style="margin-top:8px">Please
                            be advised that Ground
                            Transportation is not provided
                            by Club Mobay.
                        </li>
                    </ul>
                    <p style="font-size:12px;margin-left:40px;font-weight: 600;"><span style="background:#FF3;">For direct access to making Club MoBay/Club Kingston reservations for your next travel, simply use your internet enabled smart device to
                    scan our QR code below to download our booking app.</span></p>
                    <table style="width: 100%; margin:0 auto;">

                        <tr>
                            <td width="24.5%" style="padding-top: 20px!important; font-size:12px;">

                                <b>Yours
                                    Sincerely,</b><br />
                                <img src="<?php echo base_url(); ?>static/images/shelly-signature.png" />
                                <br />
                                <b>Shelly-Ann Fung-King</b><br />
                                Chief Executive
                                Officer<br />
                            </td>
                            <td width="20%" style="padding-top: 25px!important; font-size:12px;" align="right">
                                    <img src="<?php echo base_url(); ?>static/etickets/images/qrcode-new.png"   style="height:110px;" usemap="#image-map"/> 
                               

    <map name="image-map">
    <area target="_blank" alt="Play Store" title="Play Store" href="https://play.google.com/store/"
        coords="77,90,9,27" shape="rect">
    <area target="_blank" alt="Apple Store" title="Apple Store" href="https://www.apple.com/app-store/"
        coords="112,19,187,95" shape="rect">
</map>
                            </td>
                           
                            <td width="10%"><?php echo get_barcode($data["barcode_value"]); ?></td>
                         
                         
                            <td width="10%" style="padding-top:26px;">
                                <a href="http://www.jamaicaexperiences.com" target="_blank">
                                    <div style='width:110px;'>
                                        <img src="<?php echo base_url(); ?>static/images/jelogo2.png"  s width="110" />
                                    </div>
                                </a>
                            </td>

                         
                            <!-- <td width="10%">

                                <a href="http://www.jamaicaexperiences.com/blogs/details/article/jamaica-experiences-in-prints" target="_blank">
                                    <img src="<?php echo base_url(); ?>static/images/jepromo.png"   width="110" /></a>
                            </td>
                            <td width="10%">

                                <a href="http://www.stayconnected.com/" target="_blank">
                                    <img src="<?php echo base_url(); ?>static/images/stayconnectedlogo.png"  width="110"  /></a>

                            </td> -->
                        </tr>
                    </table>
                </td>
            </tr>


            <!--    <tr>
        
        <td colspan="2" valign="top"
            style="font-weight:bold;font-size:12px;font-family:Arial;padding:0px 0px 5px 20px">
            Yours Sincerely
        </td>
    </tr>
    <tr>
                <td valign="bottom"> 
                    <table width="100%">
                        <tr>
                            <td width="150" valign="bottom">
                                <table width="100%">
                                    <tr>
                                        <td valign="bottom"><img
                                            src="<?php echo base_url(); ?>static/etickets/images/shelly-signature.png"
                                            width="111"/></td>
                                    </tr>
                                    <tr>
                                        <td valign="bottom"
                                            style="font-weight:bold;font-size:12px;font-family:Arial;padding:0px 0px 5px 20px;">
                                            Shelly-Ann Fung-King
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="bottom"
                                            style="font-weight:300;font-size:12px;font-family:Arial;padding:0px 0px 5px 20px;">
                                            Chief Executive Officer
                                        </td>
                                    </tr>
                                </table>

                            </td>
                            <td valign="top" align="right">
                                <table width="100%" align="right">
                                    <tr>
                                        <td align="right" valign="bottom">
                                            <a href="http://www.jamaicaexperiences.com/" target="_blank">
                                        <img style="align:right" src="<?php echo base_url(); ?>static/images/jeqrcode.png"
                                             height="140" width="260"/></a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
    </tr>-->


            <tr>
                <td style="padding:5px 20px 0px 5px;">
                    <div class="footnote" style="padding:5px 20px 0px 5px;">
                        <small>
                            <span> * Please note: </span>
                            The responsibility for the
                            retrieval and presentation of
                            luggage to Customs resides
                            with the passenger. Passengers
                            are required to comply with
                            the Jamaica Civil Aviation
                            Authority Regulations
                            concerning their luggage and
                            its contents.
                        </small>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <table align="center" width="100%">
                        <tr>
                            <td colspan="3">
                                <hr size="1" noshade="noshade" style="border:1px solid #CC0000;" />
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:0px 0px 5px 10px" align="left">
                                <img src="<?php echo base_url() ?>static/etickets/images/clubmbj.jpg" width="100" />
                            </td>
                            <td style="font-weight:300;font-size:12px;padding:0px 0px 5px 20px">
                                <p align="center" style="font-size:12px;font-family:Arial">
                                    Directors: David Hall,
                                    Carlos Moleon</p>
                            </td>
                            <td align="right" style="padding:0px 10px 5px 0px">
                                <img src="<?php echo base_url() ?>static/etickets/images/clubkin.jpg" width="100" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

    </table>
</body>

</html>
