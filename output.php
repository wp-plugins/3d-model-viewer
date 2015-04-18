
<div id="<?php echo $options['id'] ?>"<?php if ($options['cssClass']) echo ' class="'.$options['cssClass'].'"'?><?php if ($options['cssStyle']) echo ' style="'.$options['cssStyle'].'"'?>></div>

<script>

var wp3d = null;

window.onload = function() {
    options = <?php echo json_encode($options) ?>;

    wp3d = new WP3D('<?php echo $model ?>', options);

    render();
}
</script>

