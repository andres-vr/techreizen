<?php if (isset($component)) { $__componentOriginalf21d3388c26fe384c2419e18236c69f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf21d3388c26fe384c2419e18236c69f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.home','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.home'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="row justify-content-center p-2">
        <div class="pt-3">
            <div class="px-5">
                <span><?php echo $page->content; ?></span>
            </div>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf21d3388c26fe384c2419e18236c69f2)): ?>
<?php $attributes = $__attributesOriginalf21d3388c26fe384c2419e18236c69f2; ?>
<?php unset($__attributesOriginalf21d3388c26fe384c2419e18236c69f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf21d3388c26fe384c2419e18236c69f2)): ?>
<?php $component = $__componentOriginalf21d3388c26fe384c2419e18236c69f2; ?>
<?php unset($__componentOriginalf21d3388c26fe384c2419e18236c69f2); ?>
<?php endif; ?><?php /**PATH C:\Users\ainsw\Downloads\ICTProject\laragon\www\techreizen\resources\views/home.blade.php ENDPATH**/ ?>