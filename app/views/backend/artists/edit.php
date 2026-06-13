<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Edit Artist</h1>

    <form action="/artist/update" method="post" autocomplete="off" enctype="multipart/form-data">

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">
                Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   value="<?= htmlspecialchars($artists['artist_name']) ?>"
                   placeholder="Enter artist name"
                   required>
        </div>

        <!-- Real Name -->
        <div class="mb-3">
            <label for="real-name" class="form-label">
                Real Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   id="real-name"
                   name="real-name"
                   value="<?= isset($artists['artist_real_name']) ? htmlspecialchars($artists['artist_real_name']) : null ?>"
                   placeholder="Enter real name"
                   required>
        </div>

        <!-- Age -->
        <div class="mb-3">
            <label for="age" class="form-label">
                Age <span class="text-danger">*</span>
            </label>
            <input type="number"
                   class="form-control"
                   id="age"
                   name="age"
                   value="<?= htmlspecialchars($artists['age']) ?>"
                   placeholder="Enter age"
                   min="1"
                   required>
        </div>

        <!-- Nationality -->
        <div class="mb-3">
            <label for="nationality" class="form-label">
                Nationality <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   id="nationality"
                   name="nationality"
                   value="<?= htmlspecialchars($artists['nationality']) ?>"
                   placeholder="Enter nationality"
                   required>
        </div>

        <!-- Genre -->
        <div class="mb-3">
            <label for="genre" class="form-label">
                Genre <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   id="genre"
                   name="genre"
                   value="<?= htmlspecialchars($artists['genre']) ?>"
                   placeholder="Enter genre (e.g. Pop, Rock)"
                   required>
        </div>

        <!-- About -->
        <div class="mb-3">
            <label for="about" class="form-label">
                About <span class="text-danger">*</span>
            </label>
            <textarea class="form-control"
                      id="about"
                      name="about"
                      rows="5"
                      placeholder="Write about the artist..."
                      required><?= htmlspecialchars($artists['about']) ?></textarea>
        </div>

        <!-- Artist Image -->
        <div class="mb-4">
            <label class="form-label">Artist Image</label>
            <input type="file"
                   class="form-control"
                   name="image_url"
                   accept="image/*">

            <div class="mt-2">
                <img src="<?= $artists['image_url'] ?>"
                     alt="Artist Image"
                     class="img-thumbnail"
                     width="100"
                     height="100">
            </div>
        </div>

        <!-- Detail Image -->
        <div class="mb-4">
            <label class="form-label">Detail Image</label>
            <input type="file"
                   class="form-control"
                   name="detail_image"
                   accept="image/*">

            <div class="mt-2">
                <img src="<?= $artists['detail_image'] ?>"
                     alt="Detail Image"
                     class="img-thumbnail"
                     width="100"
                     height="100">
            </div>
        </div>

        <!-- Hidden ID -->
        <input type="hidden"
               name="artist_id"
               value="<?= htmlspecialchars($artists['artist_id']) ?>">

        <button type="submit" class="btn btn-primary">
            Update Artist
        </button>

    </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>