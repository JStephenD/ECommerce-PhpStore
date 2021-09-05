<style>
    .select {
        min-width: 150;
    }
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <form role="form" id="form">
                        <h1>Products</h1>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" name="name" placeholder="Enter product name">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" name="price" placeholder="0.0">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Tag">Tag</label>
                                <input type="text" class="form-control" name="tag" placeholder="tag">
                            </div>
                            <div class="form-group">
                                <label for="picture">Picture</label>
                                <input type="file" name="picture" accept="image/jpeg, image/png">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category_id" class="select">
                                    <option selected disabled>Select Category</option>
                                    <?php
                                    foreach ($categories as $row) {  ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </form>

                    <a href="/admin/products/list">
                        <button style="color:green">Back to List</button>
                    </a>
                </div>

                <div class="col-sm-3"></div>
            </div>
        </section>
    </div>
</div>

<script defer="defer" src="/js/admin/products-add.js"></script>