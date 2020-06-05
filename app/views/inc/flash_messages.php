<?php $messages = \app\utils\Flash::getMessages(); ?>
<?php if (isset($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= htmlspecialchars($message['body']) ?></div>
    <?php endforeach ?>
<?php endif ?>