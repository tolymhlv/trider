<?php defined('_JEXEC') or die(); ?>
<?php if ($this->allow_review || $this->config->show_hits){?>
<div class="review-hits">    
    <?php if ($this->allow_review){?>
    <div class="review-rating"><span class="lbl-rating"><?php print _JSHOP_RATING?>: </span>		<span class="pro-rating"><?php print showMarkStar($this->product->average_rating);?></span>
	</div>
    <?php } ?>
	<?php if ($this->config->show_hits){?>
    <div class="hits" title="<?php print _JSHOP_HITS?>"><i class="icon-eye-open"></i><span><?php print $this->product->hits;?></span></div>
    <?php } ?>
</div>
<?php } ?>