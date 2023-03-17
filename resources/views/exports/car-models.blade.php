<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Brand</th>
    </tr>
    </thead>
    <tbody>
    @foreach($carModels as $carModel)
        <tr>
            <td>{{ $carModel->id }}</td>
            <td>{{ $carModel->name }}</td>
            <td>{{ $carModel->description }}</td>
            <td>{{ $carModel->brand->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
