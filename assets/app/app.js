var myarray = [],
    matchIdarray = [],
    manualarray = [],
    MarketIDArr = [],
    MatchIDArr = [],
    fancyIDArr = [],
    fancyIDJoinM = [];
var currentBet = '',
    currentBetMarketId = '';
var slide = 0,
    PositionuserId = 0,
    PositionuserTypeId, match_count, unmatch_count, fancy_count = 0;
var socket = {};
var gameType = 'market';
var isMobile = false;
if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
    /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
    isMobile = true;
}

if (window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1) == 'casino') {
    var gameType = 'casino';
}
var CRYPTPASS = '12e75eb1cdff3e333dc2b3fb35c8b7b1';

$(".MatchTvHide").click(function() {
    $(".MatchTvHideShow").slideToggle("fast");
    $(this).find(".MatchTvHideDown").toggleClass("down up");
});
$(".MatchHide").click(function() {
    $(".MatchHideShow").slideToggle("fast");
    $(this).find(".MatchHideDown").toggleClass("down up");
});

function websocket() {
    socket = io.connect(socketurl + ':4901?token=' + userId1 + '&type=' + userType1 + '&session_id=' + socketToken, { transports: ['websocket'], forceNew: true });
    socketodds = io.connect(socketurl + ':4902', { transports: ['websocket'], forceNew: true });


    socketodds.on('connect', function() {
        $.each(myarray, function(key, MarketId) {
            socketodds.emit('channel-room', MarketId);
        });
        $.each(manualarray, function(key, MarketId) {
            socketodds.emit('channel-Market', MarketId);
        });
        $.each(fancyIDJoinM, function(key, id) {
            socketodds.emit('channel-Fancy', id);
        });

    });
    socket.on('connect', function() {
        if (gameType == 'market') {
            socket.emit('channel', ('setting'));
            if (userType1 < 4) {
                socket.emit('channel', 'betnotify-' + userId1);
            }
            $.each(matchIdarray, function(key, matchId) {
                socket.emit('channel', matchId);
                socket.emit('channel', matchId + '-' + userId1);
            });

        }
    });

    socket.on('n_ln', function() {
        checkLogin();
    });

    socket.on('bn', function(data) {
        //data = $.parseJSON(CryptoJS.AES.decrypt(data, CRYPTPASS, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
        if (betNotifyjs == '1') {
            new PNotify({
                //title: 'Success',
                text: data.Username + ' place ' + data.betTitle + ' bet on ' + data.MatchName + ' of Odds:' + data.Odds + '  Stake: ' + data.stake,
                type: (data.isBack && data.isBack == 0 ? 'info' : 'error'),
                styling: 'bootstrap3',
                delay: 1000,
                icon: false,
                addclass: "stack-bottomright",
            });
        }
    });
    socket.on('on', function(data) {
        showdata(data)
    })
    socket.on('n_mh', function(data) {
        //data = $.parseJSON(CryptoJS.AES.decrypt(data, CRYPTPASS, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
        if ('sett' in data && data.sett.id in MatchIDArr) {
            if (data.sett.action == 'volumeLimit') {
                MatchIDArr[data.sett.id].volumeLimit = data.sett.value;
            } else if (data.sett.action == 'is_show' && data.sett.value == 'Y') {
                $(".onverlay" + data.sett.id).remove();
            } else if (data.sett.action == 'is_show' && data.sett.value == 'N') {
                $("<div class='overlay-table onverlay" + data.sett.id + "'><span>Betting not open.</span></div>").insertBefore("#matchTable" + data.sett.id);
            }
        } else if ('market_msg' in data) {
            console.log(data);
            $(".matchTable" + data.id.toString().replace('.', '') + " .market-msg").text(data.market_msg)
        } else if ('fancy_msg' in data) {
            $(".f_message" + data.id).text(data.fancy_msg)
        } else if ('fancy_fetch_type' in data) {
            fancy_type = data.fancy_fetch_type;

        } else if ('sett' in data && data.sett.id == 0 && data.sett.value == 'Y') {
            matchIdarray.forEach(function(val, key) {
                $(".onverlay" + val).remove();
            });
        } else if ('sett' in data && data.sett.id == 0 && data.sett.value == 'N') {
            matchIdarray.forEach(function(val, key) {
                $("<div class='overlay-table onverlay" + val + "'><span>Betting not open.</span></div>").insertBefore("#matchTable" + val);
            });
        } else if ('btype' in data && userType1 < 4 && (userType1 > 0 || data.rel_id == rel_id)) {
            if (data.btype == 'fancy') {
                fancyposition(data.market_id)

                if (data.match_id == currentBet) {
                    fancy_count = fancy_count + 1;
                    $("#cnt_row2").text("(" + fancy_count + ")");
                    $("#cnt_row").text("(" + (match_count + fancy_count) + ")");

                    $('<tr id ="user_row_' + (data.LID ? data.LID : 0) + '" class="' + data.markback + ' content_user_table"  ><td class="' + data.markback + '">' + fancy_count + '</td><td class="' + data.markback + '">' + data.runner + '</td><td class="' + data.markback + '">' + data.betType + '</td><td class="' + data.markback + '">' + data.clientname + '</td><td class="' + data.markback + '">' + data.Odds + '</td><td class="' + data.markback + '">' + data.stake + '</td></tr>').insertBefore('.tableid3 table > tbody > tr:first');

                    $('<tr id ="user_row_' + (data.LID ? data.LID : 0) + '" class="' + data.markback + ' content_user_table"  ><td class="' + data.markback + '">' + (match_count + fancy_count) + '</td><td class="' + data.markback + '">' + data.runner + '</td><td class="' + data.markback + '">' + data.clientname + '</td><td class="' + data.markback + '">' + data.Odds + '</td><td class="' + data.markback + '">' + data.stake + '</td><td class="' + data.markback + '">' + data.betType + '</td></tr>').insertBefore('.tableid4 table > tbody > tr:first');

                }
            } else if (data.isMatched == 0) {
                if (data.MatchId == currentBet) {
                    unmatch_count = unmatch_count + 1;
                    $("#cnt_row1").text("(" + unmatch_count + ")");
                    $('<tr id ="user_row_' + data.MstCode + '" class="' + data.markback + ' content_user_table"  ><td class="' + data.markback + '"><a href="javascript:;" title="Delete Record" onclick="deleteunMatchOdds(' + data.MstCode + ', ' + data.UserId + ');"><img src="' + site_url + 'assets/images/trash-orderslip.png" style="width:18px;" alt="delete bet"></a></td><td class="' + data.markback + '">' + data.runner + '</td><td class="' + data.markback + '">' + data.betType + '</td><td class="' + data.markback + '">' + data.Username + '</td><td class="' + data.markback + '">' + data.Odds + '</td><td class="' + data.markback + '">' + data.stake + '</td></tr>').insertBefore('.tableid2 table > tbody > tr:first');
                }
            } else {
                if (data.MatchId == currentBet) {
                    match_count = match_count + 1;
                    $("#cnt_row").text("(" + (match_count + fancy_count) + ")");

                    $('<tr id ="user_row_' + (data.MstCode ? data.MstCode : 0) + '" class="' + data.markback + ' content_user_table"  ><td class="' + data.markback + '">' + (match_count + fancy_count) + '</td><td class="' + data.markback + '">' + data.runner + '</td><td class="' + data.markback + '">' + data.Username + '</td><td class="' + data.markback + '">' + data.Odds + '</td><td class="' + data.markback + '">' + data.stake + '</td><td class="' + data.markback + '">' + data.betType + '</td></tr>').insertBefore('.tableid4 table > tbody > tr:first');
                }
                if (MatchIDArr[data.MatchId][data.MarketId] == '') {
                    MatchIDArr[data.MatchId][data.MarketId] = new Date();
                    marketPosition(data.MatchId, data.MarketId, data.oddeven);
                } else {
                    var endDate = new Date();
                    var seconds = (endDate.getTime() - MatchIDArr[data.MatchId][data.MarketId].getTime()) / 1000;
                    if (seconds >= 5) {
                        MatchIDArr[data.MatchId][data.MarketId] = new Date();
                        marketPosition(data.MatchId, data.MarketId, data.oddeven);
                    }
                }

            }
        } else if ('fancydataupdate' in data) {

            if (fancy_type == 'API' && data.fancydataupdate == 1 && data.market_id in fancyIDArr) {
                fancyupdate(Object.assign(fancyIDArr[data.market_id], data));
            } else if (fancy_type == 'W' && data.fancydataupdate == 2 && data.market_id in fancyIDArr) {
                fancyupdate(Object.assign(fancyIDArr[data.market_id], data));
            }


            // updateFancy(data.fancy);
        } else if ('fancy' in data) {
            // updateFancy(data.fancy);
        } else if ('fancy_a' in data) {
            if (data.market_id in fancyIDArr) {
                fancyIDArr[data.market_id].active = 1;
                //	console.log(fancyIDArr[data.market_id].active)
            }

            fancyAdd(data.fancy_a);
        } else if ('fancy_r' in data) {
            if (data.market_id in fancyIDArr) {
                fancyIDArr[data.market_id].active = 0;

            }

            $(".fancy_" + data.fancy_r).remove();
        } else if ('fancy_active' in data) {
            fancyIDArr[data.mid].active = 1;
            $(".show_msg_box_" + data.fancy_active).removeClass("ball-running-msg");
            $(".show_msg_box_" + data.fancy_active).html(' ');
        } else if ('fancy_inactive' in data) {
            fancyIDArr[data.mid].active = 0;
            $(".show_msg_box_" + data.fancy_inactive).addClass("ball-running-msg");
            $(".show_msg_box_" + data.fancy_inactive).html('<h1>Ball Running</h1>');
        } else if ('ctype' in data) {
            closemarket(data);
        }
    });
    socket.on('sc', function(data) {
        GetScoreApi(data.score);
    });
    socketodds.on('fnn', function(data) {
        if (fancy_type == 'API' && data.fancydataupdate == 1 && data.market_id in fancyIDArr) {
            fancyupdate(Object.assign(fancyIDArr[data.market_id], data));
        } else if (fancy_type == 'W' && data.fancydataupdate == 2 && data.market_id in fancyIDArr) {
            fancyupdate(Object.assign(fancyIDArr[data.market_id], data));
        }

    });

    socketodds.on('mrr', function(data) {
        runner = data.odds;
        updateOdds(runner);
    });


    socket.onerror = function(ev) {
        console.log('error' + ev);
    }
    socket.onclose = function(ev) {
        console.log('close' + ev);
    };
    socketodds.onerror = function(ev) {
        console.log('error' + ev);
    }
    socketodds.onclose = function(ev) {
        console.log('close' + ev);
    };
}
var multiodds = [];
var multioddseq = [];
var multioddsMarket = '';
var ismultibet = 0;

