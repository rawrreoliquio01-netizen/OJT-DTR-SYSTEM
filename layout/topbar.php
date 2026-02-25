<div class="topbar d-flex justify-content-between align-items-center px-3 py-2 bg-light">
    <h3><?= isset($pageTitle) ? $pageTitle : 'Admin Panel'; ?></h3>
    <div>
        <a href="manage_account.php" class="btn btn-sm btn-warning me-2">Manage Account</a>
        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
</div>
