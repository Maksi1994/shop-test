<?php
function build_tree($cats, $parent_id)
{
    if (is_array($cats) and isset($cats[$parent_id])) {
        $tree = '<ul class="m-0 d-table categories-tree">';
        foreach ($cats[$parent_id] as $cat) {
            $tree .= "<li class='item'> 
            <img class='icon' src='/assets/icons/categories/{$cat['photo']}'>
            <a href='/backend/categories/showOne/{$cat['id']}' class='btn  mb-2 active btn-primary' role='button' aria-pressed='true'>{$cat['name']}</a>";
            
            $tree .= build_tree($cats, $cat['id']);
            $tree .= '</li>';
        }

        $tree .= '</ul>';
    } else return null;

    return $tree;
}
?>

<div class="container controll-categories list x-auto mt-5">
   <?=build_tree(self::$data['categories'], 0)?>
    <a class="controll-add-btn bg-primary" href="/backend/categories/showFormAdd">+</a>
</div>
