<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['active' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['active' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$classes = $active
    ? 'bg-blue-50 text-blue-600 font-semibold'
    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800';
?>

<a <?php echo e($attributes->merge(['class' => 'w-full flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors duration-150 ease-in-out ' . $classes])); ?>>
    <?php echo e($slot); ?>

</a>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/components/sidebar-nav-link.blade.php ENDPATH**/ ?>