function updateOdds(runner, isAdd = 0) {
    var MarketID = runner.marketId;
    if (runner.numberOfRunners == 1) {

        var fancyd = fancyIDArr[MarketID];
        var mult_value = 1;
        if (runner.status == 'OPEN') {

            if (runner.runners[0].ex.availableToBack && runner.runners[0].ex.availableToLay && runner.runners[0].ex.availableToBack.length > 0 && runner.runners[0].ex.availableToBack[0].price > 0) {
                if (fancyd.active == 1) {
                    $(".show_msg_box_" + fancyd.ID).removeClass("ball-running-msg");
                    $(".show_msg_box_" + fancyd.ID).html('');
                }
                var backprice = Math.round(parseFloat(runner.runners[0].ex.availableToBack[0].price));
                var layprice = Math.round(parseFloat(runner.runners[0].ex.availableToLay[0].price));
                var backsize = Math.round(parseInt(runner.runners[0].ex.availableToBack[0].size) * mult_value);
                var laysize = Math.round(parseInt(runner.runners[0].ex.availableToLay[0].size) * mult_value);
                //	console.log(">>>",$("#LayNO_0" + fancyd.ID).text()+">>>"+ backsize );
                if ($("#LayNO_0" + fancyd.ID).text() != backprice || $("#NoValume_0" + fancyd.ID).text() != backsize) {
                    $("#LayNO_0" + fancyd.ID).parent().addClass('yello');
                } else {
                    $("#LayNO_0" + fancyd.ID).parent().removeClass('yello');
                }

                if ($("#BackYes_0" + fancyd.ID).text() != layprice || $("#YesValume_0" + fancyd.ID).text() != laysize) {
                    $("#BackYes_0" + fancyd.ID).parent().addClass('yello');
                } else {
                    $("#BackYes_0" + fancyd.ID).parent().removeClass('yello');
                }

                $("#LayNO_0" + fancyd.ID).text(backprice);
                $("#BackYes_0" + fancyd.ID).text(layprice);
                $("#NoValume_0" + fancyd.ID).text(backsize);
                $("#YesValume_0" + fancyd.ID).text(laysize);
                setTimeout(function() { $("#LayNO_0" + fancyd.ID).parent().removeClass('yello'); }, 700);
                setTimeout(function() { $("#BackYes_0" + fancyd.ID).parent().removeClass('yello'); }, 700);


            } else {
                $(".show_msg_box_" + fancyd.ID).addClass("ball-running-msg");
                $(".show_msg_box_" + fancyd.ID).html('<h1>Ball Started</h1>');
            }
        } else {

        }
    } else {

        var MatchId = MarketIDArr[MarketID];
        var volumnLimit = MatchIDArr[MatchId].volumeLimit;
        var MId = MarketID.replace('.', '');
        let lay = 0;
        let back = 0;
        if (runner.status == 'OPEN' || runner.status == 'SUSPENDED') {
            var key1 = 0;
            var key2 = 0;
            $.each(runner.runners, function(key11, runData) {
                let layP = '';
                let backP = '';
                if (runData.ex.availableToBack) {
                    if (runData.ex.availableToBack[0]) {
                        if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToBack0_price_" + MId).text()) != runData.ex.availableToBack[0].price) {
                            $("." + runData.selectionId + "_" + key1 + "availableToBack0_price_" + MId).addClass("yello");
                        } else {
                            $("." + runData.selectionId + "_" + key1 + "availableToBack0_price_" + MId).removeClass("yello");
                        }
                        $("#" + runData.selectionId + "_" + key1 + "availableToBack0_price_" + MId).text(runData.ex.availableToBack[0].price);
                        backP = runData.ex.availableToBack[0].price - 1;
                    } else {
                        $("#" + runData.selectionId + "_" + key1 + "availableToBack0_price_" + MId).text('');
                    }
                    if (runData.ex.availableToBack[1]) {

                        if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToBack1_price_" + MId).text()) != runData.ex.availableToBack[1].price) {
                            $("." + runData.selectionId + "_" + key1 + "availableToBack1_price_" + MId).addClass("yello");
                        } else {
                            $("." + runData.selectionId + "_" + key1 + "availableToBack1_price_" + MId).removeClass("yello");
                        }
                        $("#" + runData.selectionId + "_" + key1 + "availableToBack1_price_" + MId).text(runData.ex.availableToBack[1].price);
                    } else {
                        $("#" + runData.selectionId + "_" + key1 + "availableToBack1_price_" + MId).text('');
                    }
                    if (runData.ex.availableToBack[2]) {

                        if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToBack2_price_" + MId).text()) != runData.ex.availableToBack[2].price) {
                            $("." + runData.selectionId + "_" + key1 + "availableToBack2_price_" + MId).addClass("yello");
                        } else {
                            $("." + runData.selectionId + "_" + key1 + "availableToBack2_price_" + MId).removeClass("yello");
                        }
                        $("#" + runData.selectionId + "_" + key1 + "availableToBack2_price_" + MId).text(runData.ex.availableToBack[2].price);
                    } else {
                        $("#" + runData.selectionId + "_" + key1 + "availableToBack2_price_" + MId).text('');
                    }
                }
                if (runData.ex.availableToLay) {
                    if (runData.ex.availableToLay[0]) {
                        if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToLay0_price_" + MId).text()) != runData.ex.availableToLay[0].price) {
                            $("." + runData.selectionId + "_" + key1 + "availableToLay0_price_" + MId).addClass("yello");
                        } else {
                            $("." + runData.selectionId + "_" + key1 + "availableToLay0_price_" + MId).removeClass("yello");
                        }
                        $("#" + runData.selectionId + "_" + key1 + "availableToLay0_price_" + MId).text(runData.ex.availableToLay[0].price);
                        layP = runData.ex.availableToLay[0].price - 1;
                    } else {
                        $("#" + runData.selectionId + "_" + key1 + "availableToLay0_price_" + MId).text('');
                    }
                    if (runData.ex.availableToLay[1]) {

                        if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToLay1_price_" + MId).text()) != runData.ex.availableToLay[1].price) {
                            $("." + runData.selectionId + "_" + key1 + "availableToLay1_price_" + MId).addClass("yello");
                        } else {
                            $("." + runData.selectionId + "_" + key1 + "availableToLay1_price_" + MId).removeClass("yello");
                        }
                        $("#" + runData.selectionId + "_" + key1 + "availableToLay1_price_" + MId).text(runData.ex.availableToLay[1].price);
                    } else {
                        $("#" + runData.selectionId + "_" + key1 + "availableToLay1_price_" + MId).text('');
                    }
                    if (runData.ex.availableToLay[2]) {

                        if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToLay2_price_" + MId).text()) != runData.ex.availableToLay[2].price) {
                            $("." + runData.selectionId + "_" + key1 + "availableToLay2_price_" + MId).addClass("yello");
                        } else {
                            $("." + runData.selectionId + "_" + key1 + "availableToLay2_price_" + MId).removeClass("yello");
                        }
                        $("#" + runData.selectionId + "_" + key1 + "availableToLay2_price_" + MId).text(runData.ex.availableToLay[2].price);
                    } else {
                        $("#" + runData.selectionId + "_" + key1 + "availableToLay2_price_" + MId).text('');
                    }
                }


                if (multioddsMarket == MId && multiodds.indexOf(runData.selectionId.toString()) !== -1) {

                    if (key2 == 0) {
                        lay = layP;
                        back = backP;
                        key2++;
                    } else {
                        lay = Math.max((parseFloat((parseFloat(lay) * parseFloat(layP) - 1) / (parseFloat(lay) + parseFloat(layP) + 2))).toFixed(2), 0);
                        back = Math.max((parseFloat((parseFloat(back) * parseFloat(backP) - 1) / (parseFloat(back) + parseFloat(backP) + 2))).toFixed(2), 0);
                    }
                }

                /* --------- volume ---------  */

                if (!runner.oddsType && runner.oddsType != 'even-odds') {
                    if (runData.ex.availableToBack) {
                        if (runData.ex.availableToBack[0]) {
                            v = getoddVolumn(runData.ex.availableToBack[0].size, volumnLimit);
                            if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToBack0_size_" + MId).text()) != v) {

                                $("." + runData.selectionId + "_" + key1 + "availableToBack0_price_" + MId).addClass("yello");
                            } else {
                                $("." + runData.selectionId + "_" + key1 + "availableToBack0_price_" + MId).removeClass("yello");

                            }
                            $("#" + runData.selectionId + "_" + key1 + "availableToBack0_size_" + MId).text(v);
                        } else {
                            $("#" + runData.selectionId + "_" + key1 + "availableToBack0_size_" + MId).text('');
                        }
                        if (runData.ex.availableToBack[1]) {
                            v = getoddVolumn(runData.ex.availableToBack[1].size, volumnLimit);
                            if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToBack1_size_" + MId).text()) != v) {
                                $("." + runData.selectionId + "_" + key1 + "availableToBack1_price_" + MId).addClass("yello");
                            } else {
                                $("." + runData.selectionId + "_" + key1 + "availableToBack1_price_" + MId).removeClass("yello");

                            }
                            $("#" + runData.selectionId + "_" + key1 + "availableToBack1_size_" + MId).text(v);
                        } else {
                            $("#" + runData.selectionId + "_" + key1 + "availableToBack1_size_" + MId).text('');
                        }
                        if (runData.ex.availableToBack[2]) {
                            v = getoddVolumn(runData.ex.availableToBack[2].size, volumnLimit);
                            if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToBack2_size_" + MId).text()) != v) {
                                $("." + runData.selectionId + "_" + key1 + "availableToBack2_price_" + MId).addClass("yello");
                            } else {
                                $("." + runData.selectionId + "_" + key1 + "availableToBack2_price_" + MId).removeClass("yello");
                            }
                            $("#" + runData.selectionId + "_" + key1 + "availableToBack2_size_" + MId).text(v);
                        } else {
                            $("#" + runData.selectionId + "_" + key1 + "availableToBack2_size_" + MId).text('');
                        }
                    }
                    if (runData.ex.availableToLay) {
                        if (runData.ex.availableToLay[0]) {
                            v = getoddVolumn(runData.ex.availableToLay[0].size, volumnLimit);
                            if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToLay0_size_" + MId).text()) != v) {
                                $("." + runData.selectionId + "_" + key1 + "availableToLay0_price_" + MId).addClass("yello");
                            } else {
                                $("." + runData.selectionId + "_" + key1 + "availableToLay0_price_" + MId).removeClass("yello");
                            }
                            $("#" + runData.selectionId + "_" + key1 + "availableToLay0_size_" + MId).text(v);
                        } else {
                            $("#" + runData.selectionId + "_" + key1 + "availableToLay0_size_" + MId).text('');
                        }
                        if (runData.ex.availableToLay[1]) {
                            v = getoddVolumn(runData.ex.availableToLay[1].size, volumnLimit);
                            if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToLay1_size_" + MId).text()) != v) {
                                $("." + runData.selectionId + "_" + key1 + "availableToLay1_price_" + MId).addClass("yello");
                            } else {
                                $("." + runData.selectionId + "_" + key1 + "availableToLay1_price_" + MId).removeClass("yello");
                            }
                            $("#" + runData.selectionId + "_" + key1 + "availableToLay1_size_" + MId).text(v);
                        } else {
                            $("#" + runData.selectionId + "_" + key1 + "availableToLay1_size_" + MId).text('');
                        }
                        if (runData.ex.availableToLay[2]) {
                            v = getoddVolumn(runData.ex.availableToLay[2].size, volumnLimit);
                            if (isAdd == 0 && $.trim($("#" + runData.selectionId + "_" + key1 + "availableToLay2_size_" + MId).text()) != v) {
                                $("." + runData.selectionId + "_" + key1 + "availableToLay2_price_" + MId).addClass("yello");
                            } else {
                                $("." + runData.selectionId + "_" + key1 + "availableToLay2_price_" + MId).removeClass("yello");
                            }
                            $("#" + runData.selectionId + "_" + key1 + "availableToLay2_size_" + MId).text(v);
                        } else {
                            $("#" + runData.selectionId + "_" + key1 + "availableToLay2_size_" + MId).text('');
                        }
                    }
                }
                setTimeout(function() { $(".matchOpenBox_" + MId + " table td").removeClass('yello'); }, 700);

                if (userAgent == 'web') {

                    if ((runData.status != 'ACTIVE' || runner.status == 'SUSPENDED') && !$(".matchTable" + MId + " .runner-row-" + runData.selectionId).hasClass("ball_running-message")) {
                        $(".matchTable" + MId + " .runner-row-" + runData.selectionId).addClass("ball_running-message");
                        $(".matchTable" + MId + " .runner-row-" + runData.selectionId + " .laybettingbox .mark-lay").append('<h6>' + (runner.status == 'SUSPENDED' ? runner.status : runData.status) + '</h6>');
                    } else if ((runData.status == 'ACTIVE' && runner.status == 'OPEN') && $(".matchTable" + MId + " .runner-row-" + runData.selectionId).hasClass("ball_running-message")) {
                        $(".matchTable" + MId + " .runner-row-" + runData.selectionId).removeClass("ball_running-message");
                        $(".matchTable" + MId + " .runner-row-" + runData.selectionId + " h6").remove('');
                    }
                } else {

                    if ((runData.status != 'ACTIVE' || runner.status == 'SUSPENDED') && !$(".matchTable" + MId + " .runner-row-" + runData.selectionId).hasClass("ball-running-msg")) {
                        $(".matchTable" + MId + " .runner-row-" + runData.selectionId).addClass("ball-running-msg").text((runner.status == 'SUSPENDED' ? runner.status : runData.status));
                    } else if ((runData.status == 'ACTIVE' && runner.status == 'OPEN') && $(".matchTable" + MId + " .runner-row-" + runData.selectionId).hasClass("ball-running-msg")) {
                        $(".matchTable" + MId + " .runner-row-" + runData.selectionId).removeClass("ball-running-msg").text('');
                    }
                }
            });
            if (multioddsMarket == MId) {

                $(".runner-row-" + MId + " .betting-blue .odds").text(back);
                $(".runner-row-" + MId + " .betting-pink .odds").text(lay);
                if (ismultibet == 1) {
                    if ($("#isback").val() == 1) {
                        $("#ShowBetPrice").val(lay);
                    } else {
                        $("#ShowBetPrice").val(back);
                    }
                }
            }

        } else {
            $(".matchClosedBox_" + MId).show();
            $(".matchOpenBox_" + MId).hide();
        }

    }

}

