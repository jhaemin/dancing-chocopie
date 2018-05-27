<div class="page-selector-container noselect">
	<!-- <a href="index.php?page=<?php echo $page_display_num . $search_get; ?>" class="page-selector-link <?php if ($page_display_num == $page) echo 'current'; ?>">
		<div class="page-selector">1</div>
	</a> -->
	<?php if ($page_num_start > 1) { ?>
	<a href="index.php?page=<?php echo $page_num_start - 1; ?>" class="page-selector-link">
		<div class="page-selector">이전</div>
	</a>
	<?php } ?>

	<?php
	for ($i=0; $i<$page_num; $i++) {
		$page_display_num = $page_num_start + $i;
		// if max page number is smaller than the number of displayed page
		if ($page_display_num > $max_page) {
			break;
		}
	?>
	<a href="index.php?page=<?php echo $page_display_num . $search_get; ?>" class="page-selector-link <?php if ($page_display_num == $page) echo 'current'; ?>">
		<div class="page-selector"><?php echo $page_display_num; ?></div>
	</a>
	<?php } ?>

	<?php if ($page_display_num < $max_page) { ?>
	<a href="index.php?page=<?php echo $page_num_start + $i; ?>" class="page-selector-link">
		<div class="page-selector">다음</div>
	</a>
	<?php } ?>
</div>
