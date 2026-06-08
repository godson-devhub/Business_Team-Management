<h2>My Products</h2>

<a href="/seller/create-product" class="btn btn-success">+ Add Product</a>

<table class="table">
    <tr>
        <th>Name</th>
        <th>SKU</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>

    <?php foreach($products as $p): ?>
    <tr>
        <td><?= $p->name ?></td>
        <td><?= $p->sku ?></td>
        <td><?= $p->stock_quantity ?></td>
        <td><?= $p->selling_price ?></td>
        <td>
            <a href="/seller/update-product?id=<?= $p->id ?>">Edit</a>
            |
            <a href="/seller/delete-product?id=<?= $p->id ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>