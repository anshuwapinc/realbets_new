<html>
<head>
    <base href="<?php echo base_url() ?>static/etickets/"/>
    <title></title>
    <style>
        @page {
            margin: 15px;
        }

        html {
            margin: 15px
        }

        @font-face {
            font-family: "Open Sans";
            src: url("../fonts/Open-Sans/OpenSans-Regular-webfont.eot");
            src: url("../fonts/Open-Sans/OpenSans-Regular-webfont.eot?#iefix") format("embedded-opentype"),
            url("../fonts/Open-Sans/OpenSans-Regular-webfont.woff") format("woff"),
            url("../fonts/Open-Sans/OpenSans-Regular-webfont.ttf") format("truetype"),
            url("../fonts/Open-Sans/OpenSans-Regular-webfont.svg#open_sansregular") format("svg");
            font-weight: normal;
            font-style: normal;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .wrap {
            width: 730px;
            margin: 0 auto;
        }

        table {
            font-family: helvetica, Arial, "Open Sans";
            font-size: 14px;
        }

        table.main {
            border-collapse: collapse;
        }

        table.main > tbody > tr > td, table.main > tfoot > tr > td {
            padding: 3px 0px;
        }

        table.info td {
            padding: 1px 0;
        }

        .right-align {
            text-align: right;
        }

        .center-align {
            text-align: center;
        }

        .footnote {
            color: #999;
        }

        .bold {
            font-weight: bold;
        }

        p {
            line-height: 1.1;
        }

        ol {
            padding: 0 20px !important;
        }

        ol li {
            padding: 0 !important;
            line-height: 1.1;
        }

        .text-note {
            color: #0078ae;
        }

        .text-note-danger {
            color: #0078ae;
        }

        .top-border {
            border-top: 1px solid red;
        }

        .underlined_text {
            border-bottom: 1px solid #0078ae;
        }
        #image {
            width:100%;
            height:100%;
        }
    </style>
</head>
<body>
<div class="wrap">
    <table width="100%" class="main"
           cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td class="center-align">
                <img src="images/letter-head-mod.jpg"
                     width="730"/>
            </td>
        </tr>
        </thead>

        <tbody class="bold">
        <tr>
            <td><p>Warm, sunny greetings from
                    Jamaica,</p></td>
        </tr>
        <tr>
            <td>

                We are delighted you have chosen
                Jamaica’s premier airport lounges
                and concierge
                services at Club Kingston<br/>

            </td>
        </tr>

        <tr>
            <td>
                <p>
                    Thank you for providing us
                    with your flight details not
                    provided in our database
                    options. We require specific
                    travel details for flights
                    arriving and departing
                    Jamaica so that our team can
                    provide you with a delightful
                    arrival and departure
                    into and out of Jamaica. Our
                    team will validate the
                    information you have provided,
                    and within 24 hours of
                    verification of its accuracy,
                    you will receive confirmation
                    of your reservation.<br/>
                </p>


                <p>In the event of any changes to
                    your travel itinerary, we will
                    be happy to reschedule
                    based on availability. We ask
                    that you contact our Customer
                    Service representative
                    at <?php echo get_white_label_config('phone', 'usa') ?> or
                    <?php echo get_white_label_config('email', 'customercare') ?>
                    within 48 hours of your
                    travel.
                    You can also reach us via
                    Skype at <?php echo get_white_label_config('phone', 'skype') ?>.<br/>
                </p>

                <p>
                    Thank you for choosing VIP
                    Services, and we look forward
                    to serving you.<br/>
                </p>

                <p>
                    Warm Regards,<br/>
                </p>

                <div style="display: inline-block">
                    <p>
                        Shelly-Ann Fung-King
                    </p>
                    <div style="display: block;">
                        <img src="<?php echo base_url('static/images/shelly-signature.png') ?>"/>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>

        <tfoot>
        <tr>
            <td style="padding:350px 0 0 0">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                <small>
                    * Please note:
                    <span class="footnote">
                                    The responsibility for the retrieval and presentation of luggage to Customs resides with the passenger.  Passengers are required to comply with the Jamaica Civil Aviation Authority Regulations concerning their luggage and its contents.
                                </span>
                </small>
            </td>
        </tr>

        <tr>
            <td>
                <table width="100%"
                       class="top-border">
                    <tr>
                        <td width="25%"><img
                                    src="images/club-kingston-mod.png"
                                    width="120"
                                    alt="Club Kingston"/>
                        </td>
                        <td width="50%"
                            class="center-align">
                            Directors: David Hall,
                            Carlos Moleon
                        </td>
                        <td width="25%"
                            class="right-align">
                            <img src="images/club-mobay-mod.png"
                                 width="120"
                                 alt="Club Mobay"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </tfoot>

        <!--                <tfoot>
							<tr>
								<td>
									<small>
										<span class="footnote">
											Shelly-Ann Fung-King | Director of International Sales
											<br/>
										</span>
									</small>
									<small>
										<span class="footnote">
											VIP Attractions - Club Mobay & Club Kingston
											<br/>
										</span>
									</small>
									<small>
										<span class="footnote">
											m: (876) 564-1537 | e: shellyann.fung@vipattractions.com| w: www.vipattractions.com
										</span>
									</small>
								</td>
							</tr>
		
							<tr>
								<td>
									<table width="100%">
										<tr>
											<td><img src="images/manual_flight_letter.jpg" width="730" alt="Club Kingston" /></td>
										</tr>
									</table>
								</td>
							</tr>
						</tfoot>-->
    </table>
</div>
</body>
</html>