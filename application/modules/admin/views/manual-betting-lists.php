<div class="right_col" role="main" style="min-height: 490px;">
    <div class="col-md-12">
        <div class="title_new_at" style="padding:15px;">
            <span class="lable-user-name">
                Manual Bettings

            </span>

            <span id="count-selected-checkbox" style="display:none;font-size:13px;color:red;font-weight:600;">

            </span>

            <button class="btn btn-danger btn-xs pull-right" onclick="deleteBettings()"
                    style="padding:4px 5px; margin-right:5px;">
                Cancel
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="divLoading"></div>

            <div class="card-body" style="overflow-x: scroll;min-height:500px;">
                <?php echo $table; ?>
            </div>
        </div>
    </div>
</div>
<script>


    function deleteBettings() {
        var bettings = new Array();

        $("input[name='betting_id[]").each(function (index, obj) {
            // loop all checked items
            if (this.checked) {
                bettings.push(obj.value);
            }
        });

        if (bettings.length <= 0) {
            bootbox.alert("Please select atleast one bet");
            return false;
        }
        
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);


        $.ajax({
            url: "<?php echo base_url(); ?>admin/bettings/ajxdeletebet",
            method: "POST",
            dataType: "json",
            data: {
                bettings: bettings
            },
            success: function (data) {
                $.unblockUI
                if (data.success) {

                    new PNotify({
                        title: "Success",
                        text: data.message,
                        styling: "bootstrap3",
                        type: "success",
                        delay: 3000,
                    });

                    setTimeout(function () {
                        window.location.reload(1);
                    }, 2000);
                }
            }

        })
    }

    $('.betting_select_all').on('click', function () {
        var numberOfChecked = 0;

        if (this.checked) {
            $('.betting_ids').each(function () {
                this.checked = true;
            });
            numberOfChecked = $('input[name="betting_id[]"]:checkbox:checked').length;
            $('#count-selected-checkbox').show();
        } else {
            $('.betting_ids').each(function () {
                this.checked = false;
            });
            numberOfChecked = $('input[name="betting_id[]"]:checkbox:checked').length;

            $('#count-selected-checkbox').hide();
        }

        $('#count-selected-checkbox').text(numberOfChecked + ' Betts Seleced');

    });

    $('.betting_ids').on('click', function () {
        console.log('adasdasdas');
        if ($('.betting_ids:checked').length == $('.betting_ids').length) {
            $('.betting_select_all').prop('checked', true);
        } else {
            $('.betting_select_all').prop('checked', false);
        }

        numberOfChecked = $('input[name="betting_id[]"]:checkbox:checked').length;

        if (numberOfChecked > 0) {
            $('#count-selected-checkbox').show();
            $('#count-selected-checkbox').text(numberOfChecked + ' Betts Seleced');

        } else {
            $('#count-selected-checkbox').hide();

        }

    });

    function select_all_bets() {
        var check_checked = $('input[name="betting_select_all"]').is(':checked');
        var numberOfChecked = 0;

        if (check_checked) {
            $('.betting_ids').attr('checked', true);
            numberOfChecked = $('input[name="betting_id[]"]:checkbox:checked').length;
            $('#count-selected-checkbox').show();
        } else {
            $('.betting_ids').attr('checked', false);
            numberOfChecked = $('input[name="betting_id[]"]:checkbox:checked').length;

            $('#count-selected-checkbox').hide();
        }

        $('#count-selected-checkbox').text(numberOfChecked + ' Betts Seleced');
    }
</script>