<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php

    include __DIR__ . '/../../../utils/const.php';
    include __DIR__ . '/../inc/message.php';

    ?>

    <div class="container">
        <h1>Create Page</h1>
        <form id="pageForm" action="/page/store" method="POST" autocomplete="off" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>

            <br>
            <div class="d-flex justify-content-between">
                <h1 class="float-start">Add Section</h1>
                <button class="btn btn-success btn-add" type="button">+</button>
            </div>

            <div class="section-section">
                <br>
                <div class="section">
                    <div class="d-flex justify-content-between mb-3">
                        <h2 class="float-start">Section 1</h2>
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

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
    let sectionIndex = 1;

    $('.btn-add').click(function() {
        sectionIndex++;
        const sectionDiv = $('.section-section').find('.section').first().clone();

        sectionDiv.find('input[type="text"]').val('');
        sectionDiv.find('input[type="file"]').val('');
        sectionDiv.find('.note-editable').html('');


        sectionDiv.find('h2').text('Section ' + sectionIndex);
        sectionDiv.find('.btn-delete').removeClass('btn-add').addClass('btn-delete');
        sectionDiv.find('h2').parent().append('<button class="btn btn-danger btn-sm float-end btn-delete" type="button">-</button>');
        $('.section-section').append(sectionDiv);
    });

    $(document).on('click', '.btn-delete', function() {
        $(this).closest('.section').remove();
    });
</script>