<div class="right_col" role="main">


    <div class="card" style="background:#fff;">
         <div class="title_new_at">   Account Info 
					 </div>
			</div>
        
        <div class="table-scroll" style="overflow-x: scroll;">
            <table class="table table-striped jambo_table bulk_action" id="example" style="width:100%;">
                <thead>
                    <tr class="headings">
                        <th>Chips</th>
                        <th>Free Chips</th>
                        <th>Liability</th>
                        <th>Wallet</th>
                        <th>Up</th>
                        <th>Down</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><?php echo get_total_winnings(); ?></td>
                        <!-- <td><?php echo !empty(count_total_exposure($user_id)) ? count_total_exposure($user_id) : 0.00;; ?></td> -->
                        <td><?php echo !empty(count_free_chip($user_id)) ? number_format(count_free_chip($user_id), 2) : 0.00; ?></td>
                        <td><?php echo !empty(count_total_exposure($user_id)) ? count_total_exposure($user_id) : 0.00;; ?></td>
                        <td><?php echo !empty(count_total_balance($user_id)) ? count_total_balance($user_id) : 0.00; ?></td>
                        <td>0.00</td>
                        <td>0.00</td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>