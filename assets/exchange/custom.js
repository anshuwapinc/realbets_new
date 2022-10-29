$(document).ready(function() {
    /****************************Chips******************************/
    $("#chip-form").validate({
        rules: {
            chip_name: {
                required: true,
            },
            chip_value: {
                required: true,
            },
        },

        submitHandler: function(form, event) {
            event.preventDefault();
            var chip_name = $("#chip_name").val().trim();
            var chip_value = $("#chip_value").val().trim();
            var chip_id = $("#chip_id").val().trim();

            $("#exampleModal").modal("hide");
            $("#chip-form").trigger("reset");
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $.ajax({
                url: base_url + "admin/Chip/addchip",
                method: "POST",
                data: {
                    chip_id: chip_id,
                    chip_name: chip_name,
                    chip_value: chip_value,
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        if (chip_id != "") {
                            new PNotify({
                                title: "Success",
                                text: "Chip Updated successfully",
                                type: data.notifytype,
                                styling: "bootstrap3",
                                type: "success",

                                delay: 3000,
                            });
                        } else {
                            new PNotify({
                                title: "Success",
                                text: "Chip Created successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });
                        }
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    } else {
                        new PNotify({
                            title: "Error",
                            text: data.message ? data.message : "Something went wrong please try againe later",
                            styling: "bootstrap3",
                            type: "error",

                            delay: 3000,
                        });
                    }
                },
            });
            return false;
        },
    });
});

$(document).on("click", ".edit-chip", function() {
    var chip_id = $(this).data("chip-id");
    var chip_name = $(this).data("chip-name");
    var chip_value = $(this).data("chip-value");
    $("#chip_id").val(chip_id);
    $("#chip_name").val(chip_name);
    $("#chip_value").val(chip_value);
    $("#exampleModal").modal("show");
});

function deleteChip(chip_id, chip_name) {
    bootbox.confirm({
        title: "Alert!",
        message: "&nbsp;&nbsp;Are you sure you want to delete <b>" +
            chip_name +
            "</b> chip ?",
        callback: function(result) {
            if (result) {
                // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

                $.ajax({
                    url: base_url + "admin/Chip/deletechip",
                    method: "POST",
                    data: {
                        chip_id: chip_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        // $.unblockUI;
                        if (response.success) {
                            new PNotify({
                                title: "Success",
                                text: "Chip Deleted successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });

                            setTimeout(function() {
                                window.location.reload(1);
                            }, 2000);
                        } else {
                            new PNotify({
                                title: "Success",
                                text: "Something went wrong please try again later",
                                styling: "bootstrap3",
                                type: "error",
                                delay: 3000,
                            });

                            setTimeout(function() {
                                window.location.reload(1);
                            }, 2000);
                        }
                    },
                });
            }
        },
    });
}
/****************************Chips******************************/

/****************************Users******************************/

$(document).ready(function() {

    $("#add-user-form").validate({
        rules: {
            name: {
                required: true,
            },
            user_name: {
                required: true,
                remote: {
                    url: base_url + "admin/User/register_username_exists",
                    type: "post",
                    data: {
                        login: function() {
                            return $("#user_name").val();
                        },
                    },
                },
            },
            master_id: {
                required: true,

            },
            registration_date: {
                required: true,
            },
            password: {
                required: true,
                // pwcheck: true,
                minlength: 4,
            },
            master_commision: {
                required: true,
            },
            partnership: {
                required: true,
            },
            deposite_bal: {
                required: true,
            },
            // teenpati_partnership: {
            //   required: true,
            // },
            // casino_partnership: {
            //   required: true,
            // },
        },
        messages: {
            user_name: {
                //   required: "Please enter your login.",
                remote: "User Id is already taken",
            },
        },
        submitHandler: function(form, event) {
            event.preventDefault();

            var user_id = $("#user_id").val().trim();
            var master_id = $("#master_id").val().trim();
            var master_id_tmp = $("#master_id_tmp").val().trim();

            var name = $("#name").val().trim();
            var user_name = $("#user_name").val().trim();
            var password = $("#password").val().trim();
            var user_type = $("#user_type").val().trim();
            var master_commision = $("#master_commision").val().trim();
            var session_commision = $("#session_commision").val().trim();

            var registration_date = $("#registration_date").val().trim();
            var partnership = $("#partnership").val().trim();
            var deposite_bal = $("#deposite_bal").val().trim();
            var casino_partnership = partnership;
            var teenpati_partnership = partnership;
            var deposite_bal = deposite_bal;

            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $.ajax({
                url: base_url + "admin/User/adduser",
                method: "POST",
                data: {
                    user_id: user_id,
                    user_name: user_name,
                    name: name,
                    password: password,
                    user_type: user_type,
                    master_commision: master_commision,
                    session_commision: session_commision,
                    registration_date: registration_date,
                    master_id: master_id,
                    master_id_tmp: master_id_tmp,
                    partnership: partnership,
                    casino_partnership: casino_partnership,
                    teenpati_partnership: teenpati_partnership,
                    deposite_bal: deposite_bal,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#userModel").modal("hide");
                        new PNotify({
                            title: "Success",
                            text: "User Created Successfully",
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    } else {
                        new PNotify({
                            title: "Alert",
                            text: response.errorMessage ? response.errorMessage : "Something went wrong please try again later",
                            styling: "bootstrap3",
                            type: "error",
                            delay: 3000,
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    }
                },
            });
        },
    });

    $.validator.addMethod("pwcheck", function(value) {
        return (
            /^[A-Za-z0-9\d=!]*$/.test(value) && // consists of only these
            /[a-z]/.test(value) && // has a lowercase letter
            /[A-Z]/.test(value) && // has a uppercase letter
            /\d/.test(value)
        ); // has a digit
    });



    $("#update-user-form").validate({
        rules: {

            edit_detail_user_id: {
                required: true,

            },
            edit_partnership: {
                required: true,
            },
            edit_match_commission: {
                required: true,

            },
            edit_session_commission: {
                required: true,
            },

        },

        submitHandler: function(form, event) {
            event.preventDefault();

            var user_id = $("#edit_detail_user_id").val().trim();
            var partnership = $("#edit_partnership").val().trim();
            var master_commision = $("#edit_match_commission").val().trim();
            var session_commision = $("#edit_session_commission").val().trim();




            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $.ajax({
                url: base_url + "admin/User/updateuser",
                method: "POST",
                data: {
                    user_id: user_id,
                    master_commision: master_commision,
                    session_commision: session_commision,
                    partnership: partnership,

                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#editUserModel").modal("hide");
                        new PNotify({
                            title: "Success",
                            text: "User Updated Successfully",
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    } else {
                        new PNotify({
                            title: "Alert",
                            text: "Something went wrong please try again later",
                            styling: "bootstrap3",
                            type: "error",
                            delay: 3000,
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    }
                },
            });
        },
    });
});

function changePasswordModel(user_id, user_name) {
    $("#edit_user_id").val(user_id);
    $("#edit_user_name").val(user_name);

    $("#userChangePasswordModel").modal("show");
}


function changeMasterPassword(user_id, user_name) {
    $("#master_user_id_1").val(user_id);
    $("#master_user_name").val(user_name);
    $("#masterPasswordModal").modal("show");
}

$(document).ready(function() {
    /****************************Chips******************************/
    $("#user-change-password-form").validate({
        rules: {

            edit_password: {
                required: true,
                // pwcheck: true,
                minlength: 4,
            },
            edit_confirm_password: {
                required: true,
                equalTo: "#edit_password",
            },
        },
        message: {
            edit_confirm_password: {
                equalTo: "Confirm password not matched",
            },
        },

        submitHandler: function(form, event) {
            event.preventDefault();
            $("#userChangePasswordModel").modal("hide");

            var user_id = $("#edit_user_id").val().trim();
            var user_name = $("#user_name").val().trim();
            var password = $("#edit_password").val().trim();
            var confirm_password = $("#edit_confirm_password").val().trim();

            $("#userModel").modal("hide");
            $("#user-change-password-form").trigger("reset");
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $.ajax({
                url: base_url + "admin/User/changePassword",
                method: "POST",
                data: {
                    user_id: user_id,
                    password: password,
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        new PNotify({
                            title: "Success",
                            text: "Password Changed successfully",
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    } else {
                        new PNotify({
                            title: "Alert",
                            text: data.message ? data.message : "Something went wrong please try again later",
                            styling: "bootstrap3",
                            type: "error",
                            delay: 3000,
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    }
                },
            });
        },
    });
    $.validator.addMethod("pwcheck", function(value) {
        return (
            /^[A-Za-z0-9\d=!]*$/.test(value) && // consists of only these
            /[a-z]/.test(value) && // has a lowercase letter
            /[A-Z]/.test(value) && // has a uppercase letter
            /\d/.test(value)
        ); // has a digit
    });






    $("#master-password-form").validate({
        rules: {
            master_password: {
                required: true,
                // pwcheck: true,
                minlength: 4,
            },
            master_confirm_password: {
                required: true,
                equalTo: "#master_password",
            },
        },
        message: {
            master_confirm_password: {
                equalTo: "Confirm password not matched",
            },
        },

        submitHandler: function(form, event) {
            event.preventDefault();
            $("#masterPasswordModal").modal("hide");

            var user_id = $("#master_user_id_1").val().trim();
            var password = $("#master_password").val().trim();

            $("#userModel").modal("hide");
            $("#master-password-form").trigger("reset");
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $.ajax({
                url: base_url + "admin/User/changeMasterPassword",
                method: "POST",
                data: {
                    user_id: user_id,
                    password: password,
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        new PNotify({
                            title: "Success",
                            text: "Password Changed successfully",
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    } else {
                        new PNotify({
                            title: "Alert",
                            text: data.message ? data.message : "Something went wrong please try again later",
                            styling: "bootstrap3",
                            type: "error",
                            delay: 3000,
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    }
                },
            });
        },
    });
    $.validator.addMethod("pwcheck", function(value) {
        return (
            /^[A-Za-z0-9\d=!]*$/.test(value) && // consists of only these
            /[a-z]/.test(value) && // has a lowercase letter
            /[A-Z]/.test(value) && // has a uppercase letter
            /\d/.test(value)
        ); // has a digit
    });
});

/****************************Users******************************/

/****************************Change password Self************* */
function showChangePassword(user_id, user_name) {
    $("#current_user_id").val(user_id);
    $("#current_user_name").val(user_name);
    $("#changePassword").modal("show");
}

$(document).ready(function() {
    /****************************Chips******************************/
    $("#change-password-global-form").validate({
        rules: {
            new_password: {
                required: true,
                // pwcheck: true,
                minlength: 4,
            },
            confirm_new_password: {
                required: true,
                equalTo: "#new_password",
            },
        },
        message: {
            edit_confirm_password: {
                equalTo: "Confirm password not matched",
            },
        },

        submitHandler: function(form, event) {
            event.preventDefault();

            var user_id = $("#current_user_id").val().trim();
            var password = $("#new_password").val().trim();

            $("#changePassword").modal("hide");
            $("#change-password-global-form").trigger("reset");
            // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

            $.ajax({
                url: base_url + "admin/User/changePassword",
                method: "POST",
                data: {
                    user_id: user_id,
                    password: password,
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        new PNotify({
                            title: "Success",
                            text: "Password Changed successfully",
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    } else {
                        new PNotify({
                            title: "Alert",
                            text: "Something went wrong please try again later",
                            styling: "bootstrap3",
                            type: "error",
                            delay: 3000,
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);
                    }
                },
            });
        },
    });
    $.validator.addMethod("pwcheck", function(value) {
        return (
            /^[A-Za-z0-9\d=!]*$/.test(value) && // consists of only these
            /[a-z]/.test(value) && // has a lowercase letter
            /[A-Z]/.test(value) && // has a uppercase letter
            /\d/.test(value)
        ); // has a digit
    });
});

$(document).ready(function() {
    var oTable = $('#masters_association_list').DataTable();
    $("#chip-in-out-form").submit(function(e) {
        e.preventDefault();

        $("#chip-in-out-form").validate({
            rules: {
                ChipsValue: {
                    required: true,
                },
                passwordChips: {
                    required: true,
                },
            },
            message: {},

            submitHandler: function(form, event) {
                // $(this).off(event);
                // alert("Hello");
                // event.preventDefault();
                $("#changePasswordModel1").modal("hide");

                $("#deposit_button").attr("disable", true);
                $("#withdrawl_button").attr("disable", true);

                var passwordChips = $("#passwordChips").val();
                var ChipsValue = $("#ChipsValue").val();
                var type = $("#type").val();
                var user_id_chip = $("#user_id_chip").val();
                var chip_master_id = $("#chip_master_id").val();
                var remarks = $("#remarks").val();
                $.ajax({
                    url: base_url + "admin/User/chip_update",
                    method: "POST",
                    data: {
                        user_id: user_id_chip,
                        type: type,
                        passwordChips: passwordChips,
                        ChipsValue: ChipsValue,
                        chip_master_id: chip_master_id,
                        remarks: remarks,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.success) {
                            $("#changePasswordModel1").modal("hide");
                            new PNotify({
                                title: "Success",
                                text: "Chip Updated successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });

                            setTimeout(function() {
                                oTable.ajax.reload(null, false)
                            }, 2000);
                        } else {
                            new PNotify({
                                title: "Alert",
                                text: data.message ? data.message : "Something went wrong please try again later",
                                styling: "bootstrap3",
                                type: "error",
                                delay: 3000,
                            });
                            setTimeout(function() {
                                oTable.ajax.reload(null, false)
                            }, 2000);
                        }
                    },
                });
                return false;
            },

        });
    });
    /****************************Chips******************************/

});

/****************************Change password Self************* */

function favouriteSport(event_id) {
    $.ajax({
        url: base_url + "admin/Events/favouriteEvent",
        method: "POST",
        data: {
            event_id: event_id,
        },
        dataType: "json",
        success: function(data) {},
    });
}

function blockMarket(
    sportId,
    userId,
    matchId,
    marketId,
    fancyId,
    usertype,
    IsPlay,
    Type
) {
    if (matchId > 0) {
        var typ = "Match";
    } else {
        var typ = "Sport";
    }

    console.clear();

    console.log({
        sportId: sportId,
        userId: userId,
        matchId: matchId,
        marketId: marketId,
        fancyId: fancyId,
        usertype: usertype,
        IsPlay: IsPlay,
        Type: Type,
    });
    if (IsPlay == 0) {
        var msg = "Are you sure want to pause this " + typ + ".";
    } else {
        var msg = "Are you sure want to play this " + typ + ".";
    }

    // var result = confirm(msg);
    // if (result) {
    var request = {
        sportId: sportId,
        userId: userId,
        matchId: matchId,
        marketId: marketId,
        fancyId: fancyId,
        usertype: usertype,
        IsPlay: IsPlay,
        Type: Type,
    };
    jQuery.ajax({
        url: base_url + "admin/BlockMarket/block_market_update",
        data: request,
        type: "post",
        dataType: "json",
        success: function success(data) {
            if (data.success) {
                socket.emit("block_markets", {
                    data: request,
                });

                new PNotify({
                    title: "Success",
                    text: data.message,
                    type: "success",
                    styling: "bootstrap3",
                    delay: 3000,
                });
                setTimeout(function() {
                    location.reload();
                }, 3000);
                /*if (marketId == 0) {
                  	//Sport Match
                  	setTimeout(function () { location.reload();}, 3000);
                  } else if (marketId.search(".") > -1) {
                  	//Market
                  	if (IsPlay == 1) {
                  		document.getElementById('play-' + marketId).style.display = 'none';
                  		document.getElementById('pause-' + marketId).style.display = 'block';
                  	}
                  	else {
                  		document.getElementById('pause-' + marketId).style.display = 'none';
                  		document.getElementById('play-' + marketId).style.display = 'block';
                  	}
                  }*/
            } else {
                new PNotify({
                    title: "403 Error",
                    text: data.message,
                    type: "error",
                    styling: "bootstrap3",
                    delay: 3000,
                });
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }
        },
    });
    // }
}

$(document).ready(function() {
    $("#deposit_button").dblclick(function(e) {
        e.preventDefault();
    });
});
$("#news-form").validate({
    rules: {
        descrption: {
            required: true,
        },
    },

    submitHandler: function(form, event) {
        event.preventDefault();
        var description = $("#description").val().trim();
        var news_id = $("#news_id").val().trim();

        $("#exampleModal").modal("hide");
        $("#news-form").trigger("reset");
        // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        $.ajax({
            url: base_url + "admin/News/addnews",
            method: "POST",
            data: {
                news_id: news_id,
                description: description,
            },
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    if (news_id != "") {
                        new PNotify({
                            title: "Success",
                            text: "News Updated successfully",
                            type: data.notifytype,
                            styling: "bootstrap3",
                            type: "success",

                            delay: 3000,
                        });
                    } else {
                        new PNotify({
                            title: "Success",
                            text: "News Created successfully",
                            styling: "bootstrap3",
                            type: "success",
                            delay: 3000,
                        });
                    }
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 2000);
                } else {
                    new PNotify({
                        title: "Error",
                        text: "Something went wrong please try againe later",
                        styling: "bootstrap3",
                        type: "error",

                        delay: 3000,
                    });
                }
            },
        });
        return false;
    },
});

$(document).on("click", ".edit-news", function() {
    var news_id = $(this).data("news-id");
    var description = $(this).data("description");
    $("#news_id").val(news_id);
    $("#description").val(description);
    $("#exampleModal").modal("show");
});

function deleteNews(news_id, description) {
    bootbox.confirm({
        title: "Alert!",
        message: "&nbsp;&nbsp;Are you sure you want to delete <b>'" +
            description +
            "'</b> news ?",
        callback: function(result) {
            if (result) {
                // $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
                $.ajax({
                    url: base_url + "admin/News/deletenews",
                    method: "POST",
                    data: {
                        news_id: news_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        // $.unblockUI;
                        if (response.success) {
                            new PNotify({
                                title: "Success",
                                text: "News Deleted successfully",
                                styling: "bootstrap3",
                                type: "success",
                                delay: 3000,
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 2000);
                        } else {
                            new PNotify({
                                title: "Success",
                                text: "Something went wrong please try again later",
                                styling: "bootstrap3",
                                type: "error",
                                delay: 3000,
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 2000);
                        }
                    },
                });
            }
        },
    });
}

function getDataByType(type, listId) {
    $('#positionView').hide();
    $('#bettingView').show();
    $(".positondata").removeClass("active");
    $('#fancy-positionView').hide();

    // $('.fancy-positondata').removeClass('active');

    $(".betdata").removeClass("active");
    $("." + listId).addClass("active");
    $("#all-betting-data .all-bet-slip").hide();

    $("#all-betting-data .match-bet-slip").show();
    if (type == "all") {
        $(".all-bet-slip").show();
        $(".match-bet-slip").show();

    } else if (type == "match") {
        $(".unmatch-bet-slip").hide();

        $(".all-bet-slip").hide();
        $(".match-bet-slip").show();
    } else if (type == "fancy") {
        $(".unmatch-bet-slip").hide();

        $(".all-bet-slip").hide();
        $(".fancy-bet-slip").show();
    } else if (type == "unmatch") {
        $(".all-bet-slip").hide();
        $(".fancy-bet-slip").hide();
        $(".unmatch-bet-slip").show();

    }
}

function getBettingDataByType(type, listId, eventId) {

    // $(".betting-border-box").hide();
    // $(".border-box-" + eventId).show();
    $(".betdata").removeClass("active");
    $("#" + listId).addClass("active");
    if (type == "all") {
        $(".all-bet-slip").show();
    } else if (type == "match") {
        $(".all-bet-slip").hide();
        $(".match-bet-slip").show();
    } else if (type == "fancy") {
        $(".all-bet-slip").hide();
        $(".fancy-bet-slip").show();
    }
}

function showBetsWindow(eventId) {
    $(".border-box-" + eventId).toggle();

    if ($(".border-box-" + eventId).is(":visible")) {
        $(".show-net-btn-" + eventId).text("Hide");
    } else {
        $(".show-net-btn-" + eventId).text("Show");
    }
}

function themeChange(theme_id) {
    $.ajax({
        url: base_url + "admin/User/themeUpdate",
        method: "POST",
        data: {
            theme_id: theme_id,
        },
        dataType: "json",
        success: function(data) {
            window.location.reload(1);
        },
    });
}

function goBack() {
    window.history.back();
}

function setIntervalX(callback, delay, repetitions) {
    var x = 0;
    var intervalID = window.setInterval(function() {

        callback();

        if (++x === repetitions) {
            window.clearInterval(intervalID);
        }
    }, delay);
}