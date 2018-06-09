<section class="d-block px-3 mt-5">
  <table class="table table-sm">
    <thead>
      <tr>
          <th scope="col">#</th>
          <th scope="col">name</th>
          <th scope="col">photo</th>
          <th scope="col">description</th>
          <th scope="col">price</th>
          <th scope="col">Link</th>
      </tr>
    </thead>
    <tbody>
        <?foreach (self::$data['list'] as $listIndex => $item) {?>
          <tr>
            <td><?=$listIndex?></td>
            <td><?=$item['name']?></td>
            <td class="product-list-photo">
              <img src="<?="/assets/images/products/".$item['photo']?>" alt="">
            </td>
            <td><?=$item['description']?></td>
            <td><?=$item['price']?></td>
            <td>
              <a href="/controllProducts/showOne/<?=$item['id']?>">Edit</a>
            </td>
          </tr>
        <?}?>
    </tbody>
  </table>
</section>
