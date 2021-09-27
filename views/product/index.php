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
<?php foreach ($products as $product):?>
    <input style="border: none;" type="text" name="Products[<?=$product->id?>][name]" value="<?=$product->name?>" /> &nbsp
    <input style="border: none;" type="num" name="Products[<?=$product->id?>][price]" value="<?=$product->price?>" /> &nbsp
    <input style="border: none;" type="text" name="Products[<?=$product->id?>][description]" value="<?=$product->description?>" /> &nbsp
    <input type="number" name="Products[<?=$product->id?>][count]" value="0" />
    <br/>
<?php endforeach?>
    <br/>
    <input type="submit" value="Add To Chart" />
</form>
