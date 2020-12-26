<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php $this->template('profile/profile_info.php', $vars); ?>
</div>
<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<div id="photos" person_id="<?php echo $person['id']?>"></div></div>

<script type="text/javascript" src="/js/photos.js"></script>
<?php
$this->template('/common/footer.php');
?>