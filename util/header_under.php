<div class='header_under'>
    <form action="<?php echo SEARCH ;?>" class="Search">
        表示順序：
        <select name="sort">
            <?php foreach (SORT_ORDER as $key => $value) { ?>
                <option value="<?php echo $key; ?>"><?php echo $value;?></option>
            <?php } ?>
        </select>
        キーワード検索：
        <select name="category_id">
            <?php foreach (CATEGORIES as $id => $name) { ?>
                <option value="<?php echo $id; ?>"><?php echo $name;?></option>
            <?php } ?>
        </select>
        <input type="text" name="query"/>
        <input type="submit" value="Yahooショッピングで検索"/>
    </form>
</div>