$(document).on('change', '.multiodds', function() {
    var mid = $(this).attr('data-id');
    var seq = $(this).attr('data-seq');
    if (mid != multioddsMarket) {
        $(".multi-row").hide();
        $(".multi-row strong").text('');
        if (multioddsMarket) {
            $(".matchTable" + multioddsMarket + " .multiodds").prop("checked", false);
        }
        multioddsMarket = mid;
        multiodds = [];
    }

    if (this.checked && multiodds.indexOf(this.value) == -1) {
        multiodds.push(this.value);
        multioddseq.push(seq);
        $(".runner-row-" + mid + " .events_odds").text(multioddseq.join('+'));

    }
    if (!this.checked && multiodds.indexOf(this.value) > -1) {
        var multiodds_key = multiodds.indexOf(this.value);
        multiodds.splice(multiodds_key, 1);
        multioddseq.splice(multiodds_key, 1);
        $(".runner-row-" + mid + " .events_odds").text(multioddseq.join('+'));

    }
    if (multiodds.length > 1) {
        $(".runner-row-" + mid).show();
    } else {
        $(".runner-row-" + mid).hide();
        $(".runner-row-" + mid + " .betting-blue .odds").text('');
        $(".runner-row-" + mid + " .betting-pink .odds").text('');
    }
});

function marketaction(data) {
    //  socket.emit('marketaction', setFormData(data));
    socket.emit('marketaction', data);
    //console.log(data)
}

function fancybox(fancy) {
    var box = '';
    $.each(fancy.fancyData, function(key, value) {

        box += `<div class="fancy_buttone">
        <div class="fancy-lays bet-button lay mark-lay" onclick="betfancy(` + fancy.MatchID +
            `,` + fancy.ID + `,` + fancy.MFancyID + `,1,` + key + `);">
            <strong id="LayNO_` + key + fancy.ID + `" >` + value.SessInptNo + `</strong>
            <div class="size">
                <span id="NoValume_` + key + fancy.ID + `">` + value.NoValume + `</span>
            </div>
        </div>
        <div class="fancy-backs bet-button back mark-back" onclick="betfancy(` + fancy.MatchID +
            `,` + fancy.ID + `,` + fancy.MFancyID + `,0,` + key + `);">
            <strong id="BackYes_` + key + fancy.ID + `" >` + value.SessInptYes + `</strong>
            <div class="size">
                <span id="YesValume_` + key + fancy.ID + `">` + value.YesValume + `</span>
            </div>
        </div>
    </div>`;


    });

    return box;
}


function fancyAdd(fancy, isAdd = 1) {
    if ($(".fancy_" + fancy.ID).length == 0) {
        fancyIDArr[fancy.market_id] = fancy;
        if (fancy.fancy_type == 'LM') {
            socket.emit('channel', fancy.market_id);
            socketodds.emit('channel-room', fancy.market_id);
            myarray.push(fancy.market_id.toString());
            fancyappend(fancy)
        } else {
            fmarket = fancy.market_id.split("-")[1];
            room = fmarket.split(".")[0];
            //console.log(room)
            socketodds.emit('channel-Fancy', room);
            fancyIDJoinM.push(room.toString());

            if (fancy_type == 'W') {
                //fancyappend(fancy)
                /* socket1.emit('joinRoom',room,function(fancyN,status){
                	//console.log(fancyN,status)
                	if(fancyN){			
                		fancyIDJoinM.push(room.toString());		
                		fancy = Object.assign(fancy,fancyN);	
                		if(fancy.headname)
                			fancy.HeadName = fancy.headname;
                		fancyappend(fancy)
                	}					
                }); */
            }
        }
    }
}

