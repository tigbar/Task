<?php

/**
 * @var \models\Product[] $products
 */
//echo dirname(dirname(__DIR__)); die;
include_once __DIR__ . '/../header.php';
//print_r($products);die;
?>


<form method="get" action="/">
    <input type="hidden" name="action" value="insert" />
    <b>Product Name</b>
    <input type="text" name="name" placeholder="Product name" /> <br/><br/>
    <b>Product Description</b>
    <textarea name="description" placeholder="Product description"></textarea><br/><br/>
    <b>Product Price</b>
    <input type="number" name="price" placeholder="Product price"><br/><br/>
    <input type="submit" value="Add Product" />
</form>

<br/>
<hr/>
<br/>

<form method="get" action="/">
    <input type='hidden' name="action" value="list"/>
<?php foreach ($products as $key=>$value):?>
    <input style="border: none;" type="text" name="Products[<?=$value->id?>]" value="<?=$value->id?>" /> &nbsp
    <input style="border: none;" type="text" name="Products[<?=$value->id?>][name]" value="<?=$value->name?>" /> &nbsp
    <input style="border: none;" type="num" name="Products[<?=$value->id?>][price]" value="<?=$value->price?>" /> &nbsp
    <input style="border: none;" type="text" name="Products[<?=$value->id?>][description]" value="<?=$value->description?>" /> &nbsp
    <input type="number" name="Products[<?=$value->id?>][count]" value="0" />
    <br/>
<?php endforeach?>
    <br/>
    <input type="submit" value="Add To Chart" />
</form>
