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
                    <form role="form" method="POST" id="form">
                        <input type="text" name="id" value="<?= $product['id']; ?>" hidden>
                        <h1>Products</h1>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" name="name" placeholder="Enter product name" value="<?= $product['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" name="price" placeholder="0.0" value="<?= $product['price']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"><?= $product['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tag">Tag</label>
                                <input type="text" class="form-control" name="tag" placeholder="tag" value="<?= $product['tag']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="picture">Picture</label>
                                <input type="text" value="false" name="imageChanged" hidden>
                                <input type="text" name="original_picture" value="<?= $product['picture']; ?>" hidden>
                                <input type="file" name="picture" class="form-control" accept="image/jpeg, image/png" value="<?= $product['picture']; ?>">
                                <img src="<?= '/uploads/product_picture/' . $product['picture']; ?>" width="500" id="preview" />
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category_id" class="select form-control">
                                    <option selected disabled>Select Category</option>
                                    <?php
                                    foreach ($categories as $row) {  ?>
                                        <option value="<?= $row['id']; ?>" <?= $row['id'] == $product['category_id'] ? 'selected' : ''; ?>><?= $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="multi-tag" class="form-control" multiple="multiple">
                                    <option selected="selected">orange</option>
                                    <option>white</option>
                                    <option selected="selected">purple</option>
                                </select>
                            </div>

                            <script defer>
                                document.addEventListener("DOMContentLoaded", function() {
                                    $('#multi-tag').select2({
                                        tags: true,
                                        theme: "classic"
                                    })
                                });
                            </script>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="submit">Update</button>
                        </div>
                    </form>
                </div>

                <div class="col-sm-3"></div>
            </div>
        </section>
    </div>
</div>

<script defer="defer" src="/js/admin/products-update.js"></script>