<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Create Feature</h1>

    <div class="mt-4">
        <form action="/feature/store" method="POST" autocomplete="off" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="name" class="form-label">
                    Name <span class="text-danger">*</span>
                </label>

                <input type="text"
                       class="form-control"
                       id="name"
                       name="name"
                       placeholder="Enter feature name"
                       required>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">
                    Feature Image <span class="text-danger">*</span>
                </label>

                <input type="file"
                       class="form-control"
                       id="image_url"
                       name="image_url"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                Create
            </button>

        </form>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>