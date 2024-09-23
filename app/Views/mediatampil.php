<div class="bg-secondary rounded h-100 p-4">
    <h6 class="mb-4">Media  Feed</h6>

    <!-- Media Items -->
    <?php foreach ($media as $item): ?>
        <div id_user="media-<?= $item->id_user ?>" class="media-item mt-4">
            <!-- Display Username -->
            <h6>Uploaded by: <?= $item->username?></h6>

            <!-- Display media based on type -->
            <?php if ($item->media_type === 'photo'): ?>
                <img src="<?= base_url('images/' . $item->media_path) ?>" alt="Photo" class="img-fluid rounded">
            <?php elseif ($item->media_type === 'video'): ?>
                <video src="<?= base_url('images/' . $item->media_path) ?>" class="img-fluid rounded" controls></video>
            <?php endif; ?>

            <!-- Display Description -->
            <?php if (!empty($item->description)): ?>
                <p><?= $item->description ?></p>
            <?php endif; ?>

            

            <!-- Like Form -->
            <form action="/home/like/<?= $item->id ?>" method="post" class="mt-3">
                <button type="submit" class="btn btn-outline-primary">Like</button>
            </form>

            <!-- Comment Form -->
            <form action="/home/comment/<?= $item->id ?>" method="post" class="mt-3">
                <div class="input-group mb-2">
                    <textarea class="form-control" name="comment" placeholder="Write a comment"></textarea>
                </div>
                <button type="submit" class="btn btn-outline-primary">Comment</button>
            </form>

            <!-- View Comments Button -->
            <button class="btn btn-outline-secondary mt-3" onclick="toggleComments('comments-<?= $item->id ?>')">View Comments</button>

            <!-- Display Comments -->
            <div id="comments-<?= $item->id ?>" class="comments mt-3" style="display: none;">
                <?php if (isset($item->comments) && count($item->comments) > 0): ?>
                    <?php foreach ($item->comments as $comment): ?>
                        <p class="bg-light p-2 rounded"><?= $comment->comment_text ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No comments yet.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function toggleComments(commentId) {
        const commentsDiv = document.getElementById(commentId);
        commentsDiv.style.display = commentsDiv.style.display === "none" ? "block" : "none";
    }
</script>