function fancyappend(fancy) {

    //console.log("consol.logfancy",fancy);

    var imgsrc = site_url + 'assets/images/matchodds-info-icon.png';
    var fancyhtml = `<div class="fancy-rows list-item fancy_` + fancy.ID + ` f_m_` + fancy.MatchID + ` f_m_` + fancy._id + `" data-id="` + fancy.ID + `">
	<div class="event-sports event-sports-name"><input type="hidden" value="` + fancy.fancy_type + `" class="fancyType` + fancy.ID + `" /><input type="hidden" value="` + fancy.market_id + `" class="fancyMID` + fancy.ID + `" />			
		<span class="event-name" onclick="getPosition(` + fancy.ID + `,0)" id="fancy_name` + fancy.ID + `">` + fancy.HeadName + `</span>
		
		<div class="match_odds-top-left min-max-mobile dropdown">
			<span class="dropdown-toggle" data-toggle="dropdown">	<img src="` + imgsrc + `" class="fancy-info-btn"></span>
			<ul class="dropdown-menu">
			  <li> Min:` + fancy.min_bet + ` </li>
			  <li>Max:` + fancy.max_bet + `</li>
			</ul>
		</div>	
				
		<!--<button class="btn btn-xs btn-danger" >Book</button> -->

		<span class="fancy-exp dot fancy_lia` + fancy.ID + `">` + (fancy.lia ? fancy.lia : 0) + `</span>
		`;
    if (userType1 < 4) {
        fancyhtml += `<button class="btn btn-xs btn-info" onclick="fancybets(` + fancy.ID + `)">Bets</button>`;
    }
    fancyhtml += `<span class="fancy_exposure" id="fancy_lib` + fancy.ID + `">`
    if (fancy.exposure > 0) {
        fancyhtml += fancy.exposure;
    }
    fancyhtml += `</span> 
	</div>
	<div class="fancy_div">`;
    if (fancy.fancy_type != 'LM') {
        fancyhtml += `<span class="fbox` + fancy.ID + `">`;
        fancyhtml += fancybox(fancy);
        fancyhtml += `</span>`;

    } else {
        fancyhtml += `<div class="fancy_buttone">
			<div class="fancy-lays bet-button lay mark-lay" onclick="betfancy(` + fancy.MatchID + `,` + fancy.ID + `,` + fancy.MFancyID + `,1,0);">
				<strong id="LayNO_0` + fancy.ID + `" >` + fancy.SessInptNo + `</strong>
				<div class="size">
					<span id="NoValume_0` + fancy.ID + `" >` + fancy.NoValume + `</span>
				</div>
			</div>
			<div class="fancy-backs bet-button back mark-back" onclick="betfancy(` + fancy.MatchID + `,` + fancy.ID + `,` + fancy.MFancyID + `,0,0);">
				<strong id="BackYes_0` + fancy.ID + `">` + fancy.SessInptYes + `</strong>
				<div class="size">
					<span id="YesValume_0` + fancy.ID + `">` + fancy.YesValume + `</span> 
				</div>
			</div>
		</div>`;
    }
    if (fancy.active == 0 || fancy.cron_status == 0) {
        if (fancy.DisplayMsg == '' || fancy.DisplayMsg == null) {
            fancy.DisplayMsg = 'BALL RUNNING';
        }
        fancyhtml += `<div class="show_msg_box_` + fancy.ID + ` ball-running-msg"><h1>` + fancy.DisplayMsg + `</h1></div></div>`;
    } else {
        fancyhtml += `<div class="show_msg_box_` + fancy.ID + `"></div></div>`;

    }

    if (fancy.fancy_type != 'LM') {
        if (fancy.min_bet) {
            fancyhtml += `<div class="fancy-stake"><i class="fas fa-info-circle fancyTouch"></i> <div class="myDIV">Min:` + fancy.min_bet + `  Max:` + fancy.max_bet + `</div></div></div>`;
        }
    } else {
        //console.log(fancy)
        if (fancy.max_stack_LM) {
            fancyhtml += `<div class="fancy-stake"><i class="fas fa-info-circle fancyTouch"></i> <div class="myDIV">Min:` + fancy.min_stack_LM + `  Max:` + fancy.MaxStake + `</div></div></div>`;
        }
    }

    fancyhtml += `<p class="fancy_message f_message` + fancy.ID + `" >`
    if (fancy.fancy_msg) {
        fancyhtml += fancy.fancy_msg
    }
    fancyhtml += `</p>`;
    if (fancy.fancy_type == 'LM') {
        $("#fancyLM_" + fancy.MatchID).append(fancyhtml);
    } else {
        fancy.fancy_type = 'API';
        if (fancy.f_type && fancy.f_type == 'fancy_over') {
            if (fancy.fancyData && fancy.fancyData.length > 0) {
                $("#fancyM" + "_" + fancy.MatchID).append(fancyhtml);
            }
        } else {
            if (fancy.group > 20) {
                fancy.group = 20;
            }
            $("#fancyAPI_" + fancy.MatchID + (fancy.group ? ' .f-prio' + fancy.group : ' .f-prio6')).append(fancyhtml);
        }
    }
    $("#fbox" + fancy.MatchID + (fancy.f_type ? 'M' : fancy.fancy_type)).show();
    //if(fancy.DisplayMsg=='SUSPENDED') $(".fancy_"+fancy.ID).hide();
    if (fancy.fancy_type != 'LM' && fancy_type == 'API' && fancy.fancydataupdate == 1) {
        $(".fancy_" + fancy.ID).hide();
    }
}


function fancyupdate(fancy) {

    //console.log(fancy.DisplayMsg,fancy.active,fancy.cron_status )
    if (fancy.DisplayMsg == 'SUSPENDED') {
        //$(".fancy_"+fancy.ID).remove();
        $(".fancy_" + fancy.ID).hide();
    } else if ($(".fancy_" + fancy.ID).length == 0) {
        if (fancyIDArr[fancy.market_id]) {
            //console.log(fancy.market_id)
            fancyappend(fancy)
        } else {
            fancyAdd(fancy);
        }


    } else if (fancy.active == 0) {
        $(".fancy_" + fancy.ID).hide();
    } else if (fancy.active == 1 && fancy.cron_status == 1) {
        $(".fancy_" + fancy.ID).show();
        $(".show_msg_box_" + fancy.ID).removeClass("ball-running-msg");
        $(".show_msg_box_" + fancy.ID).html(' ');
        if (fancy.fancy_type != 'LM') {
            /* setTimeout(function(){
            	$("#LayNO_0" +fancy.ID).parent().addClass('yello'); 
            	$("#BackYes_0" +fancy.ID).parent().addClass('yello'); 
            }, 10);
			
            setTimeout(function(){ $("#LayNO_0" +fancy.ID).parent().removeClass('yello'); }, 1000);				
            setTimeout(function(){ $("#BackYes_0"+fancy.ID).parent().removeClass('yello'); },1000); */
            $(".fbox" + fancy.ID).html(fancybox(fancy));
            if (fancy.message) {
                $(".fancy_" + fancy.ID + " .fancy_message").text(fancy.message);
            } else {
                $(".fancy_" + fancy.ID + " .fancy_message").text('');
            }
        } else {
            $("#fancy_name" + fancy.ID).text(fancy.HeadName);
            $("#LayNO_" + fancy.ID).text(fancy.SessInptNo);
            $("#BackYes_" + fancy.ID).text(fancy.SessInptYes);
            $("#NoValume_" + fancy.ID).text(fancy.NoValume);
            $("#YesValume_" + fancy.ID).text(fancy.YesValume);
        }
    } else {
        $(".fancy_" + fancy.ID).show();
        $(".show_msg_box_" + fancy.ID).addClass("ball-running-msg");
        if (fancy.DisplayMsg) {
            $(".show_msg_box_" + fancy.ID).html('<h1>' + fancy.DisplayMsg + '</h1>');
        } else {
            $(".show_msg_box_" + fancy.ID).html('<h1>Ball Started</h1>');
        }
    }
}

function closemarket(data) {
    var index = pstr.toString().indexOf(data.uId);
    if (index > -1) {
        if (data.ctype == 'sport') {

        } else if (data.ctype == 'match') {
            $(".matchrow-" + data.matchId).remove();

            matchIdarray.forEach(function(val, key) {
                if (val == data.matchId) {
                    closeBetBox(data.matchId, myarray[key]);
                }
            });
        } else if (data.ctype == 'market') {
            closeBetBox(data.matchId, data.marketId);
        } else if (data.ctype == 'fancy') {
            $(".fancy_" + data.marketId).remove();
        }
    }
}



