<?php defined('_JEXEC') or die(); ?>
<?php if ($this->params->get('show_page_heading') && $this->params->get('page_heading')) {?>    
<div class="shophead<?php print $this->params->get('pageclass_sfx');?>"><h1><?php print $this->params->get('page_heading')?></h1></div>
<?php }?>
<div class="jshop">
<?php print $this->category->description?>

<div class="jshop_list_category">
<?php if (count($this->categories)){?>
<div class = "jshop">
    <?php foreach($this->categories as $k=>$category){?>
        <?php if ($k%$this->count_category_to_row==0) print "<div class='sj-row clearfix'>"; ?>
        <?php /*?><div class = "jshop_categ" width = "<?php print (100/$this->count_category_to_row)?>%"><?php */?>
		<div class = "jshop_categ sj-column span<?php print floor(12/$this->count_category_to_row);?>">
          <div class = "category">
               <div class="image">
                    <a href = "<?php print $category->category_link;?>"><img class = "jshop_img" src = "<?php print $this->image_category_path;?>/<?php if ($category->category_image) print $category->category_image; else print $this->noimage;?>" alt="<?php print htmlspecialchars($category->name);?>" title="<?php print htmlspecialchars($category->name);?>" /></a>
               </div>
               <div class="info">
                   <a class = "product_link" href = "<?php print $category->category_link?>"><?php print $category->name?></a>
                   <p class = "category_short_description"><?php print $category->short_description?></p>
               </div>
           </div>
        </div>    
        <?php if ($k%$this->count_category_to_row==$this->count_category_to_row-1) print '</div>'; ?>    
    <?php } ?>
        <?php if ($k%$this->count_category_to_row!=$this->count_category_to_row-1) print '</div>'; ?>    
</div>
<?php } ?>
</div>
</div>