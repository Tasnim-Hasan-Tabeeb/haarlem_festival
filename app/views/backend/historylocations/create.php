<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>


    <h1 class="mb-4">Add Location</h1>

    <form action="/historylocation/store"
          method="POST"
          autocomplete="off"
          enctype="multipart/form-data">

        <!-- NAME -->
        <div class="mb-3">
            <label class="form-label">
                Title <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="location_name"
                   placeholder="Enter location title"
                   required>
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-3">
            <label class="form-label">
                Description <span class="text-danger">*</span>
            </label>

            <textarea class="form-control"
                      name="description"
                      rows="5"
                      placeholder="Enter description"
                      required></textarea>
        </div>

        <!-- ADDRESS -->
        <div class="mb-3">
            <label class="form-label">
                Address <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="address"
                   placeholder="Enter address"
                   required>
        </div>

        <!-- CONTACT INFO -->
        <div class="mb-3">
            <label class="form-label">
                Contact Info <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="contact_info"
                   placeholder="Enter contact information"
                   required>
        </div>

        <!-- IMAGE -->
        <div class="mb-4">
            <label class="form-label">Location Image <span class="text-danger">*</span></label>

            <input type="file"
                   class="form-control"
                   name="image_url"
                   required
                   accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">
            Create
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>