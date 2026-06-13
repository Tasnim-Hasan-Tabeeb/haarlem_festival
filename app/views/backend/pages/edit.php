<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php
    include __DIR__ . '/../../../utils/const.php';
    include __DIR__ . '/../inc/message.php';
    ?>

    <div class="container">

        <h1 class="mb-4">Edit Page</h1>



        <form id="pageForm"
              action="/page/update"
              method="POST"
              autocomplete="off"
              enctype="multipart/form-data">

            <input type="hidden"
                   name="page_id"
                   value="<?= htmlspecialchars($page['page_id']) ?>">

            <!-- TITLE -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">
                        Title <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control"
                           name="title"
                           value="<?= htmlspecialchars($page['title']) ?>"
                           placeholder="Enter page title"
                           required>
                </div>
            </div>

            <hr>

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Sections</h3>



                <?php if ($page['slug'] !== 'home') : ?>

                    <button class="btn btn-success btn-add"
                            data-total-section="<?= count($sections) ?>"
                            type="button">
                        +
                    </button>

                <?php endif; ?>
            </div>

            <!-- SECTION LIST -->
            <div class="section-section">

                <?php foreach ($sections as $index => $section) : ?>

                    <input type="hidden"
                           name="section_id[]"
                           value="<?= $section->getSectionId() ?>">

                    <div class="section border rounded p-3 mb-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Section <?= $index + 1 ?></h4>

                             <?php if ($page['slug'] !== 'home') : ?>
                                <button class="btn btn-danger btn-sm btn-delete"
                                        data-id="<?= $section->getSectionId() ?>"
                                        type="button">
                                
                                    -
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- TITLE + SUBTITLE -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       name="section_title[]"
                                       value="<?= htmlspecialchars($section->getSectionTitle()) ?>"
                                       placeholder="Enter section title"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Sub-Title</label>
                                <input type="text"
                                       class="form-control"
                                       name="section_sub_title[]"
                                       value="<?= htmlspecialchars($section->getSubSectionTitle()) ?>"
                                       placeholder="Enter sub title">
                            </div>
                        </div>

                        <!-- IMAGE + TYPE -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Image</label>
                                <input type="file"
                                       class="form-control"
                                       name="image_url[]"
                                       accept="image/*">

                                <?php if ($section->getImageUrl()) : ?>
                                    <div class="mt-2">
                                        <img src="<?= htmlspecialchars($section->getImageUrl()) ?>"
                                             class="img-thumbnail"
                                             width="120"
                                             height="120"
                                             alt="Section Image">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Type <span class="text-danger">*</span>
                                </label>

                                <select name="section_type[]"
                                        class="form-control"
                                        required>
                                    <option value="">Select</option>

                                    <?php foreach ($sectionTypes as $type) : ?>
                                        <?php $formattedType = str_replace('_', ' ', $type); ?>

                                        <option value="<?= $type ?>"
                                            <?= ($section->getSectionType() === $type) ? 'selected' : '' ?>>
                                            <?= ucwords($formattedType) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- MAP -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">
                                        Map URL
                                </label>
                                <input type="text"
                                       class="form-control"
                                       name="map_url[]"
                                       value="<?= htmlspecialchars($section->getMapUrl()) ?>"
                                       placeholder="Enter URL">
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Content</label>
                                <textarea class="form-control summernote"
                                          name="section_content[]"
                                          placeholder="Write content here"><?= htmlspecialchars($section->getContent()) ?></textarea>
                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <button type="submit" class="btn btn-primary">
                Update Page
            </button>

        </form>

        <!-- TEMPLATE -->
        <div class="section d-none border rounded p-3 mb-4" id="section-template">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Section</h4>

                <button class="btn btn-danger btn-sm btn-delete"
                        data-id="0"
                        type="button">
                    -
                </button>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="section_title[]" placeholder="Enter section title" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sub-Title</label>
                    <input type="text" class="form-control" name="section_sub_title[]" placeholder="Enter sub title">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" name="image_url[]" accept="image/*">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Type</label>
                    <select name="section_type[]" class="form-control" required>
                        <option value="">Select</option>
                        <?php foreach ($sectionTypes as $type) : ?>
                            <?php $formattedType = str_replace('_', ' ', $type); ?>
                            <option value="<?= $type ?>"><?= ucwords($formattedType) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Map URL</label>
                    <input type="text" class="form-control" name="map_url[]" placeholder="Enter map URL">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Content</label>
                    <textarea class="form-control summernote" name="section_content[]"></textarea>
                </div>
            </div>

        </div>

    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
    let sectionIndex = $('.btn-add').data('total-section');

    $('.btn-add').click(function () {
        sectionIndex++;

        const sectionDiv = $('#section-template').clone().removeClass('d-none');

        sectionDiv.find('h4').text('Section ' + sectionIndex);

        $('.section-section').append(sectionDiv);
    });

    $(document).on('click', '.btn-delete', function () {
        var sectionId = $(this).data('id');
        var dis = $(this);

        if (sectionId == 0) {
            $(this).closest('.section').remove();
        } else {
            if (confirm("Are you sure you want to delete this section?")) {
                $.ajax({
                    url: '/page/deleteSection?id=' + sectionId,
                    type: 'GET',
                    success: function (response) {
                        if (response === 'success') {
                            dis.closest('.section').remove();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        }
    });
</script>