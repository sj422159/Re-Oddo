@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">List a New Item</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" id="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        <option value="tops" {{ old('type') === 'tops' ? 'selected' : '' }}>Tops</option>
                        <option value="bottoms" {{ old('type') === 'bottoms' ? 'selected' : '' }}>Bottoms</option>
                        <option value="dresses" {{ old('type') === 'dresses' ? 'selected' : '' }}>Dresses</option>
                        <option value="outerwear" {{ old('type') === 'outerwear' ? 'selected' : '' }}>Outerwear</option>
                        <option value="shoes" {{ old('type') === 'shoes' ? 'selected' : '' }}>Shoes</option>
                        <option value="accessories" {{ old('type') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                    <select name="size" id="size" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Size</option>
                        <option value="xs" {{ old('size') === 'xs' ? 'selected' : '' }}>XS</option>
                        <option value="s" {{ old('size') === 's' ? 'selected' : '' }}>S</option>
                        <option value="m" {{ old('size') === 'm' ? 'selected' : '' }}>M</option>
                        <option value="l" {{ old('size') === 'l' ? 'selected' : '' }}>L</option>
                        <option value="xl" {{ old('size') === 'xl' ? 'selected' : '' }}>XL</option>
                        <option value="xxl" {{ old('size') === 'xxl' ? 'selected' : '' }}>XXL</option>
                    </select>
                </div>

                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                    <select name="condition" id="condition" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Condition</option>
                        <option value="new" {{ old('condition') === 'new' ? 'selected' : '' }}>New with tags</option>
                        <option value="excellent" {{ old('condition') === 'excellent' ? 'selected' : '' }}>Excellent</option>
                        <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ old('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tags (comma separated)</label>
                <input type="text" name="tags" id="tags" value="{{ old('tags') }}" 
                       placeholder="e.g., vintage, designer, casual"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Images</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="text-sm text-gray-500 mt-1">You can upload multiple images. Maximum 2MB per image.</p>
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    Submit for Approval
                </button>
                <a href="{{ route('dashboard') }}" 
                   class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-400 transition font-medium text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
