<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Realbets</title>


    <link rel="icon" href="<?php echo base_url(); ?>assets/login/logo.png">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/login/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>assets/login/all.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/login/css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>assets/login/style.css" rel="stylesheet">

    <style>
        .alert-danger,
        .alert-success {
            width: 78% !important;
            margin-left: 12% !important;
        }

        /* .verify {
            position: absolute;
         
            right: 41px;
        } */

        .strike {
            display: block;
            text-align: center;
            overflow: hidden;
            white-space: nowrap;
            margin-top: 15px;

            margin-bottom: 15px;
        }

        .strike>span {
            position: relative;
            display: inline-block;
        }

        .strike>span:before,
        .strike>span:after {
            content: "";
            position: absolute;
            top: 50%;
            width: 9999px;
            height: 1px;
            background: grey;
        }

        .strike>span:before {
            right: 100%;
            margin-right: 15px;
        }

        .strike>span:after {
            left: 100%;
            margin-left: 15px;
        }

        input:focus {
            border-left: 3px solid #ffb80c !important;
            border-bottom: 1px solid #1c1c1c !important;
        }
    </style>
    <script type="text/javascript">

    </script>

</head>

<body>
    <div class="login_container bg_login" style="background-image: url(<?php echo base_url(); ?>assets/login/background.jpg)">
        <div class="login_wrapper-bg">
            <div class="lazy-container-login" id="wrapper">
                <div class="rllogin-header"><img src="<?php echo base_url(); ?>assets/login/logo.png" alt="..."></div>
                <!-- class="theme-form login-form needs-validation was-validated" -->
                <form class="theme-form needs-validation was-validated" autocomplete="off" action="<?php echo current_url(); ?>" id="login-form" method="post">
                    <div id="login" class="form">
                        <?php

                        if (!empty($message)) {
                        ?>
                            <div class="alert alert-danger ">
                                <button type="button" class="close" onclick="document.querySelector('.alert').remove()" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $message; ?>
                            </div>
                        <?php
                        }

                        $errors = validation_errors();


                        if (!empty($errors)) {
                        ?>
                            <div class="alert alert-danger ">
                                <button type="button" class="close" onclick="document.querySelector('.alert').remove()" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $errors; ?>
                            </div>
                        <?php
                        } ?>
                        <div class="login_wrapper">

                            <div class="form-group">
                                <!-- <button onclick="getOtp()" class="btn btn-sm btn-success verify">Verify</button> -->
                                <input type="tel" maxlength="10" minlength="10" id="login_username" name="login_username" class="form-control user_input" placeholder="10 Digit Phone Number" required="1">

                            </div>

                           <!-- <div class="form-group" id="otpBox">
                                <div class="d-flex">
                                    <div style="width:68%">
                                        <label class="text-success" id="otp_status"></label>
                                    </div>
                                    <div style="width:32%">
                                        <span id="resend_text"><button type="button" onclick="getOtp()" class="btn btn-sm btn-success verify" id="send_otp_btn" style="float:right">Send OTP</button></span>
                                       <label class='text-info text-center' id="resend_text">resend in 30sec</label>
                                       <label class="text-success">Verified</label>  
                                    </div>
                                </div>
                               <label><span class="text-success">Otp send,Please verify!</span><span style="padding-left:44px">resend in 30sec</span></label>
                                <input type="tel" maxlength="5" minlength="5" name="otp" id="otp" placeholder="Enter 5 Digit OTP" class="form-control user_input" required="1">
                            </div> -->
                            <div class="form-group">
                                <input type="password" type="password" name="password" id="password" class="form-control pass_input" placeholder="Password" required="1" autocomplete="off">
                            </div>


                            <!-- <div class="form-group">
                                <input type="password" type="password" name="confirm_password" id="confirm_password" class="form-control pass_input" placeholder="Confirm Password" required="1" autocomplete="off">
                            </div> -->
                            <div class="form-group">
                                <input type="text" name="referral_code" id="referral_code" value="<?php echo !empty($_GET['refer']) ? $_GET['refer'] : "" ?>" placeholder="Referral code (Optional)" class="form-control user_input" style="background-image:unset !important">
                            </div>
                            <div class="checkboxs">
                                <label><input type="checkbox" name="remember" id="remember" checked=""> Remember me</label>
                                <span class="text-muted" style="padding-left:20px"><a href="<?php echo base_url('forgot-password') ?>">Forgot Password</a></span>
                                <!-- <a href="#" class="apk-btn"><img src="<?php echo base_url(); ?>assets/login/android_app_btn.png" alt="..."></a> -->
                            </div>

                        </div>

                        <div class="login_ftrmy">

                            <div class="button-groups">

                                <button type="submit" id="signup_submit" class="btn btn-success">Create New Account</button>


                                <!-- <a href="<?php echo base_url(); ?>sign-up" class="btn btn-success">Sign Up</a> -->
                            </div>
                            <div class="strike">
                                <span>or</span>
                            </div>
                            <div class="button-groups">
                                <a type="button" href="<?php echo base_url(); ?>" class="btn btn-success">Log In</a>
                            </div>
                            <!-- <div class="betfairlogo">
                                <img src="<?php echo base_url(); ?>assets/login/orbit-betfair.png" alt="...">
                            </div> -->
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="partner_logo">
        <img src="<?php echo base_url(); ?>assets/login/img-01.png" alt="...">
        <img src="<?php echo base_url(); ?>assets/login/img-02.png" alt="...">
        <img src="<?php echo base_url(); ?>assets/login/img-03.png" alt="...">
        <img src="<?php echo base_url(); ?>assets/login/img-04.png" alt="...">
        <img src="<?php echo base_url(); ?>assets/login/img-05.png" alt="...">
        <img src="<?php echo base_url(); ?>assets/login/img-06.png" alt="...">
        <img src="<?php echo base_url(); ?>assets/login/img-07.png" alt="...">
        <img src="<?php echo base_url(); ?>assets/login/img-08.png" alt="...">
    </div>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript" charset="UTF-8" src="<?php echo base_url(); ?>/assets/plugins/validation/jquery.validate.min.js?1638536882"></script>

    <script type="text/javascript">
        // document.onkeydown = function(e) {
        //   if(event.keyCode == 123) {
        //       return false;
        //   }
        //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
        //       return false;
        //   }
        //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
        //       return false;
        //   }
        //  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
        //       return false;
        //   }
        //   if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
        //       return false;
        //   }
        // }
        var resend_function;
        $(document).ready(function() {

            var base_url = '<?php echo base_url(); ?>';
            $("#login-form").validate({

                rules: {

                    login_username: {
                        required: true,
                        remote: {
                            url: base_url + "login/Admin/register_username_exists",
                            type: "post",
                            data: {
                                login: function() {
                                    return $("#login_username").val();

                                },
                            },
                            complete: function(data) {
                                console.log(data);
                                if (data.responseText == "true") {

                                    // $("#send_otp_btn").prop('disabled', 'true');
                                    // $("#login_username").removeAttr('style');
                                    // $("#otp_status").text('Otp send,Please verify!');
                                    // getOtp();
                                } else {
                                    // $("#login_username").css('background-image', 'unset');
                                    // $("#otp_status").text('');
                                    // $("#send_otp_btn").prop('disabled', 'false');
                                    // clearInterval(resend_function);
                                    // $("#resend_text").html('<button type="button" onclick="getOtp()" class="btn btn-sm btn-success verify" id="send_otp_btn" style="float:right">Send OTP</button>');
                                }
                            }
                        },
                    },
                    // otp: {
                    //     required: true,
                    //     remote: {
                    //         url: base_url + "login/Admin/checkOtp",
                    //         type: "post",
                    //         data: {
                    //             number: function() {
                    //                 return $("#login_username").val();
                    //             },
                    //             otp: function() {
                    //                 return $("#otp").val();
                    //             },
                    //         },
                    //         complete: function(data) {
                    //             console.log(data);
                    //             if (data.responseText == "true") {

                    //                 $("#otp").removeAttr('style');

                    //             } else {
                    //                 $("#otp").css('background-image', 'unset');
                    //             }
                    //         }
                    //     },
                    // },
                    //   registration_date: {
                    //     required: true,
                    //   },
                    password: {
                        required: true,

                        minlength: 4,
                    },
                    // confirm_password: {
                    //     required: true,
                    //     equalTo: "#password",
                    // },


                },
                messages: {
                    login_username: {
                        required: "Phone number is required",
                        remote: "This number is already taken.",
                    },
                    password: {
                        required: "Password is required",

                    },
                    // confirm_password: {
                    //     required: "Retype password is required",

                    //     equalTo: "Retype password not matched",
                    // },
                    // otp: {
                    //     required: "Otp did not matched",
                    //     remote: "Otp did not match",

                    // },

                },
                submitHandler: function(form) {                    
                    $("#signup_submit").prop('disabled', 'true');
                    form.submit();
                }
            });
        });


        $('#login_username').keyup(function(e) {
            if (e.keyCode == 8) {
                $("#otp_status").text('');
                clearInterval(resend_function);
                $("#resend_text").html('<button type="button" onclick="getOtp()" class="btn btn-sm btn-success verify" id="send_otp_btn" style="float:right">Send OTP</button>');
            }

        })

        $('#login_username').keyup(function() {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        });

        $('#otp').keyup(function() {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        });


        function getOtp() {
            console.log($("#login_username").val());
            if ($("#login_username").val() != "") {
                $.ajax({
                    url: "<?php echo base_url(); ?>login/Admin/register_username_exists",
                    data: {
                        login_username: $("#login_username").val(),
                    },
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    success: function(output) {
                        if (output == true) {

                            clearInterval(resend_function);

                            // alert("Otp Sent Please Fill down");
                            $("#otpBox").show();
                            $("#otp").focus();
                            resend_otp_timer_function();
                            var formData = {
                                number: $("#login_username").val()
                            }
                            $.ajax({
                                url: "<?php echo base_url(); ?>login/Admin/sendOtp",
                                data: formData,
                                type: 'POST',
                                dataType: 'json',
                                async: false,
                                success: function(output) {

                                }
                            });

                        } else {
                            alert("This Phone Number is Already Taken");
                        }
                    }

                });
            } else {

                alert("Please Enter Phone");
            }


        }

        function resend_otp_timer_function() {
            var sec_count = "30";

            resend_function = setInterval(function() {
                if (sec_count == "0") {
                    $("#resend_text").html('<button type="button" onclick="getOtp()" class="btn btn-sm btn-success verify" style="float:right">Resend OTP</button>');
                    clearInterval(resend_function);
                } else {
                    $("#resend_text").text('resend in ' + sec_count + 'sec');
                    sec_count--;
                }
            }, 1000);
        }
    </script>

</body>

</html>