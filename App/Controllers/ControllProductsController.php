<?
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\UserModel;

class ControllProductsController {

  function __construct() {
      $userModel = new UserModel;

      if (!$userModel->getCurrUser()) {
          header('location: /user/login');
          exit;
      }
  }

  public function showAll($cat = 'all', $page = 1) {
    $productModel = new ProductModel;
    $list = $productModel->getAllProducts($cat, $page);
    $count = $productModel->getCountProducts($cat);

    return [
        'list'=> $list,
        'page'=> $page,
        'cat' => $cat,
        'count'=> $pagesCount,
      ];
  }

  public function showOne($id) {
    $productModel = new ProductModel;
    $product = $productModel->getOneProduct($id);



    if (!isset($product)) {
      header('location: //controllProducts/showAll');
    }

    $product['promotions'] = $productModel->getPromotions($id);
    // return $product;
  }

  public function showFormAdd($err = null) {
    $productModel = new ProductModel;
    $errMessage = '';
    $allCategories = $productModel->getAllCategories();

    if ($err === 'failed') {
      $errMessage = 'Uploaded Error.';
    }

    return [
      'errMessage' => $errMessage,
      'categories' => $allCategories
    ];

  }

  public function updateProduct() {
    $product = $POST['product'];
    $promotions = $POST['promotions'];

    $productModel = new ProductModel;
    $productModel->updateProduct($product['id'], $product);
    $productModel->updateProductPromotions($product['id'], $promotions);
  }

  public function addOne() {
      $productModel = new ProductModel;
      $isUploaded = $_FILES['photo']['error'] === \UPLOAD_ERR_OK;

      if ($isUploaded && isset($_POST['name'],
        $_POST['description'],
        $_POST['category_id'],
        $_POST['price'],
        $_POST['count'],
        $_FILES['photo']
      )) {
        $photoName = time().$_FILES['photo']['name'];
        $uploadsDir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/products';
        move_uploaded_file($_FILES['photo']['tmp_name'], "$uploadsDir/$photoName");

        $_POST['photo'] = $photoName;
        $isSucces = $productModel->addOne($_POST);

        if ($isSucces) {
          $category = $productModel->getCategoryById($_POST['category_id']);

          header("location: /controllProducts/showAll/{$category['name']}");
        } else {
          header("location: /controllProducts/showFormAdd/");
        }
      }
  }

  public function deleteOne($id, $category) {
      $productModel = new ProductModel;
      $productModel->deleteOne($id);
      header("location: /controllProducts/showAll");
  }
}
