<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Edit Artist</h1>
    <div class="mt-4">
        <form action="/artist/update" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $artists['artist_name'] ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="real-name" class="form-label">Real Name</label>
                <input type="text" class="form-control" id="real-name" name="real-name" value="<?= $artists['artist_real_name'] ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="text" class="form-control" id="age" name="age" value="<?= $artists['age'] ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nationality</label>
                <input type="text" class="form-control" id="nationality" name="nationality" value="<?= $artists['nationality'] ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?= $artists['genre'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="about" class="form-label">About</label>
                <textarea class="form-control" id="about" name="about" rows="5" required><?= $artists['about'] ?></textarea>
            </div>
            <div class="mb-5">
                <label for="image_artist" class="form-label">Artist Image</label>
                <input type="file" class="form-control" id="image_url" name="image_url">
                <img src="<?= '/images/' . $artists['image_url'] ?>" class="mt-2" width="100" height="100" alt="Artist Image">
            </div>
            <div class="mb-5">
                <label for="detail_image" class="form-label">Detail Image</label>
                <input type="file" class="form-control" id="image_url" name="detail_image">
                <img src="<?= '/images/' . $artists['detail_image'] ?>" class="mt-2" width="100" height="100" alt="Detail Image">
            </div>
            <input type="hidden" name="artist_id" value="<?= $artists['artist_id'] ?>">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
