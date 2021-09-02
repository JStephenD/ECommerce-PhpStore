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
            <a href="/admin/products/add">
                <button style="color:green">+ Add new</button>
            </a>

            <?php foreach ($products as $row) { ?>
                <a href="<?= '/admin/products/list/' . $row['id']; ?>">
                    <h3><?= $row['id'] . ': ' . $row['name'] ?></h3>
                </a>
                <a href="<?= '/admin/products/update/' . $row['id']; ?>">
                    <button>Update</button>
                </a>
                <button type="button" style="color:red" onclick="promptDelete(<?= $row['id'] ?>, `<?= $row['name']; ?>`)">Delete</button>
                <hr \>
            <?php } ?>
        </section>
    </div>
</div>

<script defer="defer" src="/js/admin/products-list.js"></script>