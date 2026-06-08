<h1>Create Purchase</h1>

<form method="post">

    <input
    type="text"
    name="supplier_name"
    placeholder="Supplier Name"
    >

    <br><br>

    <select name="product_id">

        <?php foreach($products as $product): ?>

            <option value="<?= $product->id ?>">

                <?= $product->name ?>

            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <input
    type="number"
    name="quantity"
    placeholder="Quantity"
    >

    <br><br>

    <button type="submit">

        Save Purchase

    </button>

</form>