$(document).ready(function() {
    $(document).on("click", "#user_com_update", function() {
        var Commission = $("#Commission").val();
        var SessionComm = $("#SessionComm").val();
        var OtherComm = $("#OtherComm").val();
        var mstrid = $("#mstrid").val();
        var HelperID = $("#HelperID").val();
        var i = 0;
        $(".form-control").removeClass("bordar_highlight");
        if (Commission == '') {
            $("#CommissionN").text('Please Enter Bet Delay');
            $("#Commission").addClass("bordar_highlight");
            i = 1;
        }
        if (SessionComm == '') {
            $("#SessionCommN").text('Please Enter Max Stack');
            $("#SessionComm").addClass("bordar_highlight");
            i = 1;
        }
        if (OtherComm == '') {
            $("#OtherCommN").text('Please Enter Going In Play Stack');
            $("#OtherComm").addClass("bordar_highlight");
            i = 1;
        }
        if (i == 0) {
            var datastring = $("#update_user_commission").serialize() + "&compute=" + Cookies.get('_compute');
            $.ajax({
                type: "post",
                url: site_url + 'Adminmaster/updateCommission/' + Commission + '/' + SessionComm + '/' + OtherComm + '/' + mstrid + '/' + HelperID,
                data: { 'compute': Cookies.get('_compute') },
                cache: false,
                success: function(output) {
                    //console.log(output);
                    output = $.parseJSON(output);
                    //alert(output.error);
                    if (output.error == 0) {
                        alert(output.message);
                        $("#InfoUserMsg").show();
                        $("#InfoUserMsg").html("<span class='succmsg'>" + output.message + "</span>");
                        $("#InfoUserMsg").fadeOut(5000);
                        //setTimeout(function(){ location.reload(); }, 5000);                     
                    } else {
                        $("#InfoUserMsg").show();
                        $("#InfoUserMsg").html("<span class='errmsg'>" + output.message + "</span>");
                        $("#InfoUserMsg").fadeOut(5000);
                    }
                }
            });
        }
        i++;
    });
    $(document).on("click", "#change_pass", function() {
        var oldPassword = $("#oldPassword").val();
        var newPassword = $("#newPassword").val();
        var confirm_password = $("#confirm_password").val();

        var userId = $("#userId").val();
        var HelperID = $("#HelperID").val();
        var SltUsrType_id = $("#SltUsrType_id").val();

        var i = 0;
        $(".form-control").removeClass("bordar_highlight");

        if (SltUsrType_id == 0) {
            if (oldPassword == '') {
                $("#oldPasswordN").text('Please Enter old Password');
                $("#oldPassword").addClass("bordar_highlight");
                i = 1;
            }
        }

        if (newPassword == '') {
            $("#newPasswordN").text('Please Enter New Password');
            $("#newPassword").addClass("bordar_highlight");
            i = 1;
        }

        if (confirm_password == '') {
            $("#confirm_passwordN").text('Please Enter confirm password');
            $("#confirm_password").addClass("bordar_highlight");
            i = 1;
        }

        if (i == 0) {
            var formData = $("#ChangePassword").serializeJSON();
            $.ajax({
                type: "post",
                url: site_url + 'submit-account-password',
                data: setFormData(formData),
                cache: false,
                success: function(output) {
                    output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                    if (output.error == 0) {
                        $("#PassUserMsg").show();
                        $("#PassUserMsg").html("<span class='succmsg'>" + output.message + "</span>");
                        $("#PassUserMsg").fadeOut(5000);
                        setTimeout(function() { $('#userModal').modal('hide'); }, 2000);
                        setTimeout(function() { location.reload(); }, 3000);
                    } else {
                        $("#PassUserMsg").show();
                        $("#PassUserMsg").html("<span class='errmsg'>" + output.message + "</span>");
                        $("#PassUserMsg").fadeOut(5000);
                    }
                }
            });
        }
        i++;


    });
});

