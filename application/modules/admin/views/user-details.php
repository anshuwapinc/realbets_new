<div class="right_col" role="main">

    <div class="card" style="background:#fff; margin-top:15px;">

        <div class="card-body" style="min-height:500px;padding:15px;">
            <div class="row" style="padding-bottom:15px;">

                <div class="col-md-6 col-xs-12">
                    <label>User ID</label>
                    <input type="text" name="userId" id="userId" style="width:60%;display:inline-block;" class="form-control" id="master_name">
                    <button type="button" class="blue_button submit_user_setting" onclick="search_user();">Search</button>
                </div>


            </div>

            <div class="row" style="border-top:1px dashed #efefef; margin-top:10px;padding-top:15px;">
                <div class="col-md-12 col-xs-12" id="userDetailBody">

                </div>
            </div>
        </div>
    </div>
</div>




<!-----------Chip Deposit Model---------------------------->
<script>
    function search_user() {
        var userId = $('#userId').val().trim();



        if (userId == '') {
            alert("Please enter valid username");
            return false;
        }
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);


        $.ajax({
            url: "<?php echo base_url(); ?>admin/User/search_user",
            method: "POST",
            dataType: "json",
            data: {
                userId: userId,
            },
            dataType: "json",
            success: function(data) {
                $.unblockUI

                $('#userDetailBody').html(data.htmlData);

            }

        })
    }
</script>