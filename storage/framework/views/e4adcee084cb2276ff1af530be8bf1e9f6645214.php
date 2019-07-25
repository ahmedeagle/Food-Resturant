
<?php if($slot == "1"): ?>

    <a href="<?php echo e(url("/restaurant/reservations/reservation-details/" . $id)); ?>"
       class="btn btn-pending mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        <?php echo e($statusname); ?>

    </a>

<?php elseif($slot == "2"): ?>

    <a href="<?php echo e(url("/restaurant/reservations/reservation-details/" . $id)); ?>"
       class="btn btn-success mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        <?php echo e($statusname); ?>

    </a>

<?php elseif($slot == "3"): ?>

    <a href="<?php echo e(url("/restaurant/reservations/reservation-details/" . $id)); ?>"
       class="btn btn-danger mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        <?php echo e($statusname); ?>

    </a>

<?php elseif($slot == "4"): ?>

    <a href="<?php echo e(url("/restaurant/reservations/reservation-details/" . $id)); ?>"
       class="btn btn-warning mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        <?php echo e($statusname); ?>

    </a>

<?php endif; ?>




