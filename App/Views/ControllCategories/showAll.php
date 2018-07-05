<?php
function build_tree($cats, $parent_id)
{
    if (is_array($cats) and isset($cats[$parent_id])) {
        $tree = '<ul class="m-0 d-table ">';
        foreach ($cats[$parent_id] as $cat) {
            $tree .= "<li> <a href='/controllCategories/showOne/{$cat['id']}' class='btn  mb-2 active btn-primary' role='button' aria-pressed='true'>{$cat['name']}</a>";
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

    <a class="controll-add-btn bg-primary" href="/controllCategories/showFormAdd">+</a>
</div>
