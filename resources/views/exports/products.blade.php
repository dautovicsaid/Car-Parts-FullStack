<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Category</th>
        <th>Model</th>
        <th>Brand</th>
        <th>Year From</th>
        <th>Year To</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->productCategory->name }}</td>
            <td>{{ $product->carModel->name }}</td>
            <td>{{ $product->carModel->brand->name }}</td>
            <td>{{ $product->min_applicable_year }}</td>
            <td>{{ $product->max_applicable_year }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