function betNotifySett() {
    var bNVal = $("#betNotifyVal").val();
    var bNVal1 = (bNVal == '1' ? '0' : '1');
    $.ajax({
        type: "post",
        url: site_url + 'updateNotify',
        data: setFormData({ 'val': bNVal1 }),
        success: function success() {
            $("#betNotifyVal").val(bNVal1);
            betNotifyjs = bNVal1;
            if (bNVal1 == '1') {
                $(".betnotify").html('<i class="fa fa-bell fa-2x" aria-hidden="true"></i>');
            } else {
                $(".betnotify").html('<i class="fa fa-bell-slash fa-2x" aria-hidden="true"></i>');
            }

        }
    });
}

function save_msg() {
    bootbox.confirm("Are you sure?", function(result) {
        var setMessage = $.trim($('#setMessage').val());
        if (setMessage != '') {
            if (result == true) {
                var formData = { 'setMessage': setMessage };
                jQuery.ajax({
                    url: site_url + 'submit-message-setting',
                    data: setFormData(formData),
                    type: 'post',
                    dataType: 'json',
                    success: function(data) {
                        if (data.error == '0') {
                            new PNotify({
                                title: 'Success',
                                text: data.message,
                                type: 'success',
                                styling: 'bootstrap3',
                                delay: 3000
                            });
                        } else {
                            new PNotify({
                                title: '403 Error',
                                text: data.message,
                                type: 'error',
                                styling: 'bootstrap3',
                                delay: 3000
                            });
                        }
                        setTimeout(function() { location.reload(); }, 3000);
                    },
                    error: function(request) {
                        new PNotify({
                            title: 'Error',
                            text: data.message,
                            type: 'error',
                            styling: 'bootstrap3',
                            delay: 3000
                        });
                    },
                });
            }
        }
    });
}

function setAction() {
    var action = $("#useraction").val();
    var users = [];
    $.each($(".select-users:checked"), function() {
        users.push($(this).val());
    });
    if (action == '') {
        alert("Please select action");
    } else if (users.length == 0) {
        alert("Please select users");
    } else {
        let formData = { action: action, users: users };
        $.ajax({
            url: site_url + 'update-client-status',
            data: setFormData(formData),
            type: 'post',
            dataType: 'json',
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                new PNotify({
                    title: 'Success',
                    text: output.message,
                    type: 'success',
                    styling: 'bootstrap3',
                    delay: 3000
                });
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        });

    }
}

function addUser(user_id, type) {
    //alert("addUser",addUser);
    $.ajax({
        type: "GET",
        url: site_url + 'add-new-user/' + user_id + '/' + type,
        async: false,
        dataType: 'html',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            $("#userModal").html(output);
            $('#userModal').modal('show');
        }
    });
}

function partnership(id) {
    $.ajax({
        url: site_url + 'Adminmaster/getPartnerShip/' + id,
        type: 'get',
        dataType: 'html',
        success: function(output) {
            $("#userModal").html(output);
            $('#userModal').modal('show');
        }
    });
}

function perPageGetUserData(val) {
    $("#perpage").val(val);
    $("#userListForm button").click();
    $('#userListForm').submit();
}

function view_account(id) {
    let formData = { id: id };
    $.ajax({
        url: site_url + 'view-account',
        data: setFormData(formData),
        type: 'post',
        dataType: 'html',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            $('#userModal').modal('show');
            $("#userModal").show();
            $("#userModal").html(output);
        }
    });
}

function view_balance_info(id) {
    $.ajax({
        url: site_url + 'Adminmaster/view_balance/' + id,
        type: 'get',
        dataType: 'html',
        success: function(output) {
            $('#userModal').modal('show');
            $("#userModal").show();
            $("#userModal").html(output);
        }
    });
}

