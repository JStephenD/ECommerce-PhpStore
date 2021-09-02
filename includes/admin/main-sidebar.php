<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/others/adminlte-v2/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <!-- <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="/admin"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="admin"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li> -->

            <li>
                <a href="/admin">
                    <i class="fa fa-th"></i> <span>Home</span>
                </a>
            </li>

            <li>
                <a href="/admin/categories">
                    <i class="fa fa-th"></i> <span>Categories</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">new</small>
                    </span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th"></i>
                    <span>Products</span>
                    <span class="pull-right-container">
                        <span class="label label-primary pull-right">2</span>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/products/list"><i class="fa fa-circle-o"></i> List Products</a></li>
                    <li><a href="/admin/products"><i class="fa fa-circle-o"></i> Add Product</a></li>
                </ul>
            </li>
            <?php if (isset($_SESSION['admin'])) { ?>
                <li>
                    <a href="/admin/logout">
                        <i class="fa fa-th"></i> <span>Logout</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>