<div class="hero">
    <h1><?php echo $title;?></h1>
    <p><?php echo $body; ?></p>
    <?php if($link == "" || $button_text == "") : ?>
        <a style="display: none;"></a>
    <?php else : ?>
        <a href="<?php echo $link?>" class="btn-blue"><?php echo $button_text?></a>
    <?php endif; ?>
</div>