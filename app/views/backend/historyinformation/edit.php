<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Edit Information</h1>

    <form action="/historyinformation/update"
          method="post"
          autocomplete="off"
          enctype="multipart/form-data">

        <!-- TITLE -->
        <div class="mb-3">
            <label class="form-label">
                Name <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="title"
                   value="<?= htmlspecialchars($content['title']) ?>"
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
                      required><?= htmlspecialchars($content['description']) ?></textarea>
        </div>

        <!-- URL -->
        <div class="mb-3">
            <label class="form-label">URL <span class="text-danger">*</span></label>

            <input type="text"
                   class="form-control"
                   name="url"
                   required
                   value="<?= htmlspecialchars($content['url']) ?>"
                   placeholder="Enter URL (optional)">
        </div>

        <!-- IMAGE -->
        <div class="mb-4">
            <label class="form-label">Location Image</label>

            <input type="file"
                   class="form-control"
                   name="image_url"
                   accept="image/*">

            <?php if (!empty($content['image'])) : ?>
                <div class="mt-2">
                    <img src="<?=  $content['image'] ?>"
                         alt="Location Image"
                         class="img-thumbnail"
                         width="100"
                         height="100">
                </div>
            <?php endif; ?>
        </div>

        <!-- SECTION TYPE -->
        <div class="mb-3">
            <label class="form-label">
                Section Type <span class="text-danger">*</span>
            </label>

            <select class="form-control"
                    name="section_type"
                    required>

                <option value="">Select section</option>

                <option value="Header" <?= $content['section_type'] == 'Header' ? 'selected' : '' ?>>Header</option>

                <option value="Introduction" <?= $content['section_type'] == 'Introduction' ? 'selected' : '' ?>>Introduction</option>

                <option value="Information" <?= $content['section_type'] == 'Information' ? 'selected' : '' ?>>Information</option>

                <option value="RegularTicket" <?= $content['section_type'] == 'RegularTicket' ? 'selected' : '' ?>>Regular Ticket</option>

                <option value="FamilyTicket" <?= $content['section_type'] == 'FamilyTicket' ? 'selected' : '' ?>>Family Ticket</option>

                <option value="Routes" <?= $content['section_type'] == 'Routes' ? 'selected' : '' ?>>Routes</option>

            </select>
        </div>

        <!-- HIDDEN ID -->
        <input type="hidden"
               name="content_id"
               value="<?= htmlspecialchars($content['content_id']) ?>">

        <button type="submit" class="btn btn-primary">
            Update
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>