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
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="page-container">
                <?php if($page->type == 'html'): ?>
                    <div class="trix-content">
                        <?php echo $page->content; ?>

                    </div>
                <?php elseif($page->type == 'pdf'): ?>
                    <?php
                        $pdfPath = 'pdfs/' . $page->content;
                    ?>
                
                    <?php if(file_exists(storage_path('app/public/' . $pdfPath))): ?>
                        <iframe 
                            src="<?php echo e(asset('storage/' . $pdfPath)); ?>" 
                            width="100%"
                            height="1250px"
                            style="border: 1px solid #ddd;"
                        ></iframe>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            PDF not found: <?php echo e($pdfPath); ?>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if(Auth::check() && Auth::user()->role === 'admin'): ?>
                 <div class="mt-4">
                    <a href="<?php echo e(route('editor')); ?>" class="btn btn-primary">
                        Edit Content
                    </a>
                </div>
                <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\ainsw\Downloads\ICTProject\laragon\www\techreizen\resources\views/content/show.blade.php ENDPATH**/ ?>