function view_change_passs(id) {
    var formData = { userId: id }
    $.ajax({
        url: site_url + 'change-account-password',
        data: setFormData(formData),
        type: 'POST',
        dataType: 'html',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            $('#userModal').modal('show');
            $("#userModal").show();
            $("#userModal").html(output);
        }
    });
}

function view_set_permission(id) {
    $.ajax({
        url: site_url + 'Adminmaster/set_user_permission/' + id,
        data: { id: id },
        type: 'get',
        dataType: 'html',
        success: function(output) {
            $('#userModal').modal('show');
            $("#userModal").show();
            $("#userModal").html(output);
        }
    });
}

function free_chips_in_out(id, action) {
    var formData = { id: id, action: action };
    $.ajax({
        url: site_url + 'view-chips-in-out',
        data: setFormData(formData),
        type: 'POST',
        dataType: 'html',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            $('#userModal').modal('show')
            $("#userModal").show();
            $("#userModal").html(output);
        }
    });
}


function filterByAjax(type, order) {
    $.ajax({
        url: site_url + 'Adminmaster/userList/4',
        data: { ajaxCall: true, filterType: type, order: order },
        type: 'post',
        dataType: 'json',
        success: function(output) {

        }
    });
}

function submit_user_setting(id) {
    i = 0;
    if (i == 0) {
        var datastring = $("#" + id).serializeJSON();
        $.ajax({
            type: "post",
            url: site_url + 'update-user-account-data',
            data: setFormData(datastring),
            cache: false,
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if (output.error == 0) {
                    $("#divLoading").show();
                    $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                    $("#divLoading").fadeOut(3000);
                    alert(output.message);
                } else {
                    alert(output.message);
                    $("#divLoading").show();
                    $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                    $("#divLoading").fadeOut(3000);
                }
            }
        });
    }
    i++;
}

function update_gen_setting() {
    var datastring = $("#update_user").serializeJSON() /*+ "&compute=" + Cookies.get('_compute')*/ ;
    $.ajax({
        type: "post",
        url: site_url + 'update-account',
        data: setFormData(datastring), //only input
        cache: false,
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            if (output.error == 0) {
                $("#divLoading").show();
                $("#divLoading").html("<span class='succmsg'>" + output.message + "</span>");
                $("#divLoading").fadeOut(3000);
                alert(output.message);
                //setTimeout(function(){ location.reload(); }, 3000);                     
            } else {
                alert(output.message);
                $("#divLoading").show();
                $("#divLoading").html("<span class='errmsg'>" + output.message + "</span>");
                $("#divLoading").fadeOut(3000);
            }

        }
    });

}

function updateUserSett() {

    var id = $("#updUserSerial").val();
    var formData = { UserID: id };
    $.ajax({
        url: site_url + 'open-closed-users',
        type: 'POST',
        data: setFormData(formData),
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            if (output.error == 0) {
                $("#user_row_" + id).remove();
            }
            alert(output.message);
            setTimeout(function() { location.reload(); }, 3000);
        }
    });
}

function Lock_unlock_user(id) {
    var msg = "Would you like to open user account";
    $("#updUserSerial").val(id);
    $("#lockunlockModal p").text(msg);
    $("#lockunlockModal").modal();
}
$(document).on("click", "#FilterData", function() {
    //$('#FilterData').click(function () {
    var searchTerm = $('#searchTerm').val();
    var userType = $('#userType').val();
    var userid = $('#userID').val();

    $.ajax({
        url: site_url + 'child-balance-sheet/' + userid + '/' + userType + '/' + searchTerm + '/',
        dataType: 'html',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            $("#chipData").html(output);
        }
    });
});

$(document).on("click", "#ClearFilterData", function() {
    //$('#ClearFilterData').click(function () {

    var userType = $('#userType').val();
    var userid = $('#userID').val();

    $.ajax({
        url: site_url + 'child-balance-sheet/' + userid + '/' + userType,
        dataType: 'html',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            $("#chipData").html(output);
        }
    });

});


