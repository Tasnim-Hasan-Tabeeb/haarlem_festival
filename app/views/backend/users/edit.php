<?php include __DIR__ . '/../inc/header.php'; ?>

<style>
.user-preview {
    width: 100px;
    height: 100px;
    object-fit: cover;
}
</style>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Edit User</h1>

    <form action="/user/update"
          method="post"
          autocomplete="off"
          enctype="multipart/form-data">

        <!-- NAME -->
        <div class="mb-3">
            <label class="form-label">
                Name <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="name"
                   value="<?= htmlspecialchars($user['name']) ?>"
                   placeholder="Enter full name"
                   required>
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="form-label">
                Email <span class="text-danger">*</span>
            </label>

            <input type="email"
                   class="form-control"
                   name="email"
                   value="<?= htmlspecialchars($user['email']) ?>"
                   placeholder="Enter email address"
                   required>
        </div>

        <!-- ROLE -->
        <div class="mb-3">
            <label class="form-label">Role</label>

            <input type="text"
                   class="form-control"
                   name="role"
                   value="<?= htmlspecialchars($user['role']) ?>"
                   readonly>
        </div>

        <!-- PROFILE IMAGE -->
        <div class="mb-4">
            <label class="form-label">Profile Picture</label>

            <input type="file"
                   class="form-control"
                   name="profile_picture"
                   accept="image/*">

            <div class="mt-2">
                <?php if (!empty($user['profile_picture'])) : ?>
                    <img src="<?= htmlspecialchars($user['profile_picture']) ?>"
                         alt="Profile Picture"
                         class="img-thumbnail user-preview">
                <?php else : ?>
                    <img src="/images/default.jpg"
                         alt="Default Profile Picture"
                         class="img-thumbnail user-preview">
                <?php endif; ?>
            </div>
        </div>

        <!-- HIDDEN ID -->
        <input type="hidden"
               name="user_id"
               value="<?= htmlspecialchars($user['user_id']) ?>">

        <button type="submit" class="btn btn-primary">
            Update
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>