<style>
    .table-responsive table {
        font-size: 14px !important;

    }
    .year_heading span{
padding-left: 10px;
    }
    .year_heading{
        font-size: 16px;
        border-bottom: 1px solid;
    }
</style>
<main id="main" class="main-content">
    <div class="container-fluid right_col" role="main">
        <div class="card" style="background:#fff; margin-top:15px">
            <div class="card-body" style="overflow-x: scroll;min-height:500px;">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Admin Income Report</h3>
                        <?php
                        if (!empty($final_income_report_arr)) {
                            ?>
                          
                            <?php
                            foreach ($final_income_report_arr as $year_row) {
                        ?>
                          <table class="table year_heading">
                                <tr >
                                    <td><?php echo $year_row['year'] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><span style="color:green">D : <?php echo $year_row['total_withdraw'] ?></span><span style="color:red">W : <?php echo $year_row['total_deposit'] ?></span> <span>T : <?php echo $year_row['total_withdraw'] - $year_row['total_deposit'] ?></span></td>
                                </tr>
                            </table>
                                <div class="table-responsive">
                                    <table class="table table-bodered">
                                        <?php
                                        if (count($year_row['year_month_day_array']) > 0) {
                                            foreach ($year_row['year_month_day_array'] as $month_row) {
                                        ?>
                                                <thead data-toggle="collapse" data-target="#month<?php echo $month_row['month'] ?>">
                                                    <tr>
                                                        <td><?php echo date('F', mktime(0, 0, 0, $month_row['month'], 10)) ?></td>
                                                        <td style="color:green">D : <?php echo $month_row['total_withdraw'] ?></td>
                                                        <td style="color:red">W : <?php echo $month_row['total_deposit'] ?></td>
                                                        <td>T : <?php echo $month_row['total_withdraw'] - $month_row['total_deposit']  ?></td>
                                                        <td><i class="fas fa-angle-down rotate-icon"></i></td>
                                                    </tr>
                                                </thead>
                                                <tbody id="month<?php echo $month_row['month'] ?>" class="collapse" role="tabpanel">
                                                    <?php
                                                    if (count($month_row['month_day_array']) > 0) {
                                                        foreach ($month_row['month_day_array'] as $day_row) {
                                                    ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $day_row['day'] . '-' . date('F', mktime(0, 0, 0, $month_row['month'], 10)) ?> </td>
                                                                <td style="color:green">D : <?php echo $day_row['total_withdraw'] ?></td>
                                                                <td style="color:red">W : <?php echo $day_row['total_deposit'] ?></td>
                                                                <td>T : <?php echo $day_row['total_withdraw'] - $day_row['total_deposit'] ?></td>
                                                                <td></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
</main>