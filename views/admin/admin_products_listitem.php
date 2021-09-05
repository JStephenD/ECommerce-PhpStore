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
            <h3><?= 'Name: ' . $product['name']; ?></h3>
            <hr \>
            <h3><?= 'Price: ' . $product['price']; ?></h3>
            <hr \>
            <h3><?= 'Description: ' . $product['description']; ?></h3>
            <hr \>
            <h3><?= 'Tag: ' . $product['tag']; ?></h3>
            <hr \>

            <div class="row">
                <div class="col-sm-2">
                    <h3><?= 'Image: '; ?></h3>
                </div>
                <div class="col-sm-10">
                    <img src="<?= '/uploads/product_picture/' . $product['picture']; ?>" width="500" />
                </div>
                <hr \>
            </div>

        </section>
    </div>
</div>