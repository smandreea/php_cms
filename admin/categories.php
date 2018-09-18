<?php include "includes/admin_header.php";?>

    <div id="wrapper">

        <?php include "includes/admin_navigation.php";?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Categories
                            <small>Create/View/Edit/Delete</small>
                        </h1>

                        <div class="col-xs-6">
                            <?php insert_category(); ?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input type="text" name="cat_title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Add category" class="btn btn-primary">
                                </div>
                            </form>
                            
                            <?php
                            if (isset($_GET['update'])) {
                                $cat_to_be_modified = $_GET['update'];
                                include "includes/update_category.php";
                            }
                            ?>
                        </div>

                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Find all categories query
                                    find_all_categories();
                                // Delete category function
                                    delete_category();
                                ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include "includes/admin_footer.php";?>