

<?php if($paginator->hasPages()): ?>
<nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
    <ul class="pagination pr-0">
        <?php if(!$paginator->onFirstPage()): ?>
            <li class="page-item">
                <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                href="<?php echo e($paginator->previousPageUrl()); ?>"><?php echo e(trans('site.previous')); ?></a>
            </li>
        <?php endif; ?>

        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if(is_string($element)): ?>
                <span>...</span>
            <?php endif; ?>

            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if($page == $paginator->currentPage()): ?>
                        <li class="page-item active">
                            <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                               href=""><?php echo e($page); ?></a>
                        </li>
                    <?php else: ?>

                        <li class="page-item">
                            <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                               href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        </li>

                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($paginator->hasMorePages()): ?>
            <li class="page-item">
                <a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"
                   href="<?php echo e($paginator->nextPageUrl()); ?>"><?php echo e(trans('site.next')); ?></a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>



    
    
    
    
    