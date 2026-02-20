@extends('Backend.layouts.master')
@section('title')
    Inventory
@endsection
@section('body-content')
    <div class="card">
        @if (session('inventory_success'))
            <div class="alert alert-success">{{ session('inventory_success') }}</div>
        @endif

        <div class="card-title option_sidebar"
            style="display: flex;justify-content: space-between;align-items: center;color: #566a7f;padding: 1.5rem;opacity: 0.8;margin-bottom: -40px;">
            <h5>Manage {{ $product->product_name }} Inventory Section</h5>
            <button type="button" class="text-right btn btn-primary" data-bs-toggle="modal" data-bs-target="#Add">Add
                Inventory</button>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="inventroyTable" width="100%" style="text-align: center;">
                    <thead>
                        <tr>
                            <th class="text-center">SL</th>
                            <th class="text-center">Color</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    <tbody>
                        @forelse ($inventories as $value)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $value->color->color_name }}</td>
                                <td>{{ $value->size->size_name }}</td>
                                <td>{{ $value->stock }}</td>
                                <td>{{ $value->price }}</td>
                                <td>
                                    <a class="text-white btn btn-sm btn-primary"
                                        href="{{ route('admin.inventory.edit', $value->id) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                    <a class="text-white btn btn-sm btn-danger"
                                        href="{{ route('admin.inventory.destroy', $value->id) }}"><i
                                            class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-danger">No Inventory Available</td>
                            </tr>
                        @endforelse
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal for add --}}
        <div class="modal fade" id="Add" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Add Inventory Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form name="form" action="{{ route('admin.inventory.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label for="code" class="form-label">Product </label>
                                    <input type="text" id="product_id" value="{{ $product->product_name }}"
                                        class="form-control" readonly>
                                    <input type="text" name="product_id" value="{{ $product->id }}"
                                        class="form-control" hidden>
                                    @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="color_id" class="form-label">Colors</label>
                                    <select name="color_id" id="color_id" class="form-select">
                                        <option>Select Color</option>
                                        @foreach ($colors as $value)
                                            <option value="{{ $value->id }}">{{ $value->color_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('color_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="size_id" class="form-label">Sizes</label>
                                    <select name="size_id" id="size_id" class="form-select">
                                        <option>Select Size</option>
                                        @foreach ($sizes as $value)
                                            <option value="{{ $value->id }}">{{ $value->size_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('size_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="stock" class="form-label">Stock </label>
                                    <input type="text" id="stock" name="stock" value="{{ old('stock') }}"
                                        class="form-control">
                                    @error('stock')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="price" class="form-label">Sale Price </label>
                                    <input type="text" id="price" name="price" value="{{ old('price') }}"
                                        class="form-control">
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12">
                                    <label for="old_price" class="form-label">Old Price </label>
                                    <input type="text" id="old_price" name="old_price" value="{{ old('old_price') }}"
                                        class="form-control">
                                    @error('old_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="modal-footer">
                                    <span class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </span>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal for edit --}}
        @if (isset($inventory))
            <div class="modal fade" id="Edit" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel3">Edit Inventory </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form name="form" action="{{ route('admin.inventory.update', $inventory->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf


                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label for="code" class="form-label">Product </label>
                                        <input type="text" id="product_id" value="{{ $product->product_name }}"
                                            class="form-control" readonly>
                                        <input type="text" name="product_id" value="{{ $product->id }}"
                                            class="form-control" hidden>
                                        @error('product_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="color_id" class="form-label">Colors</label>
                                        <select name="color_id" id="color_id" class="form-select">
                                            <option>Select Color</option>
                                            @foreach ($colors as $value)
                                                <option @if ($inventory->color_id) selected @endif
                                                    value="{{ $value->id }}">{{ $value->color_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('color_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="size_id" class="form-label">Sizes</label>
                                        <select name="size_id" id="size_id" class="form-select">
                                            <option>Select Size</option>
                                            @foreach ($sizes as $value)
                                                <option @if ($inventory->size_id) selected @endif
                                                    value="{{ $value->id }}">{{ $value->size_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('size_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="stock" class="form-label">Stock </label>
                                        <input type="text" id="stock" name="stock"
                                            value="{{ $inventory->stock }}" class="form-control">
                                        @error('stock')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-12">
                                        <label for="price" class="form-label">Price </label>
                                        <input type="text" id="price" name="price"
                                            value="{{ $inventory->price }}" class="form-control">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="old_price" class="form-label">Old Price </label>
                                        <input type="text" id="price" name="old_price"
                                            value="{{ $inventory->old_price }}" class="form-control">
                                        @error('old_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="modal-footer">
                                        <span class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </span>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
