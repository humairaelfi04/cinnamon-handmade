@if ($errors->any())
    <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
        <strong>Oops! Ada beberapa masalah:</strong>
        <ul style="margin: 10px 0 0 20px; padding: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="type">Tipe Produk</label>
    <select name="type" id="product-type-select" class="form-control">
        <option value="single" @if(old('type', $product->type ?? 'single') == 'single') selected @endif>Produk Tunggal</option>
        <option value="bundle" @if(old('type', $product->type ?? '') == 'bundle') selected @endif>Paket Hemat (Bundle)</option>
    </select>
</div>

<div class="form-group">
    <label for="name">Nama Produk / Paket</label>
    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="category_id">Kategori</label>
    <select name="category_id" id="category_id" class="form-control">
        <option value="">Pilih Kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @if(old('category_id', $product->category_id ?? '') == $category->id) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description" class="form-control" rows="5" required>{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="price">Harga</label>
    <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
</div>

<div class="form-group">
    <label for="stock">Stok</label>
    <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? '') }}" required>
</div>

<div class="form-group">
    <label for="is_visible">Visibilitas</label>
    <select name="is_visible" id="is_visible" class="form-control">
        <option value="1" @if(old('is_visible', $product->is_visible ?? true) == true) selected @endif>Tampilkan</option>
        <option value="0" @if(old('is_visible', $product->is_visible ?? true) == false) selected @endif>Sembunyikan</option>
    </select>
</div>

{{-- KOTAK BARU UNTUK MEMILIH ISI PAKET --}}
<div class="form-group" id="bundle-products-container" style="display: none;">
    <label>Pilih Isi Paket</label>
    <div class="bundle-product-list">
        @forelse($singleProducts as $singleProduct)
            <label class="bundle-option">
                <input type="checkbox" name="bundled_products[]" value="{{ $singleProduct->id }}"
                    @if(isset($product) && in_array($singleProduct->id, old('bundled_products', $product->bundledProducts->pluck('id')->toArray() ?? []))) checked @endif
                >
                {{ $singleProduct->name }} (Rp {{ number_format($singleProduct->price, 0) }})
            </label>
        @empty
            <p>Tidak ada produk tunggal yang bisa ditambahkan.</p>
        @endforelse
    </div>
</div>

{{-- BAGIAN BARU UNTUK TAG FILTER --}}
<div class="form-group tags-container">
    <label>Tag Filter Produk</label>
    <small style="display: block; margin-top: -8px; margin-bottom: 15px;">Pilih tag yang sesuai untuk membantu customer menemukan produk ini.</small>

    @foreach ($tags->groupBy('type') as $type => $groupedTags)
        <div class="tag-group">
            <h5>{{ $type }}</h5>
            <div class="tag-list">
                @foreach ($groupedTags as $tag)
                    <div>
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}"
                            @if(isset($product) && in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray() ?? []))) checked @endif
                        >
                        <label for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<div class="form-group">
    <label for="image">Gambar Produk</label>
    <input type="file" id="image" name="image" class="form-control">
    @if(isset($product) && $product->image)
        <div style="margin-top: 10px;">
            <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar saat ini" style="width: 100px; border-radius: 6px;">
        </div>
    @endif
</div>

@push('styles')
<style>
    .bundle-product-list { max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 6px; }
    .bundle-option { display: block; margin-bottom: 5px; }
    .tags-container { padding: 20px; border: 1px solid var(--light-border); border-radius: 8px; margin-top: 20px; }
    .tag-group { margin-bottom: 15px; }
    .tag-group h5 { margin-top: 0; margin-bottom: 10px; font-weight: 500; color: var(--primary-brown); }
    .tag-list { display: flex; flex-wrap: wrap; gap: 10px; }
    .tag-list label { display: inline-block; background-color: #f1f1f1; padding: 5px 12px; border-radius: 20px; font-size: 0.9rem; cursor: pointer; transition: background-color 0.3s; }
    .tag-list input[type="checkbox"] { display: none; }
    .tag-list input[type="checkbox"]:checked + label { background-color: var(--primary-brown); color: white; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('product-type-select');
        const bundleContainer = document.getElementById('bundle-products-container');

        function toggleBundleOptions() {
            if (typeSelect.value === 'bundle') {
                bundleContainer.style.display = 'block';
            } else {
                bundleContainer.style.display = 'none';
            }
        }

        toggleBundleOptions();

        typeSelect.addEventListener('change', toggleBundleOptions);
    });
</script>
@endpush