function setCookieMatch(MarketId, matchId, isMatchOdds) {
    var pageCookie = Cookies.get('page-refresh');
    var pageRefresh = [];
    if (pageCookie) {
        pageCookie = JSON.parse(pageCookie);
        var index = pageCookie.findIndex(function(row) {
            return row.marketId == MarketId;
        });
        if (index == -1) {
            pageCookie.push({ marketId: MarketId, data: { MarketId: MarketId, matchId: matchId, isMatchOdds: isMatchOdds } });
        }
        pageRefresh = pageCookie;
        Cookies.set('page-refresh', pageRefresh);
    } else {
        pageRefresh.push({ marketId: MarketId, data: { MarketId: MarketId, matchId: matchId } });
        Cookies.set('page-refresh', pageRefresh);
    }


    function matchlist() {
        $("#fancyposition .title_popup span").text('Add Match');
        $("#fancyposition .modal-body").html($("#matchListClone").clone());
        $('#fancyposition').modal({ backdrop: 'static', keyboard: false });
    }

    function getMoreData(MarketId, matchId) {
        let formData = { MarketId: MarketId, matchId: matchId };
        $.ajax({
            url: site_url + 'matchdetail',
            data: setFormData(formData),
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function(output) {
                //
                output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                //console.log(output)
                match_count = parseInt(output.betCount.matchcount);
                fancy_count = parseInt(output.betCount.fancycount);
                unmatch_count = parseInt(output.betCount.unmatchcount);
                ///console.log(match_count,fancy_count,unmatch_count)
                $("#cnt_row").text("(" + (match_count + fancy_count) + ")");
                $("#cnt_row1").text("(" + unmatch_count + ")");
                $("#cnt_row2").text("(" + fancy_count + ")");
                getBets(betType);


                socketodds.emit('channel-room', MarketId);
                socket.emit('channel', matchId);
                socket.emit('channel', (matchId + '-' + userId1));


                MarketIDArr[MarketId] = matchId;
                MatchIDArr[matchId] = output.MatchOddsVolVal[0];
                MatchIDArr[matchId][MarketId] = '';
                output.marketData.forEach(function(arrayItem) {
                    MarketSelection(arrayItem.ID, matchId, arrayItem.market_type);
                    MarketIDArr[arrayItem.ID] = matchId;
                    if (arrayItem.market_type == 'B') {
                        socketodds.emit('channel-room', (arrayItem.ID));
                    } else {
                        manualarray.push(arrayItem.ID.toString());
                        socketodds.emit('channel-Market', (arrayItem.ID));
                        /* socket1.emit('joinMarket',arrayItem.ID,function(runner,status){
                            if(runner){
                                updateOdds(runner,1);
                            }
                        }); */
                    }
                });

                $.each(output.fancyData, function(indx, fancy) {
                    fancyAdd(fancy);
                });
                if (userType1 == 4) {
                    getBets(4);
                }
                var TvAnimated = '';
                //https://betproexch.com/Common/LiveScoreCard?id='+MarketId
                if (output.MatchOddsVolVal[0]['SportID'] == 4) {
                    TvAnimated = '<iframe id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling="" style="overflow: scroll; width: 100%; max-width: 100%  max-height: 247px;" src="https://betproexch.com/Common/LiveScoreCard?id=' + MarketId + '" height="188"></iframe>';
                } else if (output.MatchOddsVolVal[0]['SportID'] == 1) {
                    TvAnimated = '<iframe id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling="" style="overflow: scroll; width: 100%; max-width: 100%  max-height: 247px;" src="https://betproexch.com/Common/LiveScoreCard?id=' + MarketId + '&width=334&height=190&allowPopup=true&contentType=viz&statsToggle=hide&contentOnly=true%22"  height="188"></iframe>';
                } else if (output.MatchOddsVolVal[0]['SportID'] == 2) {
                    TvAnimated = '<iframe id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling="" style="overflow: scroll; width: 100%; max-width: 100%  max-height: 247px;" src="https://betproexch.com/Common/LiveScoreCard?id=' + MarketId + '&width=334&height=188&allowPopup=true&contentType=viz&statsToggle=hide&contentOnly=true%22"  height="188"></iframe>';
                }
                //console.log(TvAnimated)
                if (TvAnimated)
                    $(".MatchLiveTvHideShow").html(TvAnimated);
            }
        });
    }

    function setFormData(formdata) {

        if (typeof formdata == 'string' || typeof formdata == 'number') {
            if (typeof formdata != 'string') {
                formdata = String(formdata)
            }
            var crypt = CryptoJS.AES.encrypt(formdata, CRYPTPASS, {
                format: CryptoJSAesJson
            }).toString();
            return crypt;
        } else {
            var crypt = CryptoJS.AES.encrypt(JSON.stringify(formdata), CRYPTPASS, {
                format: CryptoJSAesJson
            }).toString();
            //return {_key: formdata,compute: Cookies.get('_compute')};
            return { _key: crypt, compute: Cookies.get('_compute') };
        }

    }

    function closeBetBox(matchId, MarketId) {
        var index = myarray.indexOf(MarketId.toString());
        if (index > -1) {
            myarray.splice(index, 1);
            matchIdarray.splice(index, 1);
            socket.emit('leaveRoom', (MarketId));
            var index = matchIdarray.indexOf(matchId.toString());
            if (index == -1) {
                socket.emit('leaveRoom', (matchId));
                if (userType1 < 4) socket.emit('leaveRoom', (matchId + '-' + userId1));
            }
        }
        if (matchId == $('#matchId').val()) {
            ClearAllSelection(1);
        }
        MId = MarketId.replace('.', '');
        $(".matchBoxs_" + MId).html('');
        if (currentBetMarketId == MarketId) {
            $("#MatchUnMatchBetaData").html('');
            $("#accountView").html('');
        }
        if (myarray.length == 0) {
            currentBet = '';
            currentBetMarketId = ''
            $(".matchBox").hide();
            upcommingMatchData();
        } else {
            currentBet = matchIdarray[0];
            currentBetMarketId = myarray[0];
            getBets(4);
        }

        /*For removing the market if from cookies for page refresh on dashboard*/
        var pageCookie = Cookies.get('page-refresh');
        if (pageCookie) {
            pageCookie = JSON.parse(pageCookie);
            var index = pageCookie.findIndex(function(row) {
                return row.marketId == MarketId;
            });
            if (index == 0) {
                pageCookie.splice(index, 1);
                Cookies.set('page-refresh', pageCookie);
            }
        }
    }


    function getValColor(val) {
        if (val == '' || val == null || val == 0)
            return '#000000';
        else if (val > 0)
            return '#007c0e';
        else
            return '#ff0000';
    }

    function fancyposition(id) {
        $.ajax({
            url: site_url + 'session-position',
            data: setFormData({ id: id }),
            type: 'post',
            dataType: 'json',
            success: function(value) {
                value = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(value), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                $(".fancy_lia" + id).text(value.liability);
            }
        });
    }

    function marketPosition(MatchId, MarketID, oddeven = 0) {

        // if ($(".matchOpenBox_" + MId).length) {
        $.ajax({
            url: site_url + 'marketposition',
            data: setFormData({ MarketId: MarketID, matchId: MatchId, userId: userId1, userType: userType1, oddeven: oddeven }),
            type: 'post',
            dataType: 'json',
            success: function(value) {
                value = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(value), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if (gameType == 'market') {
                    var MId = MarketID.replace('.', '');
                    if (value.RunnerValue.length == 0) {
                        $(".matchOpenBox_" + MId + " .runner_amount").text(0);
                    } else {
                        $.each(value.RunnerValue, function(key, positionN) {
                            var newVal1 = Math.round(parseFloat(positionN.winValue) + parseFloat(positionN.lossValue), 2);
                            var selectionId = positionN.SelectionId;
                            $("#" + selectionId + "_maxprofit_loss_runner_" + MId).text(Math.abs(newVal1)).css('color', getValColor(newVal1));


                        });
                    }
                } else {
                    $.each(value.OtherRunnerValue, function(key, value) {
                        $("#exppair" + value.team).text(value.exp);
                    });
                    if (value.RunnerValue.length == 0) {
                        $(".runner_amount").text(0);
                    } else {
                        $.each(value.RunnerValue, function(key, positionN) {
                            var newVal1 = Math.round(parseFloat(positionN.winValue) + parseFloat(positionN.lossValue));
                            $("#maxprofit_loss_runner_" + key).text(Math.abs(newVal1)).css('color', getValColor(newVal1));
                        });

                    }
                }
            }
        });
        //}
    }


    // function goBack() {


    //     window.history.back();
    // }

    function updateTerm() {
        $.ajax({
            url: site_url + 'acceptterms',
            success: function(output) {
                $('#myModal_popup').modal('hide');
            }
        });
    }

    function FavFunc(matchid, marketid) {
        $.ajax({
            url: site_url + 'favorite',
            type: "POST",
            data: { matchid: matchid, marketid: marketid, 'compute': Cookies.get('_compute') },
            success: function(output) {
                $("#fav" + matchid).html(output);
            }
        });
    }

    function getPosition(fancyid, key) {
        let formData = { userId1: userId1, fancyid: fancyid, typeid: 2, yesval: $("#BackYes_" + key + fancyid).text(), noval: $("#LayNO_" + key + fancyid).text(), usertype: userType1 };
        $.ajax({
            url: site_url + 'session-book',
            data: setFormData(formData),
            type: "POST",
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                $("#fancyposition .modal-body").html(output.html);
                $('#fancyposition').modal('toggle');
            }
        });
    }

    function deleteunMatchOdds(MstCode, UserId) {
        let formData = { MstCode: MstCode, UserId: UserId };
        $.ajax({
            url: site_url + 'remove-get-betting',
            data: setFormData(formData),
            type: 'post',
            dataType: 'json',
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if (output.error == '0') {
                    jQuery("#user_row_" + MstCode).remove(); //Deleted Successfully ...
                    new PNotify({
                        title: 'Success',
                        text: output.message,
                        type: 'success',
                        styling: 'bootstrap3',
                        delay: 3000
                    });
                } else {
                    new PNotify({
                        title: 'Error',
                        text: output.message,
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000
                    });
                }

                $('#fancyposition').modal('hide');
            }
        });
    }




    function getUserPosition(matchId, marketId) {
        slide = 1;
        let formData = { matchId: matchId, marketId: marketId };
        $.ajax({
            url: site_url + 'marketstatus',
            data: setFormData(formData),
            type: 'post',
            dataType: 'html',
            success: function(Position) {
                Position = $.parseJSON(CryptoJS.AES.decrypt(Position, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if ($("#getUserPosition").length == 0) {
                    $("#fancyposition .title_popup span").html('Market Position');
                    $("#fancyposition .modal-body").html(Position);
                    $('#fancyposition').modal({ backdrop: 'static', keyboard: false });
                } else {
                    $("#getUserPosition").html(Position);
                }
            }
        });
    }

    function getParentUserPosition(userId, userTypeId, matchId, marketId) {
        slide = 1;
        PositionuserId = userId;
        PositionuserTypeId = userTypeId;
        $.ajax({
            url: site_url + 'marketstatus',
            data: setFormData({ userId: userId, userTypeId: userTypeId, matchId: matchId, marketId: marketId }),
            type: 'post',
            dataType: 'html',
            success: function(Position) {
                Position = $.parseJSON(CryptoJS.AES.decrypt(Position, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if ($("#getUserPosition").length == 0) {
                    $("#fancyposition .title_popup span").html('Market Position <button class="btn btn-xs btn-primary pull-right" onclick=getUserPosition(' + matchId + ',"' + marketId + '")>Back</button>');
                    $("#fancyposition .modal-body").html(Position);
                    $('#fancyposition').modal({ backdrop: 'static', keyboard: false });
                } else {
                    $("#getUserPosition").html(Position);
                }
            }
        });
    }



    function getCurrentBets(MatchId, MarketId) {
        currentBet = MatchId;
        currentBetMarketId = MarketId;
        $('.betdata.active a').click();
    }




    function getoddVolumn(volmn, limit) {
        return (parseFloat(volmn) * parseFloat(limit)).toFixed(2);
    }

    function upcommingMatchData() {
        var urlPage = document.URL;
        //  abortAjax();
        $.ajax({
            url: site_url + 'dashboardView',
            data: { url: urlPage },
            type: 'get',
            dataType: 'html',
            success: function(output) {
                $("#UpCommingData").show();
                $(".side-bar-thumb").show();
                $("#UpCommingData").html(output);
                $("#MatchOddInfo").html('');
            }
        });
    }


    function GetScoreApi(data) {
        if (Array.isArray(data.scoreData)) {
            showScore = data.scoreData[0];
        } else {
            showScore = data.scoreData;
        }
        //  console.log(showScore)
        var html = '';

        if (data.scoreType == 2) {
            showScore = showScore.result;

            /*  html = '<div class="cricket_score_board"> ';
             if (showScore.battingTeam) {
               html += '<div class="match-name-score"> ' + showScore.battingTeam.name + ' </div><div class="main-score"><span class="strong_score">' + showScore.battingTeam.score + '/' + showScore.battingTeam.wickets + '</span><span class="current-over"> (' + showScore.battingTeam.overs + '.' + showScore.battingTeam.balls + ')</span></div><div class="t_r_c"><div class="target"><span class="block_rr">Target</span><span class="rr">'+(showScore.battingTeam.target ? showScore.battingTeam.target : '-')+'</span></div><div class="required_rr"><span class="block_rr">Req RR</span><span class="rr">' + (showScore.battingTeam.requiredRunRate ? showScore.battingTeam.requiredRunRate : '-') + '</span></div><div class="current_rr"><span class="block_rr">Cur RR</span><span class="rr">' + showScore.battingTeam.runRate + '</span></div></div><div class="matchCommentary"> ' + showScore.matchCommentary + ' </div>';
               if (showScore.lastOver) {
                 html += ' <div class="match_over"><ul><span class="overtext">over(' + showScore.lastOver.overNumber + ')</span>';
                 $.each(showScore.lastOver.balls, function (key, balls) {
                   html += ' <li class="common ball_' + balls.value + '">' + balls.value + '</li>';
                 });
                 html += '</ul></div>  ';
               }
               if (showScore.currentOver) {
                 html += '<div class="match_over"><ul><span class="overtext">over/.' + showScore.currentOver.overNumber + ':</span>';
                 $.each(showScore.currentOver.balls, function (key, balls) {
                   html += ' <li  class="common ball_' + balls.value + '">' + balls.value + '</li>';
                 });
                 html += '</ul></div>';
               }
             }
             html += ' </div>'; */
            var html = '<div class="score_main"> <div class="cricket-score"> ';
            // current bet team
            var active1 = '';
            if (showScore.first_team == showScore.battingTeam.name) {
                active1 = 'active';
            }
            var active2 = '';
            if (showScore.second_team == showScore.battingTeam.name) {
                active2 = 'active';
            }
            html += '<div class="row"><div class="col-md-4 col-xs-4 col"><div class="teamtype"> <img class="' + active1 + '" src="/assets/images/cricket-bat.svg"> <p class="matchName">' + showScore.first_team + '</p></div></div>';
            //score/run
            html += '<div class="col-md-4 col-xs-4 col"><div class="target-score"> <span class="currunt_sc">' + showScore.battingTeam.score + '-' + showScore.battingTeam.wickets + '</span> <span class="currunt_over">(' + showScore.battingTeam.overs + '.' + showScore.battingTeam.balls + ')</span> <span class="score-btn" onclick="showScoreBoard(' + showScore.eventId + ')">Scoreboard</span></div></div>';
            // second team
            html += '<div class="col-md-4 col-xs-4 col"><div class="teamtype"> <img  class="' + active2 + '" src="/assets/images/cricket-bat.svg"> <p class="matchName">' + showScore.second_team + '</p></div></div></div>';
            html += '<div class="score-footer">';
            //showing betsman data 	   $("#socreboard").modal('show');
            html += ' <div class="item-score batsman"><ul>';
            if (showScore.batsName) {
                $.each(showScore.batsName, function(key, batsMan) {
                    if (batsMan.onStrike === true) {
                        html += '<li class="active"> <img src="/assets/images/cricket-icons.svg"> ' + batsMan.name + ' ' + batsMan.runs + '(' + batsMan.balls + ')</li>';
                    } else {
                        html += '<li class=""><img src="/assets/images/cricket-icons.svg"> ' + batsMan.name + ' ' + batsMan.runs + '(' + batsMan.balls + ')</li>';
                    }
                });
            }
            //showing bowler data 
            if (showScore.bowlerNamesArr) {
                if (showScore.bowlerNamesArr[0] && showScore.bowlerNamesArr[0].bowlerName) {
                    html += '<li class=""><img src="/assets/images/cricket-ball.svg"> ' + showScore.bowlerNamesArr[0].bowlerName + ' (' + showScore.bowlerNamesArr[0].overs + '-' + showScore.bowlerNamesArr[0].runs + '-' + showScore.bowlerNamesArr[0].wickets + ' )</li>';
                }
            }
            html += ' </ul> </div>';
            //showing OVER data
            html += '<div class="item-score score-over-fter">';
            if (showScore.lastOver) {
                html += '<div class="over-status"> <div class="score-over"> <ul><li><p>Over </p></li>';
                $.each(showScore.lastOver.balls, function(key, balls) {
                    html += '<li class="' + balls.value + '-color six-balls"><span>' + balls.value + '</span></li> '
                });
                html += '</ul> </div></div>'
            }
            html += '<div class="commantry-status"><span class="commantry">' + showScore.matchCommentary + '</span></div></div></div>';
            html += '</div></div>';

            //  console.log(html);
        } else if (showScore.eventTypeId == 2) {

            var html = '<div class="matchScore score_area"> <div class="score_team">';

            if (showScore.score.home) {
                html += '<div class="soccer-line"><div class="home-runner">' + showScore.score.home.name + '</div>';
                html += ' <div class="score-compontent">';
                var homelength = showScore.score.home.gameSequence.length;
                var k;
                for (k = 0; k < 5; k++) {
                    var is_game = k - 1;
                    if (k in showScore.score.home.gameSequence) {
                        html += '<span class="ui-set-home ">' + showScore.score.home.gameSequence[k] + ' </span>';
                    } else if (k == 0 || (is_game in showScore.score.home.gameSequence)) {
                        html += '<span class="ui-set-home">' + showScore.score.home.games + ' </span>';
                    } else {
                        html += '<span class="ui-set-home"></span>';
                    }

                }

                html += '<div class="ui-set-home points-sc">' + showScore.score.home.score + '</div> </div><span class="cell"></span><span class="cell">' + showScore.score.home.doubleFaults + '</span><span class="ui-set-home">' + showScore.score.home.serviceBreaks + '</span></div>';
            }
            if (showScore.score.away) {
                html += '<div class="soccer-line"><div class="home-runner">' + showScore.score.away.name + '<span class="dot-cls">â€¢</span>  </div>';
                html += '<div class="score-compontent">';

                var i;
                for (i = 0; i < 5; i++) {
                    var is_game_away = i - 1;
                    if (i in showScore.score.away.gameSequence) {
                        html += '<span class="ui-set-home awat">' + showScore.score.away.gameSequence[i] + ' </span>';
                    } else if (i == 0 || (is_game_away in showScore.score.away.gameSequence)) {
                        html += '<span class="ui-set-home awat">' + showScore.score.away.games + ' </span>';
                    } else {
                        html += '<span class="ui-set-home awat"></span>';
                    }

                }
            }
            html += '<div class="ui-set-home points-sc">' + showScore.score.away.score + '</div></div><span class="cell"></span><span class="cell">' + showScore.score.away.doubleFaults + '</span><span class="ui-set-home">' + showScore.score.away.serviceBreaks + '</span></div><div class="description-sc"><div class="cell">1</div>';

            html += '<div class="cell">2</div><div class="cell">3</div><div class="cell">4</div><div class="cell">5</div><div class="cell">points</div><div class="cell">Aces</div><div class="cell">Double Faults</div><div class="cell">Service Breaks</div></div><div class="clearfix"></div></div>';
            if (showScore.score.currentSet) {
                html += '<div class="current_set">Current Set: ' + showScore.score.currentSet + '</div>';
            }
            html += '</div>';
        } else if (showScore.eventTypeId == 1) {
            /* html = '<div class="soccer-score"><div class="soccer-line"><div class="home-runner">' + showScore.score.home.name + '</div><div class="score-compontent"><div class="soccer-set">' + showScore.score.home.score + '</div><div class="soccer-set">' + showScore.score.away.score + '</div></div></div><div class="soccer-line"><div class="home-runner">' + showScore.score.away.name + '</div><div class="score-compontent"><div class="soccer-set">' + showScore.score.away.score + '</div></div></div></div>'; */

            var firstRound = (showScore.score && showScore.timeElapsed && showScore.timeElapsed < 45) ? ((showScore.timeElapsed / 45) * 100) : 100;
            var secRound = (showScore.score && showScore.timeElapsed && showScore.timeElapsed > 45) ? ((showScore.timeElapsed / 90) * 100) : 0;
            var timeline = [];
            var timeLine = [];
            var timeLine2 = [];
            if (showScore.score && showScore.updateDetails) {
                var firstHalf = true;
                showScore.updateDetails.map((timeline) => {
                    //console.log("footballl",timeline);
                    //  let clsName = (showScore.teams[0] == timeline.teamName) ? 'top' : 'bottom';
                    let clsName = 'bottom';
                    if (timeline.type == "FirstHalfEnd") {
                        firstHalf = false;

                    }

                    if (timeline.type == "YellowCard" && firstHalf) {
                        timeLine.push('<span style="left:' + ((timeline.elapsedRegularTime / 45) * 100) + '%"class="' + timeline.type + ' ' + clsName + '"><div class="score-tooltip"><span class=' + timeline.type + '></span><span class="match-time-sccore">' + timeline.elapsedRegularTime + '</span>' + timeline.teamName + '</div></span>');
                    }
                    if (timeline.type == "Goal" && firstHalf) {
                        timeLine.push('<span style="left:' + ((timeline.elapsedRegularTime / 45) * 100) + '%"class="' + timeline.type + ' ' + clsName + '"><div class="score-tooltip"><span class=' + timeline.type + '></span><span class="match-time-sccore">' + timeline.elapsedRegularTime + '</span>' + timeline.teamName + '</div></span>');
                    }

                    if (timeline.type == "YellowCard" && !firstHalf) {
                        timeLine2.push('<span style="left:' + (((timeline.elapsedRegularTime - 45) / 45) * 100) + '%"class="' + timeline.type + ' ' + clsName + '"><div class="score-tooltip"><span class=' + timeline.type + '></span><span class="match-time-sccore">' + timeline.elapsedRegularTime + '</span>' + timeline.teamName + '</div></span>');
                    }
                    if (timeline.type == "Goal" && !firstHalf) {
                        timeLine2.push('<span style="left:' + (((timeline.elapsedRegularTime - 45) / 45) * 100) + '%"class="' + timeline.type + ' ' + clsName + '"><div class="score-tooltip"><span class=' + timeline.type + '></span><span class="match-time-sccore">' + timeline.elapsedRegularTime + '</span>' + timeline.teamName + '</div></span>');
                    }
                });
            }
            //	console.log("rounds",firstRound,secRound);/
            var html = '<div class="soccer-socre"><div class="soccer-team-name"><div class="soccer-team-group">' + showScore.score.home.name + '<span class="soccer-team-goals"> ' + showScore.score.home.score + '-' + showScore.score.away.score + '</span> ' + showScore.score.away.name + '</div> <span class="score-goal time-goal">' + showScore.elapsedRegularTime + ' <span>(HT ' + showScore.score.home.halfTimeScore + '-' + showScore.score.away.halfTimeScore + ')</span></span></div>';
            html += '<div class="soccer-team-progress"> <div class="progress progress-match"> <div class="progress-bar" role="progressbar" style="width:' + firstRound + '%"> <div class="timeline">' + timeLine + '</div></div></div><div class="progress progress-match"> <div class="progress-bar" role="progressbar" style="width:' + secRound + '%"> <div class="timeline">' + timeLine2 + '</div></div></div></div>';
            html += '</div>';



        }

        $("#matchScore_" + data.match_id).html(html);
    }


    function setChipStackVal() {
        $(".errmsg").text('');
        $("#Name1").val($(".chipName1").text());
        $("#Name2").val($(".chipName2").text());
        $("#Name3").val($(".chipName3").text());
        $("#Name4").val($(".chipName4").text());
        $("#Name5").val($(".chipName5").text());
        $("#Name6").val($(".chipName6").text());
        $("#Value1").val($(".chipName1").val());
        $("#Value2").val($(".chipName2").val());
        $("#Value3").val($(".chipName3").val());
        $("#Value4").val($(".chipName4").val());
        $("#Value5").val($(".chipName5").val());
        $("#Value6").val($(".chipName6").val());
    }

    function checkLogin() {
        $.ajax({
            url: site_url + 'is_logged',
            dataType: 'JSON',

            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                if (output.logout == 1) {
                    location.reload();
                } else {
                    $("#liveCommentary").text(output.val);
                }
            }
        });
    }

    function closeTv() {
        $('#tv-box-popup').hide();
    }

    function showTv(matchId, REMOTE_ADDR, sportId = '') {
        //var liveTvUrl =  site_url+'tvsetting/showTvFeedApi';
        /* var liveTvUrls =  site_url+'tvsetting/showTvFeedApi';
		if(sportId == 7){
		var TvAnimated = '<div id="tv-box-popupheader"><button type="button" id="close" onclick="closeTv();">x</button><iframe id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling="no" style="overflow: hidden; width: 100%; height: 247px;" src="'+liveTvUrls+'/'+matchId+'/'+REMOTE_ADDR+'"></iframe></div>';   
		  
	  }else{
		var TvAnimated = '<div id="tv-box-popupheader"><button type="button" id="close" onclick="closeTv();">x</button><iframe id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling="no" style="overflow: hidden; width: 100%; height: 247px;" src="'+liveTvUrls+'/'+matchId+'/'+REMOTE_ADDR+'"></iframe></div>'; 
	  } */
        var TvAnimated = '<button type="button" id="close" onclick="closeTv();">x</button><iframe id="mobilePlayer" allowfullscreen="true" frameborder="0" scrolling="no" style="overflow: hidden; width: 100%; height: 247px;" src="http://139.59.41.232/9e79154e7f6aa8160b6c77944135e8ca/Nstreamapi.php?chid=' + sportId + '&ip=' + REMOTE_ADDR + '"></iframe>';
        $('#tv-box-popup').show();
        $("#tv-box-popup").html(TvAnimated);
    }

    function viewAllMatch() {

        window.location.href = site_url + 'match-bets/' + currentBet + '/' + currentBetMarketId + '/2';
    }
    /* function getBetcount(){
    	let formData = {marketId: currentBetMarketId, matchId: currentBet};
    	$.ajax({
    		url: site_url + 'betlistCount',
    		data: setFormData(formData),
    		type: 'POST',
    		dataType: 'JSON',
    		success: function (output) {
    			output = $.parseJSON(CryptoJS.AES.decrypt(JSON.stringify(output), CRYPTPASS, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
    			//console.log(output)
    			$("#cnt_row").text( "("+output.totalcount+")");
    			$("#cnt_row1").text("("+output.unmatchcount+")");
    			$("#cnt_row2").text("("+output.fancycount+")");
    		}
    	});
    } */
    function getDataByType(el, Type) {
        if (currentBetMarketId != '' && currentBet != '' && Type < 5) {
            $('.nav-item').removeClass("active");
            $(el).parent('li').addClass("active");
            betType = Type;
            $(".accountViewcls").hide();
            $(".tableid" + betType).show();
            /* if (userType1 == 4) {
            	if(betType !=0){
            		$(".all-matchodds").hide();
            		$("#MatchUnMatchBetaData").show();
            	}else{
            		$(".all-matchodds" ).show();
            		$("#MatchUnMatchBetaData").hide();          
            	}		
            } */
            //getBets(betType)
            //if(isMobile == false || (isMobile == true && userType1 == 4 && betType!=0) || (isMobile == true && userType1 < 4)){
            //if( userType1 < 4){

            //}

        }
    }

    function getBets(Type) {
        let formData = { marketId: currentBetMarketId, matchId: currentBet, Type: Type, match_count, unmatch_count, fancy_count };
        $.ajax({
            url: site_url + 'betlist',
            data: setFormData(formData),
            type: 'POST',
            dataType: 'html',
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                $("#getUserPosition").hide();
                $("#MatchUnMatchBetaData").show();
                $("#MatchUnMatchBetaData").html(output);
            }
        });
    }

    $(document).ready(function() {
        //   websocketM();
        websocket();
        if (userType1 < 4) {
            /* setInterval(function () {           
         $('.betdata.active a').click();
        }, 5 * 1000); 
		 */
            /*setInterval(function () {           
         getBetcount()
        }, 5 * 1000); */
        }
        /* setInterval(function () {
            checkLogin();
        }, 20 * 1000);  */

        $(document).on("click", "a[data-color]", function() {
            var color = $(this).attr('data-color');
            $.ajax({
                url: site_url + 'change-site-color',
                data: setFormData({ color: color }),
                type: 'post',
                dataType: 'html',
                success: function(output) {
                    location.reload();
                    //output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
                }
            });

        });

        $(document).on("click", "#updateUserChip", function() {
            var Name1 = $("#Name1").val();
            var Name2 = $("#Name2").val();
            var Name3 = $("#Name3").val();
            var Name4 = $("#Name4").val();
            var Name5 = $("#Name5").val();
            var Name6 = $("#Name6").val();
            var Value1 = parseInt($("#Value1").val());
            var Value2 = parseInt($("#Value2").val());
            var Value3 = parseInt($("#Value3").val());
            var Value4 = parseInt($("#Value4").val());
            var Value5 = parseInt($("#Value5").val());
            var Value6 = parseInt($("#Value6").val());
            var i = 0;
            $(".form-control").removeClass("bordar_highlight");
            if (Name1 == '') {
                $("#Name1N").text('Please Enter Chip Name');
                $("#Name1").addClass("bordar_highlight");
                i = 1;
            } else if (Name1.length < 2) {
                $("#Name1N").text('Chip Name must be 4 charecters');
                $("#Name1").addClass("bordar_highlight");
                i = 1;
            }
            if (Name2 == '') {
                $("#Name2N").text('Please Enter Chip Name');
                $("#Name2").addClass("bordar_highlight");
                i = 1;
            } else if (Name2.length < 2) {
                $("#Name2N").text('Chip Name must be 4 charecters');
                $("#Name2").addClass("bordar_highlight");
                i = 1;
            }
            if (Name3 == '') {
                $("#Name3N").text('Please Enter Chip Name');
                $("#Name3").addClass("bordar_highlight");
                i = 1;
            } else if (Name3.length < 2) {
                $("#Name3N").text('Chip Name must be 4 charecters');
                $("#Name3").addClass("bordar_highlight");
                i = 1;
            }
            if (Name4 == '') {
                $("#Name4N").text('Please Enter Chip Name');
                $("#Name4").addClass("bordar_highlight");
                i = 1;
            } else if (Name4.length < 2) {
                $("#Name4N").text('Chip Name must be 4 charecters');
                $("#Name4").addClass("bordar_highlight");
                i = 1;
            }
            if (Name5 == '') {
                $("#Name5N").text('Please Enter Chip Name');
                $("#Name5").addClass("bordar_highlight");
                i = 1;
            } else if (Name5.length < 2) {
                $("#Name5N").text('Chip Name must be 4 charecters');
                $("#Name5").addClass("bordar_highlight");
                i = 1;
            }
            if (Name6 == '') {
                $("#Name6N").text('Please Enter Chip Name');
                $("#Name6").addClass("bordar_highlight");
                i = 1;
            } else if (Name6.length < 2) {
                $("#Name6N").text('Chip Name must be 4 charecters');
                $("#Name6").addClass("bordar_highlight");
                i = 1;
            }
            if (Value1 == '' || isNaN(Value1)) {
                $("#Value1N").text('Please Enter Chip Value');
                $("#Value1").addClass("bordar_highlight");
                i = 1;
            }
            if (Value2 == '' || isNaN(Value2)) {
                $("#Value2N").text('Please Enter Chip Value');
                $("#Value2").addClass("bordar_highlight");
                i = 1;
            }
            if (Value3 == '' || isNaN(Value3)) {
                $("#Value3N").text('Please Enter Chip Value');
                $("#Value3").addClass("bordar_highlight");
                i = 1;
            }
            if (Value4 == '' || isNaN(Value4)) {
                $("#Value4N").text('Please Enter Chip Value');
                $("#Value4").addClass("bordar_highlight");
                i = 1;
            }
            if (Value5 == '' || isNaN(Value5)) {
                $("#Value5N").text('Please Enter Chip Value');
                $("#Value5").addClass("bordar_highlight");
                i = 1;
            }
            if (Value6 == '' || isNaN(Value6)) {
                $("#Value6N").text('Please Enter Chip Value');
                $("#Value6").addClass("bordar_highlight");
                i = 1;
            }
            if (i == 0) {
                var formData = $("#stockez_add").serializeJSON();
                $.ajax({
                    type: "POST",
                    url: site_url + 'update-stake',
                    data: setFormData(formData),
                    cache: false,
                    dataType: 'json',
                    success: function(output) {
                        if (output.status.error == 0) {
                            $("#addUserMsg").show();
                            $("#addUserMsg").html("<span class='succmsg'>" + output.status.message + "</span>");
                            $("#addUserMsg").fadeOut(3000);
                            $(".chipName1").text(Name1);
                            $(".chipName2").text(Name2);
                            $(".chipName3").text(Name3);
                            $(".chipName4").text(Name4);
                            $(".chipName5").text(Name5);
                            $(".chipName6").text(Name6);
                            $(".chipName1").val(Value1);
                            $(".chipName2").val(Value2);
                            $(".chipName3").val(Value3);
                            $(".chipName4").val(Value4);
                            $(".chipName5").val(Value5);
                            $(".chipName6").val(Value6);
                            setTimeout(function() {
                                $("#addUser").modal('hide');
                            }, 3000);
                        } else {
                            $("#addUserMsg").show();
                            $("#addUserMsg").html("<span class='errmsg'>" + output.status.message + "</span>");
                            $("#addUserMsg").fadeOut(3000);
                        }
                    }
                });
            }
            i++;
        });


        /*From Left.php*/
        $('.dropdown-submenu a.test').on("click", function(e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
        var currentNavIndex = 0;
        $('#my-nav .nav li').click(function() {
            //console.log('myindex',$(this).index()); 
        });
        /*End Left.php*/
        /*for end cookie for refresh page dashboard*/
        $(".endcooki").on("click", function() {
            if (Cookies.get('page-refresh')) {
                Cookies.remove('page-refresh');
            }
        });

    });
    /*From Left.php*/
    function openNav() {
        document.getElementById("lefttSidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("lefttSidenav").style.width = "0";
    }


    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    /*From matchodds.php*/
    function dragElement(elmnt) {
        var pos1 = 0,
            pos2 = 0,
            pos3 = 0,
            pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            /* if present, the header is where you move the DIV from:*/
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            /* otherwise, move the DIV from anywhere inside the DIV:*/
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            /* stop moving when mouse button is released:*/
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }

    function matchInterval(matchId, datetime, date) {
        var timet = convert_to_24h(datetime);
        //alert((timet.replace(',',':')).replace(',',':'));
        var timetmp = (timet.replace(',', ':')).replace(',', ':');
        // Set the date we're counting down to  Sep 5, 2018 15:37:25
        var dat = date + ' ' + timetmp;
        var countDownDate = new Date(dat).getTime();
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get todays date and time
            var now = new Date().getTime();
            // Find the distance between now an the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            document.getElementById("demo_" + matchId).innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";
            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo_" + matchId).innerHTML = "00";
            }
        }, 1000);
    }

    function convert_to_24h(time_str) {
        // Convert a string like 10:05:23 PM to 24h format, returns like [22,5,23]
        var time = time_str.match(/(\d+):(\d+):(\d+) (\w)/);
        var hours = Number(time[1]);
        var minutes = Number(time[2]);
        var seconds = Number(time[3]);
        var meridian = time[4].toLowerCase();
        if (meridian == 'p' && hours < 12) {
            hours += 12;
        } else if (meridian == 'a' && hours == 12) {
            hours -= 12;
        }
        return [hours, minutes, seconds].toString();
    }
    /*End From matchodds.php*/

    /*Dashboard page*/
    function changetv(id, sr) {
        /* if(sr==1 || $(".MatchTvHideShow").is(':empty'))
        {
            $.ajax({
                url: site_url+'dashboard/gettv/'+id,
                dataType: 'html', 
                success: function(output)
                {
                    $(".MatchTvHideShow").html(output);
                }
            }); 
        } */
    }
    $(function() {
        $('.close ,.closebtn').click(function() {
            $('#changeUserPassword').hide();
        });
    });
    /* function websocketM()
    {   
        socket1 = io.connect(socketurlM ,{transports: [ 'websocket' ],forceNew: true});
        socket1.on('connect', function() {  
            $.each(fancyIDJoinM, function(key,id) {     
                socket1.emit('joinRoom',id,function(data,status){           
                });
            });
            $.each(manualarray, function(key,id) {      
                socket1.emit('joinMarket',id,function(data,status){          
                });
            }); 
        }); 
    	if(fancy_type =='W'){
    		socket1.on('fancyUpdates', function(fancy) 
    		{   
    			
    			if (fancy.market_id in fancyIDArr) 
    			{       
    				
    				fancyupdate(Object.assign(fancyIDArr[fancy.market_id],fancy));          
    			}
    		}); 
    	}
    	
    	socket1.on('fancyResult', function(ID) 
        {   
             $(".f_m_" + ID).remove();    
             
        });
        socket1.on('market_data', function(runner) 
        {   
            updateOdds(runner);     
            
        }); 
        socket1.onerror = function(ev) {
            console.log('error'+ev);        
        }       
        socket1.onclose = function(ev) {
            console.log('close'+ev);    
        };
    } */
    function lobbylink(game = 1) {
        if (game == 4) {
            var url = site_url + 'livegames';
        } else if (game == 3) {
            var url = site_url + 'gameLink';
        } else {
            var url = site_url + 'gamecasino?gameID=' + game;
        }
        $.ajax({
            url: url,
            dataType: 'JSON',
            success: function success(output) {
                console.log(output)
                if (output.lobbylink != '') {
                    window.open(output.lobbylink, '_blank');
                } else {
                    alert(output.message);
                }
            }
        });
    }

    function fancybets(id) {
        let formData = { id: id };
        $.ajax({
            url: site_url + 'session-bet-data',
            data: setFormData(formData),
            type: 'post',
            dataType: 'html',
            success: function(output) {
                output = $.parseJSON(CryptoJS.AES.decrypt(output, CRYPTPASS, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));
                $("#fancyposition .title_popup span").text('Fancy Bets');
                $("#fancyposition .modal-body").html(output);
                $('#fancyposition').modal('toggle');
            }
        });
    }

    function get_list(matchId) {
        $("#casinolist").html('');
        if (matchId != '') {
            $.ajax({
                url: site_url + 'Teenpatti/casinolist',
                data: { matchId: matchId },
                type: 'get',
                dataType: 'html',
                success: function(output) {
                    $("#casinolist").html(output);
                    $(".casino_digits").hide();
                }
            });
        }
    }

    function joincasino(MarketId, matchId, ID) {
        var HeadName = $("#fancyname" + ID).text();
        myarray = [];
        matchIdarray = [];
        myarray.push(MarketId.toString());
        matchIdarray.push(matchId.toString());
        currentBet = matchId;
        currentBetMarketId = 1;
        currentMatchBet = '';
        currentMatchBetUn = '';
        casinoID = ID;
        getBets(matchId, MarketId);
        $(".casino_digits").show();
        $(".casino_digits h6 span").text(HeadName).attr('class', 'fancyhead' + ID);
    }