function getuserchip(userid, usertype) {
    $.ajax({
        url: site_url + 'child-balance-sheet/' + userid + '/' + usertype,
        dataType: 'html',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            $("#chipData").html(output);
        }
    });
}



function submitClearChip(UserID, usetype, mstruserid, mstrname, Musum, parentID, CrDr, IsFree) {
    $('#settlementpopup #tital_change').text('User Name ' + mstrname + ' || ' + Musum);
    $('#settlementpopup #Chips').val(parseFloat(Musum));
    $('#settlementpopup #amountPre').val(parseFloat(Musum));
    $('#settlementpopup #UserID').val(UserID);
    $('#settlementpopup #CrDr').val(CrDr);
    $('#settlementpopup #IsFree').val(IsFree);
    $('#settlementpopup').modal('toggle');
}

function saveSettelment() {
    var amt = $('#settlementpopup #Chips').val();
    var Musum = parseFloat(amt);
    var Musum1 = parseFloat($('#settlementpopup #amountPre').val());
    var UserID = $('#settlementpopup  #UserID').val();
    var Narration = $('#settlementpopup  #Narration').val();
    var passwordSettle = $('#settlementpopup #passwordSettle').val();
    var CrDr = $('#settlementpopup #CrDr').val();
    var IsFree = $('#settlementpopup  #IsFree').val();
    if (isNaN(amt)) {
        $('#settlementpopup #Chips').val(Musum1);
        new PNotify({
            title: 'Error',
            text: "Invalid entry",
            type: 'error',
            styling: 'bootstrap3',
            delay: 3000
        });
    } else if (CrDr == 1 && Musum > Musum1) {
        $('#settlementpopup #Chips').val(Musum1);
        new PNotify({
            title: 'Error',
            text: "Amount cannot be greater than " + Musum1,
            type: 'error',
            styling: 'bootstrap3',
            delay: 3000
        });
    } else {
        $('#saveSettelment').attr('disabled', 'disabled');
        var formData = { UserID: UserID, CrDr: CrDr, Chips: Musum, IsFree: IsFree, Narration: Narration, HelperID: 0, passwordSettle: passwordSettle };
        $.ajax({
            url: site_url + 'balance-sheet-submit',
            data: setFormData(formData),
            type: "POST",
            dataType: "json",
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if (output.error == 0) {
                    jQuery("#user_row_" + UserID).remove();
                    new PNotify({
                        title: 'Success',
                        text: output.message,
                        type: 'success',
                        styling: 'bootstrap3',
                        delay: 2000
                    });
                    $('#settlementpopup').modal('toggle');
                    $("#saveSettelment").attr("disabled", false);
                } else {
                    new PNotify({
                        title: 'Error',
                        text: output.message,
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 2000
                    });
                    $("#saveSettelment").attr("disabled", false);
                }

                /*setTimeout(function () {
                	location.reload();
                }, 3000);*/
            }
        });
    }
}

