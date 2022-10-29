<?php
                        if (!empty($reports)) {
                            foreach ($reports as $report) {
                        ?>
                                <tr>
                                    <td><?php echo date('d M Y H:i:s', strtotime($report['created_at'])); ?></td>
                                    <?php
                                    if (get_user_type() !== 'User') { ?>

                                        <td><?php echo $report['client_name']; ?>(<?php echo $report['client_user_name']; ?>) </td>

                                    <?php } ?>
                                    <td><?php echo $report['game']; ?></td>
                                    <td><?php echo $report['betting_id']; ?></td>
                                    <td><?php echo $report['event_name']; ?>
                                    <?php
                                    if($report['betting_type'] != 'Fancy')
                                    {
                                        echo '/'.$report['market_name'];
                                    } ?>
                                    /<?php echo $report['place_name']; ?></td>
                                    <td class=""><?php
                                                    if ($report['betting_type'] == 'Fancy') {
                                                    } else {
                                                        echo $report['place_name'];
                                                    }

                                                    ?></td>
                                    <td><?php
                                    if($report['is_back'] == 1)
                                    {
                                        echo "Back";
                                    }
                                    else{
                                        echo "Lay";
                                    }
                                   ?></td>

                                    <td><?php echo $report['betting_type']; ?></td>
                                    <td><?php echo $report['price_val']; ?></td>
                                  
                                    <td><?php
                                        if (get_user_type() == 'User') {
                                            echo $report['loss'];
                                        } else {
                                            echo $report['loss'];
                                        }
                                        ?></td>
                                    <td><?php
                                        if (get_user_type() == 'User') {
                                        
                                            echo $report['profit'];
                                        } else {
                                            echo $report['profit'];
                                        }
                                        ?></td>
                                       
                                   
                                </tr>
                            <?php   }
                        } else { ?>
                            <tr>
                                <td colspan="10">No record found.</td>
                            </tr>
                        <?php }
                        ?>