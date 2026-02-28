<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Edit User</h1>
    <div class="mt-4">
        <form action="/user/update" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" id="role" name="role" value="<?= $user['role'] ?>" readonly>
            </div>
            <div class="mb-5">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                <?php if (empty($user['profile_picture'])) : ?>
                    <img src="/images/default.jpg" class="mt-2" width="100" height="100" alt="Default Profile Picture">
                <?php else : ?>
                    <img src="<?= $user['profile_picture'] ?>" class="mt-2" width="100" height="100" alt="Profile Picture">
                <?php endif; ?>
            </div>
            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>