$(document).on("change", "#left_username", function() {
    //$("#left_username").change(function () {
    let formData = { 'id': $('#left_username').val(), 'compute': Cookies.get('_compute') };
    $.ajax({
        type: "POST",
        url: site_url + 'check-username-exists',
        data: setFormData(formData),
        cache: false,
        dataType: 'json',
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            if (output.error == '1') {
                $("#left_usernameN").text(output.message).attr('style', 'color:red');
            } else {
                $("#left_usernameN").text(output.message).attr('style', 'color:green');
            }
        }
    });
});
$(document).on("click", "#child_player_add", function() {
    $("#addChildForm .form-group span").text('');
    $("#left_usernameN").css("color", "red");
    var username = $("#left_username").val();
    var master_name = $("#left_master_name").val();
    var password = $("#left_password").val();
    var userType = $("#LeftTypeId").val();
    var FromDate = $("#left_FromDate").val();
    var MaxProfit = $("#left_lgnUserMaxProfit").val();
    var fancy_max_profit = $("#left_fancy_max_profit").val();
    var intRegex = '/^\d+$/';
    if (userType == 4) {
        var partner = 0;
        var partnerCasino = 0;
        var partnerLiveTennPatti = 0;
        var partnerLiveGame = 0;
        var partnerBinary = 0;
    } else {
        var partner = parseFloat($("#left_partner").val());
        var partnerCasino = parseFloat($("#left_partnershipCasino").val());
        var partnerLiveTennPatti = parseFloat($("#left_partnershipLiveTennPatti").val());
        var partnerBinary = parseFloat($("#left_partnershipBinary").val());
    }

    var p_partner = parseFloat($("#parentpartner").val());
    var i = 0;
    $(".form-control").removeClass("bordar_highlight");
    if (master_name == '') {
        $("#left_master_nameN").text('Please Enter Name');
        $("#left_master_name").addClass("bordar_highlight");
        i = 1;
    } else if (master_name.length < 4) {
        $("#left_master_nameN").text('Name must be 4 characters');
        $("#left_master_name").addClass("bordar_highlight");
        i = 1;
    }
    if (username == '') {
        $("#left_usernameN").text('Please Enter username');
        $("#left_username").addClass("bordar_highlight");
        i = 1;
    } else if (username.length < 4) {
        $("#left_usernameN").text('Username must be 4 charecters');
        $("#left_username").addClass("bordar_highlight");
        i = 1;
    }
    if (password == '') {
        $("#left_passwordN").text('Password is required');
        $("#left_password").addClass("bordar_highlight");
        i = 1;
    } else if (password.length < 4 || password.length > 12) {
        $("#left_passwordN").text(' password must be between 4 and 12 character');
        $("#left_password").addClass("bordar_highlight");
        i = 1;
    }
    if (MaxProfit == '') {
        $("#left_lgnUserMaxProfitN").text('Specify Max Profit');
        $("#left_lgnUserMaxProfit").addClass("bordar_highlight");
        i = 1;
    } else if (isNaN(MaxProfit)) {
        $("#left_lgnUserMaxProfitN").text('Invalid Max Profit');
        $("#left_lgnUserMaxProfit").addClass("bordar_highlight");
        i = 1;
    }
    if (fancy_max_profit == '') {
        $("#left_fancy_max_profitN").text('Specify Fancy Max Profit');
        $("#left_fancy_max_profit").addClass("bordar_highlight");
        i = 1;
    } else if (isNaN(fancy_max_profit)) {
        $("#left_fancy_max_profitN").text('Invalid Fancy Max Profit');
        $("#left_fancy_max_profit").addClass("bordar_highlight");
        i = 1;
    }
    if (userType != 4) {
        if (partner === undefined) {
            $("#left_partnerN").text(' Partnership should not be Blank');
            $("#left_partnerN").addClass("bordar_highlight");
            i = 1;
        } else if (partner.length > 3) {
            $("#left_partnerN").text('Partnership should be less then 3 Character');
            $("#left_partnerN").addClass("bordar_highlight");
            i = 1;
        } else if (partner > p_partner) {
            $("#left_partnerN").text('Partnership cannot be greater than ' + p_partner);
            $("#left_partnerN").addClass("bordar_highlight");
            i = 1;
        } else if (parseFloat(partner) > 100 || parseFloat(partner) < 0) {
            $("#left_partnerN").text(' Partnership should be between 1 and 100');
            $("#left_partnerN").addClass("bordar_highlight");
            i = 1;
        }
    }
    if (FromDate == '') {
        $("#left_FromDateN").text('From Date required');
        $("#left_FromDate").addClass("bordar_highlight");
        i = 1;
    }
    if (i == 0) {
        $("#child_player_add").prop('disabled', true);
        var formData = $("#addChildForm").serializeJSON();
        $.ajax({
            type: "POST",
            url: site_url + 'submit-new-user',
            data: setFormData(formData), //only input
            dataType: 'json',
            cache: false,
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                $("#child_player_add").prop('disabled', false);
                if (output.error == 0) {
                    $("#addChildMsg").show();
                    $("#addChildMsg").html("<span class='succmsg'>" + output.message + "</span>");
                    $("#addChildMsg").fadeOut(2000);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $("#child_player_add").prop('disabled', true);
                    $("#addChildMsg").show();
                    $("#addChildMsg").html("<span class='errmsg'>" + output.message + "</span>");
                    $("#addChildMsg").fadeOut(2000);
                }
            }


        });
    }
    i++;
});

