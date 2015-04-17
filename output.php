
<div id="<?php echo $options['id'] ?>"<?php if ($options['cssClass']) echo ' class="'.$options['cssClass'].'"'?><?php if ($options['cssStyle']) echo ' style="'.$options['cssStyle'].'"'?>></div>

<script>

    options = <?php echo json_encode($options) ?>;

    var wp3d = new WP3D('<?php echo $model ?>', options);

    render();
</script>

