<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productCategories as $productCategory)
        <tr>
            <td>{{ $productCategory->id }}</td>
            <td>{{ $productCategory->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
