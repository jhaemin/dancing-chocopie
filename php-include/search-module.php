<div class="search-module">
	<form class="search-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
		<select class="dcp-select auto-width-select" name="search_mode">
			<option value="title" <?php
			if (!empty($_GET['search_mode'])) {
				if ($_GET['search_mode'] == 'title')
					echo 'selected';
			}
			?>>제목</option>
			<option value="article" <?php
			if (!empty($_GET['search_mode'])) {
				if ($_GET['search_mode'] == 'article')
					echo 'selected';
			}
			?>>내용</option>
			<!-- <option value="title+article">제목+내용</option> -->
		</select>
		<input type="hidden" name="category" value="<?php echo $category; ?>">
		<input type="text" name="search" class="search-input dcp-input" placeholder="검색" autocomplete="off" />
		<button type="submit" class="search-button notap"></button>
	</form>
</div>
