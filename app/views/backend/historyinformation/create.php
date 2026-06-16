<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>


    <h1 class="mb-4">Add Information</h1>

    <form action="/historyinformation/store"
          method="POST"
          autocomplete="off"
          enctype="multipart/form-data">

        <!-- TITLE -->
        <div class="mb-3">
            <label class="form-label">
                Title <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="title"
                   placeholder="Enter title"
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

        <!-- URL -->
        <div class="mb-3">
            <label class="form-label">URL <span class="text-danger">*</span></label>

            <input type="text"
                   class="form-control"
                   name="url"
                   required
                   placeholder="Enter URL">
        </div>

        <!-- IMAGE -->
        <div class="mb-3">
            <label class="form-label">Image <span class="text-danger">*</span></label>

            <input type="file"
                   class="form-control"
                   name="image_url"
                   accept="image/*" required>
        </div>

        <!-- SECTION TYPE -->
        <div class="mb-4">
            <label class="form-label">
                Section Type <span class="text-danger">*</span>
            </label>

            <select class="form-control"
                    name="section_type"
                    required>

                <option value="">Select section</option>
                <option value="Header">Header</option>
                <option value="Introduction">Introduction</option>
                <option value="Information">Information</option>
                <option value="RegularTicket">Regular Ticket</option>
                <option value="FamilyTicket">Family Ticket</option>
                <option value="Routes">Routes</option>

            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Create
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>