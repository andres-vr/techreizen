<form method="post" action="<?php echo e($action ?? ''); ?>" class="mt-6">
    <?php echo csrf_field(); ?>
    <?php if($slot->isNotEmpty()): ?>
        <?php echo e($slot); ?>

    <?php else: ?>
        <input id="trix-content" type="hidden" name="content" value="<?php echo e($content ?? ''); ?>">
        <trix-editor input="trix-content" class="trix-content min-h-[300px] bg-white rounded shadow-sm border border-gray-300 p-2"></trix-editor>
        
        <div class="mt-4 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <?php echo e($submitText ?? 'Submit'); ?>

            </button>
        </div>
    <?php endif; ?>
</form><?php /**PATH C:\Users\ainsw\Downloads\ICTProject\laragon\www\techreizen\resources\views/components/layout/forms/texteditor-editor.blade.php ENDPATH**/ ?>