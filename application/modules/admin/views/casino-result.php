<table style="width:100%;" class="table table-bordered">
    <thead>
        <tr>
        <th>Round ID</th>
        <th>Result</th>
        </tr>
    </thead>
    <tbody>
        <?php

            if(!empty($results))
            {
                foreach($results as $result)
                { ?>
                    <tr>
                        <td><?php echo $result['market_id']; ?></td>
                        <td><?php echo $result['player']; ?></td>

                    </tr> 
              <?php  }
            }
?>
    </tbody>
</table>