<?
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

<div class="category-nav">
    <span class="category-header">Categories <i class="fa fa-list"></i></span>

    <ul class="menu">
        <li class="item">
            <div class="img-wrap">
                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
            </div>
            <a href="">
                sdasda
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="submenu">
                <li class="item">
                    <div class="img-wrap">
                        <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                    </div>
                    <a href="">
                        sdasda
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <ul class="submenu">
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
                        <li class="item"><div class="img-wrap">
                                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                            </div>
                            <a href="">
                                sdasda
                            </a></li>
                        <li class="item"> <div class="img-wrap">
                                <img class="img" src="/assets/icons/categories/icons8-котелок-64.png" alt="">
                            </div>
                            <a href="">
                                sdasda
                            </a></li>
                        <li class="item"> <div class="img-wrap">
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
</div>