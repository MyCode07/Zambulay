<?php
$cookies = get_localized_field('kuki_popap');
if (!$cookies) return;
?>
<div class="cookies _hide" inert aria-hidden="true">
    <p class="text-s"><?php echo $cookies['tekst'] ?></p>
    <button type="button" class="arrow-btn text-m" data-accept-cookies><?php echo $cookies['knopka'] ?></button>
</div>