$(document).on("keyup", "#left_partner", function() {
    //$('#left_partner').keyup(function(){
    $leftPartner = $(this).val();
    $parentpartner = $('#parentpartner').val();
    if ($leftPartner) {
        $newval = parseInt($parentpartner) - parseInt($leftPartner);
        $('#less-partnership').text($newval);
    } else {
        $('#less-partnership').text('');
    }
});

function blockMarket(sportId, userId, matchId, marketId, fancyId, usertype, IsPlay) {
    if (matchId > 0) {
        var typ = 'Match';
    } else {
        var typ = 'Sport';
    }
    if (IsPlay == 0) {
        var msg = "Are you sure want to pause this " + typ + ".";
    } else {
        var msg = "Are you sure want to play this " + typ + ".";
    }
    var result = confirm(msg);
    if (result) {
        var formData = {
            'sportId': sportId,
            'userId': userId,
            'matchId': matchId,
            'marketId': marketId,
            'fancyId': fancyId,
            'usertype': usertype,
            'IsPlay': IsPlay,
            'compute': Cookies.get('_compute')
        };
        jQuery.ajax({
            url: site_url + 'update-block-market',
            data: setFormData(formData),
            type: 'post',
            dataType: 'json',
            success: function(data) {
                data = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(data), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if (data.error == '0') {
                    if (IsPlay == 0) {
                        marketaction({
                            'userId': userId,
                            'sportId': sportId,
                            'matchId': matchId,
                            'marketId': marketId,
                            'type': 'onoff'
                        });
                    }
                    new PNotify({
                        title: 'Success',
                        text: data.message,
                        type: 'success',
                        styling: 'bootstrap3',
                        delay: 3000
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    new PNotify({
                        title: '403 Error',
                        text: data.message,
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000
                    });
                }
            }
        });
    }
}

function updatePartnerhsip(id, ptype) {
    var p1 = parseInt($("#partner1" + id).val());
    var p2 = parseInt($("#partner2" + id).val());
    var formData = { 'p1': p1, 'p2': p2, 'id': id, 'ptype': ptype };
    $.ajax({
        url: site_url + 'update-partnership',
        type: 'post',
        data: setFormData(formData),
        success: function(output) {
            output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
            alert(output.message);
        }
    });
}

function closeMarketSeries(userId, matchId, marketId, fancyId, usertype, IsPlay) {
    var HelperID = 0;
    var formData = { 'userId': userId, 'matchId': matchId, 'marketId': marketId, 'fancyId': fancyId, 'usertype': usertype, 'IsPlay': IsPlay };
    jQuery.ajax({
        url: site_url + 'adminmaster/chaneMarketPPStatusnew',
        data: setFormData(formData),
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            if (data.error == '0') {
                new PNotify({
                    title: 'Success',
                    text: data.message,
                    type: 'success',
                    styling: 'bootstrap3',
                    delay: 3000
                });
                setTimeout(function() { location.reload(); }, 3000);
            } else {
                new PNotify({
                    title: '403 Error',
                    text: data.message,
                    type: 'error',
                    styling: 'bootstrap3',
                    delay: 3000
                });
                setTimeout(function() { location.reload(); }, 3000);
            }
        },
        error: function(request) {
            new PNotify({
                title: 'Error',
                text: 'Your request cannot be procced now.',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000
            });
        },
    });
}