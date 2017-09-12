<!-- Navigation admin-->

<!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="index.php">
                CEPA BOOKS ADMIN
            </a>
        </li>
        <?php if (has_permission('admin')): ?>
        <li><a href="approved.php">Vetted</a></li>
        <li><a href="author.php">Authors</a></li>
        <?php endif; ?>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="products.php">Books</a></li>
        <li><a href="archived.php">Archived</a></li>
        <?php if (has_permission('admin')): ?>
        <li><a href="users.php">Users</a></li>
        <li><a href="converse.php">Info</a></li>
        <li><a href="author_request.php">Author Request</a></li>
        <li><a href="subscribe.php">Client</a></li>
        <?php endif; ?>
        <li><a href="change_password.php">Change Password</a></li>
        <li><a href="logout.php">Log Out</a></li>
    </ul>
</div>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-up">
<style media="screen">
/*#id{
  margin-top: -50px;
}*/
</style>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <a href="#menu-toggle" class="btn btn-info" id="menu-toggle">Sidebar</a>
