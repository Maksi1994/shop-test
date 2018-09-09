<?
function build_tree($cats, $parent_id)
{
    if (is_array($cats) and isset($cats[$parent_id])) {
        $tree = "<li class='dropdown side-dropdown'>
<a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>Women’s Clothing <i class='fa fa-angle-right'></i></a>";
        foreach ($cats[$parent_id] as $cat) {
            $tree .= "<li class='item'>
        <img class='icon' src='/assets/icons/categories/{$cat['photo']}'>
        <a href='/backend/categories/showOne/{$cat['id']}' class='btn  mb-2 active btn-primary' role='button' aria-pressed='true'>{$cat['name']}</a>";

            $tree .= build_tree($cats, $cat['id']);
            $tree .= '</li>';


            <div class="custom-menu">
                <div class="row" >
                    <div class="col-md-4" >
                        <ul class="list-links" >
                            <li ><a href = "#" > Women’s Clothing </a ></li >
                            <li ><a href = "#" > Men’s Clothing </a ></li >
                            <li ><a href = "#" > Phones & Accessories </a ></li >
                            <li ><a href = "#" > Jewelry & Watches </a ></li >
                            <li ><a href = "#" > Bags & Shoes </a ></li >
                        </ul >
                        <hr class="hidden-md hidden-lg" >
                    </div >
                    <div class="col-md-4" >
                        <ul class="list-links" >
                            <li >
                                <h3 class="list-links-title" > Categories</h3 ></li >
                            <li ><a href = "#" > Women’s Clothing </a ></li >
                            <li ><a href = "#" > Men’s Clothing </a ></li >
                            <li ><a href = "#" > Phones & Accessories </a ></li >
                            <li ><a href = "#" > Jewelry & Watches </a ></li >
                            <li ><a href = "#" > Bags & Shoes </a ></li >
                        </ul >
                        <hr class="hidden-md hidden-lg" >
                    </div >
                    <div class="col-md-4" >
                        <ul class="list-links" >
                            <li >
                                <h3 class="list-links-title" > Categories</h3 ></li >
                            <li ><a href = "#" > Women’s Clothing </a ></li >
                            <li ><a href = "#" > Men’s Clothing </a ></li >
                            <li ><a href = "#" > Phones & Accessories </a ></li >
                            <li ><a href = "#" > Jewelry & Watches </a ></li >
                            <li ><a href = "#" > Bags & Shoes </a ></li >
                        </ul >
                    </div >
                </div >
            </div >
        </li >
        }

        $tree .= '</ul>';
    } else {
        $tree = '';
        return $tree;
    };

    return $tree;
}

?>

<div class="category-nav">
    <span class="category-header">Categories <i class="fa fa-list"></i></span>
    <ul class="category-list">

        <?= build_tree(self::$data['categories'], 0) ?>

        <li><a href="/products/getProducts/1/1">Men’s Clothing</a></li>

        <li class="dropdown side-dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Phones & Accessories <i
                        class="fa fa-angle-right"></i></a>
            <div class="custom-menu">
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-links">
                            <li>
                                <h3 class="list-links-title">Categories</h3></li>
                            <li><a href="#">Women’s Clothing</a></li>
                            <li><a href="#">Men’s Clothing</a></li>
                            <li><a href="#">Phones & Accessories</a></li>
                            <li><a href="#">Jewelry & Watches</a></li>
                            <li><a href="#">Bags & Shoes</a></li>
                        </ul>
                        <hr>
                        <ul class="list-links">
                            <li>
                                <h3 class="list-links-title">Categories</h3></li>
                            <li><a href="#">Women’s Clothing</a></li>
                            <li><a href="#">Men’s Clothing</a></li>
                            <li><a href="#">Phones & Accessories</a></li>
                            <li><a href="#">Jewelry & Watches</a></li>
                            <li><a href="#">Bags & Shoes</a></li>
                        </ul>
                        <hr class="hidden-md hidden-lg">
                    </div>
                    <div class="col-md-4">
                        <ul class="list-links">
                            <li>
                                <h3 class="list-links-title">Categories</h3></li>
                            <li><a href="#">Women’s Clothing</a></li>
                            <li><a href="#">Men’s Clothing</a></li>
                            <li><a href="#">Phones & Accessories</a></li>
                            <li><a href="#">Jewelry & Watches</a></li>
                            <li><a href="#">Bags & Shoes</a></li>
                        </ul>
                        <hr>
                        <ul class="list-links">
                            <li>
                                <h3 class="list-links-title">Categories</h3></li>
                            <li><a href="#">Women’s Clothing</a></li>
                            <li><a href="#">Men’s Clothing</a></li>
                            <li><a href="#">Phones & Accessories</a></li>
                            <li><a href="#">Jewelry & Watches</a></li>
                            <li><a href="#">Bags & Shoes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>