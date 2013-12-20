<?php

?>
<form actio="" method="post">
    <select name="category">
        <option value="0">None</option>
        {categories}
            <option value="{id}">{name}</option>
        {/categories}
    </select>
    <select name="subcategory">
        <option value="0">None</option>
        {subcategories}
            <option value="{id}">{name}</option>
        {/subcategories}
    </select>
    <input type="submit">
    <table border="1">
        <thead>
            <tr>
                <th>Select</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>subCategory</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($deals as $deal){
        ?>
        <tr>
            <td><input type="checkbox" name="check[]" value="<?=$deal->id?>"></td>
            <td><img src="<?=$deal->image_url?>" width="100"  height="100"></td>
            <td><?=$deal->title?></td>
            <td><?=substr($deal->description,0,100)?></td>
            <td><?=$deal->category?></td>
            <td><?=$deal->subcategory?></td>
        </tr>
        <?php }?>
        </tbody>
    </table>
    <input type="submit">
</form>