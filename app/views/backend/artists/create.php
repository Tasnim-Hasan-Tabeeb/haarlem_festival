<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Add Artist</h1>

    <form action="/artist/store" method="POST" autocomplete="off" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   placeholder="Enter artist name"
                   required>
        </div>

        <div class="mb-3">
            <label for="real-name" class="form-label">Real Name <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control"
                   id="real-name"
                   name="real-name"
                   placeholder="Enter real name"
                   required>
        </div>

    
        <div class="mb-3">
            <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
            <input type="number"
                   class="form-control"
                   id="age"
                   name="age"
                   placeholder="Enter age (must be greater than 0)"
                   min="1"
                   required>
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control"
                   id="nationality"
                   name="nationality"
                   placeholder="Enter nationality"
                   required>
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Genre <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control"
                   id="genre"
                   name="genre"
                   placeholder="Enter genre (e.g. Pop, Rock)"
                   required>
        </div>

        <div class="mb-3">
            <label for="about" class="form-label">About <span class="text-danger">*</span></label>
            <textarea class="form-control"
                      id="about"
                      name="about"
                      rows="5"
                      placeholder="Write about the artist..."
                      required></textarea>
        </div>

         <div class="mb-3">
            <label for="image_url" class="form-label">Artist Image <span class="text-danger">*</span></label>
            <input type="file"
                   class="form-control"
                   id="image_url"
                   name="image_url"
                   required
                   accept="image/*">
        </div>


        <div class="mb-3">
            <label for="detail_image" class="form-label">Detail Image <span class="text-danger">*</span></label>
            <input type="file"
                   class="form-control"
                   id="detail_image"
                   name="detail_image"
                   required
                   accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">
            Create Artist
        </button>

    </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>