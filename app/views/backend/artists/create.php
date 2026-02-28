<?php include __DIR__ . '/../inc/header.php'; ?>

    <div class="container mb-5">

        <?php include __DIR__ . '/../inc/message.php'; ?>


        <h1>Add Artist</h1>
        <div class="mt-4">
            <form action="/artist/store" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="real-name" class="form-label">Real Name</label>
                    <input type="text" class="form-control" id="real-name" name="real-name" required>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">Artist Image</label>
                    <input type="file" class="form-control" id="image_url" name="image_url">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" class="form-control" id="age" name="age" required>
                </div>
                <div class="mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <input type="text" class="form-control" id="nationality" name="nationality" required>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" required>
                </div>
                <div class="mb-3">
                    <label for="about" class="form-label">About</label>
                    <textarea class="form-control" id="about" name="about" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="detail_image" class="form-label">Detail Image</label>
                    <input type="file" class="form-control" id="detail_image" name="detail_image">
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

<?php include __DIR__ . '/../inc/footer.php'; ?>