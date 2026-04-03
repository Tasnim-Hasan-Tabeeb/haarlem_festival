<?php include __DIR__ . '/../inc/header.php'; ?>

    <div class="container mb-5">
        <h1>Add Info</h1>
        <div class="mt-4">
            <form action="/historyinformation/add" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="about" class="form-label">Description</label>
                    <textarea class = "form-control" id="description" name="description" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Url</label>
                    <input type="text" class="form-control" id="url" name="url">
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label"> Image</label>
                    <input type="file" class="form-control" id="image_url" name="image_url">
                </div>

                <div class="mb-3">
                    <label for="section_type" class="form-label">Section Type</label>
                    <select class="form-control" id="section_type" name="section_type" required>
                        <option value="">Select Section</option>
                        <option value="Header">Header</option>
                        <option value="Introduction">Introduction</option>
                        <option value="Information">Information</option>
                        <option value="RegularTicket">Regular Ticket</option>
                        <option value="FamilyTicket">Family Ticket</option>
                        <option value="Routes">Routes</option>
                       
                    </select>
               </div>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

<?php include __DIR__ . '/../inc/footer.php'; ?>