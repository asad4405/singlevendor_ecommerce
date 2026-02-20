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
            <h5>Manage Inventory Edit Section</h5>
            <button type="button" class="text-right btn btn-primary" data-bs-toggle="modal" data-bs-target="#Add">Add
                Inventory</button>
        </div>

        <div class="card-body">
            <form name="form" action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="code" class="form-label">Product </label>
                                <input type="text" id="product_id" value="{{ $inventory->product->product_name }}"
                                    class="form-control" readonly>
                                <input type="text" name="product_id" value="{{ $inventory->product_id }}"
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
                                        <option @if ($inventory->color_id == $value->id) selected @endif
                                            value="{{ $value->id }}">
                                            {{ $value->color_name }}</option>
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
                                            value="{{ $value->id }}">
                                            {{ $value->size_name }}</option>
                                    @endforeach
                                </select>
                                @error('size_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-12">
                                <label for="stock" class="form-label">Stock </label>
                                <input type="text" id="stock" name="stock" value="{{ $inventory->stock }}"
                                    class="form-control">
                                @error('stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-12">
                                <label for="price" class="form-label">Sale Price </label>
                                <input type="text" id="price" name="price" value="{{ $inventory->price }}"
                                    class="form-control">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-12">
                                <label for="old_price" class="form-label">Old Price </label>
                                <input type="text" id="old_price" name="old_price" value="{{ $inventory->old_price }}"
                                    class="form-control">
                                @error('old_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
