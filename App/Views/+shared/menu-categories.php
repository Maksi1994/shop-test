<?
function build_tree($cats, $parent_id)
{
    if (is_array($cats) and !empty($cats[$parent_id])) {
        $tree = ' <ul class="menu">';
        foreach ($cats[$parent_id] as $cat) {
            $tree .= "<li class='item'>
       <div class='img-wrap'>
        <img class='img' src='/assets/icons/categories/{$cat['photo']}'>
       </div>
        <a href='/products/getProducts/1/{$cat['id']}' class='as fa-chevron-right'>{$cat['name']}
        ".(!empty($cats[$cat['id']]) && (is_array($cats[$cat['id']])) ? "<i class='fas fa-chevron-right'></i>" : "")."
        </a>";

            $tree .= build_tree($cats, $cat['id']);
            $tree .= '</li>';
        }

        $tree .= '</ul>';
    } else return null;

    return $tree;
}

?>

<div class="category-nav">
    <span class="category-header">Categories <i class="fa fa-list"></i></span>
     <!--
    <ul class="menu">
        <li class="item">
            <div class="img-wrap">
                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
            </div>
            <a href="">
                sdasda
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="menu">
                <li class="item">
                    <div class="img-wrap">
                        <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                    </div>
                    <a href="">
                        sdasda
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <ul class="menu">
                        <li class="item">
                            <div class="img-wrap">
                                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                            </div>
                            <a href="">
                                sdasda
                            </a></li>
                        <li class="item">
                            <div class="img-wrap">
                                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                            </div>
                            <a href="">
                                sdasda
                            </a>
                        </li>
                        <li class="item">
                            <div class="img-wrap">
                                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                            </div>
                            <a href="">
                                sdasda
                            </a></li>
                        <li class="item">
                            <div class="img-wrap">
                                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                            </div>
                            <a href="">
                                sdasda
                            </a></li>
                        <li class="item">
                            <div class="img-wrap">
                                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                            </div>
                            <a href="">
                                sdasda
                            </a></li>
                    </ul>

                </li>
                <li class="item"> dasda</li>
                <li class="item"> dasda</li>
                <li class="item"> dasda</li>
                <li class="item"> dasda</li>
            </ul>
        </li>
        <li class="item">
            <div class="img-wrap">
                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
            </div>
            <a href="">
                sdasda
            </a>
        </li>
    </ul>

    -->

    <?=build_tree($categories, 0)?>
</div>