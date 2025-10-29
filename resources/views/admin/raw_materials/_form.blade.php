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
    <label for="name">Nama Bahan Baku</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $rawMaterial->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="price">Harga Dasar (Rp)</label>
    <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $rawMaterial->price ?? '0') }}" required step="500">
</div>

<div class="form-group">
    <label for="accessory_type">Untuk Jenis Aksesoris</label>
    <select name="accessory_type" id="accessory_type" class="form-control">
        <option value="">Semua Jenis (Contoh: Batu)</option>
        <option value="Gelang/Kalung" @if(old('accessory_type', $rawMaterial->accessory_type ?? '') == 'Gelang/Kalung') selected @endif>Gelang / Kalung</option>
        <option value="Cincin" @if(old('accessory_type', $rawMaterial->accessory_type ?? '') == 'Cincin') selected @endif>Cincin</option>
    </select>
</div>

<div class="form-group">
    <label for="material_type">Tipe Bahan</label>
    <select name="material_type" id="material_type" class="form-control" required>
        <option value="Kerangka" @if(old('material_type', $rawMaterial->material_type ?? '') == 'Kerangka') selected @endif>Bahan Kerangka (Benang, Tembaga, Perak, dll.)</option>
        <option value="Batu Alam" @if(old('material_type', $rawMaterial->material_type ?? '') == 'Batu Alam') selected @endif>Batu Alam / Hiasan Utama</option>
    </select>
</div>

<div class="form-group">
    <label for="stock">Stok</label>
    <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $rawMaterial->stock ?? '0') }}" required step="any">
</div>

<div class="form-group">
    <label for="unit">Satuan</label>
    <input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit', $rawMaterial->unit ?? 'pcs') }}" required placeholder="Contoh: pcs, gram, cm">
</div>

<div class="form-group">
    <label for="image">Gambar Komponen (Untuk Builder)</label>
    <input type="file" name="image" id="image" class="form-control">
    @if(isset($rawMaterial) && $rawMaterial->image)
        <div style="margin-top: 10px;">
            <img src="{{ asset('storage/' . $rawMaterial->image) }}" alt="Current Image" style="width: 80px; height: 80px; border-radius: 6px;">
            <small>Gambar saat ini. Upload baru untuk mengganti.</small>
        </div>
    @endif
</div>

<button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan' }}</button>
