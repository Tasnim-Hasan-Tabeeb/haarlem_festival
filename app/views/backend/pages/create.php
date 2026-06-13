<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php
    include __DIR__ . '/../../../utils/const.php';
    include __DIR__ . '/../inc/message.php';
    ?>

    <div class="container">

        <h1 class="mb-4">Create Page</h1>

        <form id="pageForm" action="/page/store" method="POST" autocomplete="off" enctype="multipart/form-data">

            <!-- TITLE -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="title" class="form-label">
                        Title <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control"
                           id="title"
                           name="title"
                           placeholder="Enter page title"
                           required>
                </div>
            </div>

            <hr>

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Add Section</h3>
                <button class="btn btn-success btn-add" type="button">+</button>
            </div>

            <!-- SECTION WRAPPER -->
            <div class="section-section">

                <div class="section border rounded p-3 mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Section 1</h4>
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
                                   placeholder="Enter section title"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Sub-Title</label>
                            <input type="text"
                                   class="form-control"
                                   name="section_sub_title[]"
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
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Type <span class="text-danger">*</span>
                            </label>
                            <select name="section_type[]" class="form-control" required>
                                <option value="">Select type</option>
                                <?php foreach ($sectionTypes as $type) : ?>
                                    <?php $formattedType = str_replace('_', ' ', $type); ?>
                                    <option value="<?= $type ?>">
                                        <?= ucwords($formattedType) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- MAP -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Map URL</label>
                            <input type="text"
                                   class="form-control"
                                   name="map_url[]"
                                   placeholder="Paste map URL">
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Content</label>
                            <textarea class="form-control summernote"
                                      name="section_content[]"
                                      placeholder="Write section content"></textarea>
                        </div>
                    </div>

                </div>

            </div>

            <button type="submit" class="btn btn-primary">
                Create Page
            </button>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
    let sectionIndex = 1;

    $('.btn-add').click(function () {
        sectionIndex++;

        const sectionDiv = $('.section-section').find('.section').first().clone();

        sectionDiv.find('input[type="text"]').val('');
        sectionDiv.find('input[type="file"]').val('');
        sectionDiv.find('textarea').val('');

        sectionDiv.find('.note-editable').html('');
        sectionDiv.find('h4').text('Section ' + sectionIndex);

        sectionDiv.find('.btn-delete').remove();

        sectionDiv.find('.d-flex').first().append(
            '<button class="btn btn-danger btn-sm btn-delete" type="button">-</button>'
        );

        $('.section-section').append(sectionDiv);
    });

    $(document).on('click', '.btn-delete', function () {
        $(this).closest('.section').remove();
    });
</script>