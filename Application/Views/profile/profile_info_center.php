<?php $this->template('profile/topheader.php', $vars); ?>

<div class="topinfo">
<div class="important">

<?php
if (! empty($vars['person']['status'])) {?>
<div class="status"><?php echo $vars['person']['status']; ?></div>
<?php } ?>


<table class="result">
<?php
if (! empty($vars['person']['date_of_birth'])) {?>
<tr>
<td><?php echo $this->t('profile','Birthday'); ?>:</td>
<td><?php echo strftime('%d.%m.%Y', $vars['person']['date_of_birth']);?></td>
</tr>
<?php } 
if (! empty($vars['person']['gender'])) {?>
<tr>
<td><?php echo $this->t('profile','Gender'); ?>:</td>
<td><?php echo $vars['person']['gender'] == 'MALE' ?  $this->t('home','Male') : $this->t('home','Female')?></td>
</tr>
<?php } ?> 

<?php 

if (! empty($vars['person']['person_emails'])) {?>
<tr>
<td><?php echo $this->t('common','email'); ?>:</td>
<td><?php foreach ($vars['person']['person_emails'] as $email) { echo "<a href='mailto:".$email['email']."'>".$email['email']."</a><br>";} ?></td>

</tr>
<?php } 
if ($vars['person']['person_phone_numbers']) {?>
<tr>
<td><?php echo $this->t('profile','Phone'); ?>:</td>
<td><?php 
		foreach ($vars['person']['person_phone_numbers'] as $phone_number) {
    		echo $phone_number['phone_number']."\n";
    	}
	?>    	
</td>
</tr>
<?php } ?> 

</table>


<a href="#" id="detail" class="icon"><?php echo $this->t('profile','details'); ?></a>
</div>

<div class="nonimportant">
<table class="result">

<?php 
if (! empty($vars['person']['activity'])) {?>
<tr>
<td><?php echo $this->t('profile','Activity'); ?>:</td>
<td><?php echo isset($vars['person']['activity']) ? $vars['person']['activity'] : '' ?></td>
</tr>
<?php
} 
if (! empty($vars['person']['job']['company'])) {?>
<tr>
<td><?php echo $this->t('profile','Company'); ?>:</td>
<td><?php echo isset($vars['person']['job']['company']) ? $vars['person']['job']['company'] : '' ?></td>
</tr>
<?php
} 
if (! empty($vars['person']['religion'])) {?>
<tr>
<td><?php echo $this->t('profile','Relationship status'); ?>:</td>
<td><?php echo $vars['person']['relationship_status']?>
</td>
</tr>
<?php } 
if (! empty($vars['person']['person_urls'])) {?>
<tr>
<td><?php echo $this->t('profile','urls'); ?>:</td>
<td><?php foreach ($vars['person']['person_urls'] as $url) { echo "<a href='".$url['url']."'>".$url['url']."</a><br>";} ?></td>
</tr>
<?php } ?>
<?php 
if (! empty($vars['person']['looking_for'])) {
?>
<tr>
<td><?php echo $this->t('profile','Looking for'); ?>:</td>
<td><?php echo $vars['person']['looking_for'] ?></td>
</tr>
<?php
}
if (! empty($vars['person']['political_views'])) {
?>
<tr>
<td><?php echo $this->t('profile','Political views'); ?>:</td>
<td><?php echo $vars['person']['political_views'] ?></td>
</tr>
<?php
}
if (! empty($vars['person']['religion'])) {
?>
<tr>
<td><?php echo $this->t('profile','Religion'); ?>:</td>
<td><?php echo $vars['person']['religion'] ?></td>
</tr>
<?php
}
if (! empty($vars['person']['children'])) {
?>
<tr>
<td><?php echo $this->t('profile','Children'); ?>:</td>
<td><?php echo $vars['person']['children'] ?></td>
</tr>
<?php
}
if (! empty($vars['person']['drinker'])) {
?>
<tr>
<td><?php echo $this->t('profile','Drinker'); ?>:</td>
<td><?php echo ucwords(strtolower($vars['person']['drinker'])) ?></td>
</tr>
<?php
}
if (! empty($vars['person']['smoker'])) {
?>
<tr>
<td><?php echo $this->t('profile','Smoker'); ?>:</td>
<td><?php echo ucwords(strtolower($vars['person']['smoker'])) ?></td>
</tr>
<?php
}
if (! empty($vars['person']['ethnicity'])) {
?>
<tr>
<td><?php echo $this->t('profile','Ethnicity'); ?>:</td>
<td><?php echo ucwords($vars['person']['ethnicity']) ?></td>
</tr>
<?php
}
if (! empty($vars['person']['about_me'])) {
?>
<tr>
<td><?php echo $this->t('profile','About me'); ?>:</td>
<td><?php echo ucwords($vars['person']['about_me']) ?></td>
</tr>
<?php
}
if (! empty($vars['person']['happiest_when'])) {
?>
<tr>
<td><?php echo $this->t('profile','Happiest when'); ?>:</td>
<td><?php echo ucwords($vars['person']['happiest_when']) ?></td>
</tr>
<?php
}
if (! empty($vars['person']['job_interests'])) {
?>
<tr>
<td><?php echo $this->t('profile','Job interests'); ?>:</td>
<td><?php echo $vars['person']['job_interests'] ?></td>
</tr>
<?php
}
if (! empty($vars['person']['pets'])) {
?>
<tr>
<td><?php echo $this->t('profile','Pets'); ?>:</td>
<td><?php echo $vars['person']['pets'] ?></td>
</tr>
<?php
}
if (! empty($vars['person']['scared_of'])) {
	?>
<tr>
<td><?php echo $this->t('profile','Scared of'); ?>:</td>
<td><?php echo $vars['person']['scared_of'] ?></td>
</tr>
<?php
}

if (! empty($vars['person']['about'])) {
	?>
<tr>
<td><?php echo $this->t('profile','about'); ?>:</td>
<td><?php echo $vars['person']['about'] ?></td>
</tr>
<?php
}

if (! empty($vars['person']['doing'])) {
	?>
<tr>
<td><?php echo $this->t('profile','doing'); ?>:</td>
<td><?php echo $vars['person']['doing'] ?></td>
</tr>
<?php
}
if (! empty($vars['person']['interest'])) {
	?>
<tr>
<td><?php echo $this->t('profile','interest'); ?>:</td>
<td><?php echo $vars['person']['interest'] ?></td>
</tr>
<?php
}

if (! empty($vars['person']['music'])) {
	?>
<tr>
<td><?php echo $this->t('profile','music'); ?>:</td>
<td><?php echo $vars['person']['music'] ?></td>
</tr>
<?php
}

if (! empty($vars['person']['books'])) {
	?>
<tr>
<td><?php echo $this->t('profile','books'); ?>:</td>
<td><?php echo $vars['person']['books'] ?></td>
</tr>
<?php
}

if (! empty($vars['person']['tv'])) {
	?>
<tr>
<td><?php echo $this->t('profile','tv'); ?>:</td>
<td><?php echo $vars['person']['tv'] ?></td>
</tr>
<?php
}

if (! empty($vars['person']['quote'])) {
	?>
<tr>
<td><?php echo $this->t('profile','quote'); ?>:</td>
<td><?php echo $vars['person']['quote'] ?></td>
</tr>
<?php
}


?>
</table>
</div>
</div>
  