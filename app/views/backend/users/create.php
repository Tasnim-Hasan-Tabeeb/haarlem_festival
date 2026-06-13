<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Create User</h1>

    <form action="/user/store"
          method="POST"
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
                   placeholder="Enter full name"
                   required>
        </div>

        <!-- PROFILE IMAGE -->
        <div class="mb-3">
            <label class="form-label">Profile Picture</label>

            <input type="file"
                   class="form-control"
                   name="profile_picture"
                   accept="image/*">
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="form-label">
                Email <span class="text-danger">*</span>
            </label>

            <input type="email"
                   class="form-control"
                   name="email"
                   placeholder="Enter email address"
                   required>
        </div>

        <!-- PASSWORD -->
        <div class="mb-3">
            <label class="form-label">
                Password <span class="text-danger">*</span>
            </label>

            <input type="password"
                   class="form-control"
                   name="password"
                   placeholder="Enter password"
                   required>
        </div>

        <!-- ROLE -->
        <div class="mb-4">
            <label class="form-label">
                Role <span class="text-danger">*</span>
            </label>

            <select class="form-select"
                    name="role"
                    required>

                <option value="">Select role</option>

                <?php foreach ($roles as $role) : ?>
                    <option value="<?= htmlspecialchars($role) ?>">
                        <?= htmlspecialchars($role) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Create
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>