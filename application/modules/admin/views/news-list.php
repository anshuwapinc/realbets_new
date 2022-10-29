<div class="main-content" role="main">
    <div class="main-inner">

        <section class="match-content">
            <div class="table_tittle " style="height:50px;">
                <span class="lable-user-name">
                    News
                </span>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#exampleModal">
                    Add News
                </button>
            </div>



            <div class="card-body">
                <div class="table-responsive sports-tabel">
                    <table class="table tabelcolor tabelborder" id="example" style="width:100%; ">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>News</th>
                                <th colspan="2" style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($news) && !empty($news)) {
                                $i = 1;
                                foreach ($news as $value) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $value['description']; ?></td>
                                        <td>
                                            <center>
                                                <button data-description="<?php echo $value['description']; ?>" data-news-id="<?php echo $value['news_id']; ?>" type="button" class="btn btn-warning btn-sm edit-news"><i class="fa fa-pencil"></i></button>



                                                <button type="button" style="margin-left:10px;" class="btn btn-danger btn-sm" onclick="deleteNews(`<?php echo $value['news_id']; ?>`,`<?php echo $value['description']; ?>`)"><i class="fa fa-trash"></i></button>
                                            </center>
                                        </td>

                                    </tr>

                            <?php }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="news-form" name="news-form">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content  ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;">News</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="hidden" name="news_id" id="news_id" class="form-control" />
                                <textarea class="form-control" name="description" id="description"></textarea>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>