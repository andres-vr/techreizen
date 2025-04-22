<form method="post" action="<?php echo e($action ?? ''); ?>">
    <?php echo csrf_field(); ?>
    <textarea id="ckeditor-instance" name="content"><?php echo e($content ?? 'Hello, World!'); ?></textarea>
    <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Submit</button>
</form><?php /**PATH C:\Users\ainsw\Downloads\ICTProject\laragon\www\techreizen\resources\views/components/layout/forms/tinymce-editor.blade.php ENDPATH**/ ?>