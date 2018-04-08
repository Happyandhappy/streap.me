<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
$this->assign('title',  $title);
$this->Html->script('links-display.js', ['block' => 'scriptBottom']);

$cookie = null;
if (isset($_COOKIE[$link->slug]))
    $cookie = explode(',',$_COOKIE[$link->slug]);
// debug($cookie);
$count = 0;
?>
<style>
body {
	    font-family: Raleway;
}

.action-button {
	height: 50px;
    border-radius: 10px;
	border: none;
}

.btn-success {
	background-color: #FF0000;
	height: 50px;
    border-radius: 10px;
	border: none;
}
.fa {
	font-size: 30px;
}
.youtube {
	background-color: #FF0000;
}
.instagram {
	background-color: #EA0D70;
}
.discord {
	background-color: #7289DA;
}

.snapchat {
    	background-color: yellow;
        color: #000;
}

.fa-ic1  { 
    float: left;
}
.fa-ic2  { 
    float: right;
}
</style>
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:900" rel="stylesheet">
<div class="container-fluid">

	<div class="row">
		<div class="col-xl-12">
			<div class="centered text-center" style="box-shadow: rgba(223, 223, 223, 0.5) 0px 14px 24px; padding: 30px;">
				<h1><?= h($link->heading) ?></h1>
				<ul id="link-button-list" class="list-unstyled">
				<?php $index = 0;
				 foreach ($link['actions'] as $action) :
					$flag = false;
					if (isset($cookie)):
						foreach ($cookie as $ckie):
							if ($ckie == $this->Url->build(['controller' => 'Actions', 'action' => 'forward', $action->id])):
								$flag = true;
								$count++;
							endif;
						endforeach;
					endif;?>

				<?php if ($action->platform) : ?>
						<li class="list-item">
							<?php if ($flag):?>
							<?= $this->Form->button('<span style="float: left;" class="fab fa-' . h($action->platform) . ' fa-2x"></span>
														<span style="vertical-align: middle;
														display: inline-block;
														width: auto;
														padding: 5px 0px 0px 10px;
														line-height: 21px;
														font-size: 17px;
														margin-top: -1px;"> ' . h($action->name) . ' </span><span id="symbol" style="float: right" class="fas  fa-check-circle fa-2x"></span>', ['class' => 'btn btn-block btn-primary action-button ' . h($action->platform) . '', 'data-url' => $this->Url->build(['controller' => 'Actions', 'action' => 'forward', $action->id])]) ?>
							<?php else:?>
							<?= $this->Form->button('<span style="float: left; width:28px;hight:32px;" class="fab fa-' . h($action->platform) . ' fa-2x"></span><span style="vertical-align: middle;
														display: inline-block;
														width: auto;
														padding: 5px 0px 0px 10px;
														line-height: 21px;
														font-size: 17px;
														margin-top: -1px;"> ' . h($action->name) . ' </span><span  id="symbol" style="float: right; width:16px; height:32px;"></span>', ['class' => 'btn btn-block btn-primary action-button ' . h($action->platform) . '', 'data-url' => $this->Url->build(['controller' => 'Actions', 'action' => 'forward', $action->id])]) ?>							
							<?php endif;?>
						</li>
			    <?php else :?>
			        <li class="list-item">
						<?php if ($flag) : ?>
						<?= $this->Form->button('<span style="float: left" class="fab fa-youtube fa-2x"></span><span style="vertical-align: middle;
														display: inline-block;
														width: auto;
														padding: 5px 0px 0px 10px;
														line-height: 21px;
														font-size: 17px;
														margin-top: -1px;"> ' . h($action->name) . ' </span><span style="float: right" class="fas fa-check-circle fa-2x"></span>', ['class' => 'btn btn-block btn-primary action-button youtube', 'data-url' => $this->Url->build(['controller' => 'Actions', 'action' => 'forward', $action->id])]) ?>
						<?php else : ?>
						<?= $this->Form->button('<span style="float: left" class="fab fa-youtube fa-2x"></span><span style="vertical-align: middle;
														display: inline-block;
														width: auto;
														padding: 5px 0px 0px 10px;
														line-height: 21px;
														font-size: 17px;
														margin-top: -1px;"> ' . h($action->name) . ' </span><span style="float: right;width:16px; height:32px;"></span>', ['class' => 'btn btn-block btn-primary action-button youtube', 'data-url' => $this->Url->build(['controller' => 'Actions', 'action' => 'forward', $action->id])]) ?>
						<?php endif; ?>
				   </li>
			    <?php endif; $index++;?>
			    <?php endforeach; ?>
			    	<!-- <li class="list-item small"><span class="fas fa-arrow-up"></span> Complete above to unlock below <span class="fas fa-arrow-down"></span></li> -->
			    	<li class="list-item">
						<?php 
						if (isset($cookie) && count($link['actions']) == $count):?>
							<?= $this->Form->button(h($link->button_label), ['disabled' => false, 'escape' => false, 'id' => 'link-success-button', 'class' => 'btn btn-block btn-success', 'data-url' => $this->Url->build(['action' => 'forward', $link->slug]),'disabled'=>false]) ?>
						<?php else:?>
							<?= $this->Form->button(h($link->button_label), ['disabled' => true, 'escape' => false, 'id' => 'link-success-button', 'class' => 'btn btn-block btn-success', 'data-url' => $this->Url->build(['action' => 'forward', $link->slug]),'disabled'=>true]) ?>
						<?php endif;?>
					</li>
					<input type="hidden" id = "clickCount" value = "<?=$count?>">
				</ul>
				<div>
			<div><div style="color:#666; text-align:left; font-size:12px;">Ads by Google</div>
<div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Medium Rectangle -->
<ins class="adsbygoogle adslot_1"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-5632965130204945"
     data-ad-slot="4393537518"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
		   </div>
				</div>
			</div>
		</div>
	</div>
</div>