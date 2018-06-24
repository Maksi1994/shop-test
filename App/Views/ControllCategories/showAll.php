<?php
function build_tree($cats, $parent_id)
{
    if (is_array($cats) and isset($cats[$parent_id])) {
        $tree = '<ul class="m-0">';
        foreach ($cats[$parent_id] as $cat) {
            $tree .= '<li>' . $cat['name'];
            $tree .= '<a class="ml-3 badge badge-warning text-center pointer text-white" href="/controllCategories/showOne/'. $cat['id'] . '">edit</a>';
            $tree .= '<a class="ml-3 badge badge-danger text-center pointer text-white" href="/controllCategories/deleteOne/'. $cat['id'] . '">delete</a>';
            $tree .= build_tree($cats, $cat['id']);
            $tree .= '</li>';
        }

        $tree .= '</ul>';
    } else return null;

    return $tree;
}
?>

<div class="container list x-auto mt-5">
   <?=build_tree(self::$data['categories'], 0)?>
</div>
