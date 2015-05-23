<?php defined('_JEXEC') or die(); ?>
<div class="jshop shop-category">
<h1 class="header-category"><?php print $this->category->name?><span><?php print $this->category->short_description; ?></span></h1>
<?php print $this->category->description?>

<div class="jshop_list_category">
<?php if (count($this->categories)){ ?>
<div class = "jshop list_category">
    <?php foreach($this->categories as $k=>$category){?>
        <?php if ($k%$this->count_category_to_row==0) print "<div class='sj-row clearfix'>"; ?>
        <?php /*?><div class="jshop_categ" width="<?php print (100/$this->count_category_to_row)?>%"><?php */?>
		<div class="jshop_categ sj-column span<?php print floor(12/$this->count_category_to_row)?>">
          <div class = "category">
		  	 <div class="sj-column">            
				<div class="image">
					<a href = "<?php print $category->category_link;?>"><img class="jshop_img" src="<?php print $this->image_category_path;?>/<?php if ($category->category_image) print $category->category_image; else print $this->noimage;?>" alt="<?php print htmlspecialchars($category->name)?>" title="<?php print htmlspecialchars($category->name)?>" /></a>
				</div>
				<div>
				   <a class = "product_link" href = "<?php print $category->category_link?>"><?php print $category->name?></a>
				   <p class = "category_short_description"><?php print $category->short_description?></p>
				</div> 
			  </div>         
           </div>
        </div>    
        <?php if ($k%$this->count_category_to_row==$this->count_category_to_row-1) print '</div>'; ?>
    <?php } ?>
        <?php if ($k%$this->count_category_to_row!=$this->count_category_to_row-1) print '</div>'; ?>
</div>
<?php }?>
</div>
<?php include(dirname(__FILE__)."/products.php");?>
</div>