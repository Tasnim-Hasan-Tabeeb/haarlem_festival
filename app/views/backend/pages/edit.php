<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php

    include __DIR__ . '/../../../utils/const.php';
    include __DIR__ . '/../inc/message.php';

    ?>

    <div class="container">
        <h1>Edit Page</h1>
        <form id="pageForm" action="/page/update" method="POST" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="page_id" value="<?= $page['page_id'] ?>">
            <div class="row">
                <div class="col-md-12">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" value="<?= $page['title'] ?>" name="title" required>
                </div>
            </div>

            <br>
            <div class="d-flex justify-content-between">
                <h1 class="float-start">Add Section</h1>
                <button class="btn btn-success btn-add" data-total-section="<?= count($sections) ?>" type="button">+</button>
            </div>

            <div class="section-section">
                <?php foreach ($sections as $index => $section) : ?>
                    <br>
                    <input type="hidden" name="section_id[]" value="<?= $section->getSectionId() ?>">
                    <div class="section">
                        <div class="d-flex justify-content-between mb-3">
                            <h2 class="float-start">Section <?= $index + 1 ?></h2>
                            <button class="btn btn-danger btn-sm float-end btn-delete" data-id="<?= $section->getSectionId() ?>" type="button">-</button>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="section_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="section_title" value="<?= $section->getSectionTitle() ?>" name="section_title[]" required>
                            </div>
                            <div class="col-md-6">
                                <label for="section_sub_title" class="form-label">Sub-Title</label>
                                <input type="text" class="form-control" id="section_sub_title" value="<?= $section->getSubSectionTitle() ?>" name="section_sub_title[]">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="image_url" class="form-label">Image</label>
                                <input type="file" class="form-control mb-2" id="image_url" name="image_url[]">
                                <?php if ($section->getImageUrl()) { ?>
                                    <img src="<?= $section->getImageUrl() ?>" alt="Current Image" style="width: 150px;">
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label for="section_type" class="form-label">Type</label>
                                <select name="section_type[]" class="form-control" id="section_type" required>
                                    <option value="">Select</option>
                                    <?php foreach ($sectionTypes as $type) : ?>
                                        <?php $formattedType = str_replace('_', ' ', $type); ?>
                                        <option value="<?= $type ?>" <?= ($section->getSectionType() === $type) ? 'selected' : '' ?>><?= ucwords($formattedType) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="map_url" class="form-label">Map URL</label>
                                <input type="text" class="form-control" id="map_url" name="map_url[]" value="<?= $section->getMapUrl() ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="section_content" class="form-label">Content</label>
                                <textarea class="form-control summernote" id="section_content" name="section_content[]"><?= $section->getContent() ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        <!-- new section -->
        <div class="section d-none" id="section-template">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="float-start">Section 1</h2>
                <button class="btn btn-danger btn-sm float-end btn-delete" data-id="0" type="button">-</button>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="section_title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="section_title" name="section_title[]" required>
                </div>
                <div class="col-md-6">
                    <label for="section_sub_title" class="form-label">Sub-Title</label>
                    <input type="text" class="form-control" id="section_sub_title" name="section_sub_title[]">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="image_url" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image_url" name="image_url[]">
                </div>
                <div class="col-md-6">
                    <label for="section_type" class="form-label">Type</label>
                    <select name="section_type[]" class="form-control" id="section_type" required>
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
                    <label for="map_url" class="form-label">Map URL</label>
                    <input type="text" class="form-control" id="map_url" name="map_url[]">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="section_content" class="form-label">Content</label>
                    <textarea class="form-control summernote" id="section_content" name="section_content[]"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
    let sectionIndex = $('.btn-add').data('total-section');

    $('.btn-add').click(function() {
        sectionIndex++;
        const sectionDiv = $('#section-template').clone().removeClass('d-none');

        sectionDiv.find('h2').text('Section ' + sectionIndex);

        $('.section-section').append(sectionDiv);
    });

    $(document).on('click', '.btn-delete', function() {
        var sectionId = $(this).data('id');
        var dis = $(this);

        if (sectionId == 0) {
            $(this).closest('.section').remove();
        } else {
            var confirmDelete = confirm("Are you sure you want to delete this section?");
            if (confirmDelete) {
                $.ajax({
                    url: '/page/deleteSection?id=' + sectionId,
                    type: 'GET',
                    success: function(response) {
                        if (response === 'success') {
                            dis.closest('.section').remove();
                        } else {
                            console.error('Error deleting section.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting section:', error);
                    }
                });
            }
        }
    });
</script>