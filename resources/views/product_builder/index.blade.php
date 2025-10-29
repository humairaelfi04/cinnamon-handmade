@extends('layouts.app')

@section('title', 'Rakit Aksesorismu')

@push('styles')
<style>
    .builder-container {
        display: grid;
        grid-template-columns: 1fr 450px;
        gap: 50px;
        align-items: start;
    }
    .builder-steps {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .step { margin-bottom: 30px; }
    .step-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 15px;
        border-bottom: 1px solid var(--light-border);
        padding-bottom: 10px;
    }
    .choice-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 15px;
    }
    .choice-item {
        cursor: pointer;
        border: 2px solid var(--light-border);
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        transition: all 0.2s ease-in-out;
    }
    .choice-item:hover, .choice-item.selected {
        border-color: var(--primary-brown);
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .choice-item img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        display: block;
        margin: 0 auto 5px auto;
    }
    .choice-item span {
        font-size: 0.8rem;
        font-weight: 500;
    }
    .builder-summary {
        position: sticky;
        top: 20px;
    }
    .preview-canvas {
        width: 100%;
        height: 450px;
        background: #fdfaf3;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--light-border);
    }
    .preview-layer {
        position: absolute;
        max-width: 80%;
        max-height: 80%;
        transition: opacity 0.3s ease, transform 0.3s ease;
        opacity: 0;
        transform: scale(0.9);
    }
    .preview-layer.visible {
        opacity: 1;
        transform: scale(1);
    }
    .price-display {
        background: var(--white-card);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        text-align: center;
    }
    .price-display small { font-size: 1rem; }
    .price-display .total-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-brown);
        margin: 5px 0;
    }
    .step-content, .kerangka-item {
        display: none; /* Sembunyikan semua step dan item kerangka di awal */
    }
    .checkbox-option {
        display: block;
        margin-bottom: 12px;
        cursor: pointer;
    }
    /* Style untuk input teks ukir nama */
    .details-input {
        display: none; /* Sembunyikan di awal */
        margin-top: 8px;
        margin-left: 25px; /* Sedikit menjorok ke dalam */
    }
    .details-input input {
        width: 100%;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid var(--light-border);
    }
</style>
@endpush

@section('content')
<div class="container">
    <h1>Rakit Produk Custom Anda</h1>
    <p>Ikuti langkah-langkah di bawah ini untuk menciptakan karya seni yang personal.</p>
    <hr style="border: none; border-top: 1px solid var(--light-border); margin: 20px 0 40px 0;">

    <form id="builder-form" action="{{ route('builder.addToCart') }}" method="POST">
        @csrf
        <div class="builder-container">
            {{-- KOLOM KIRI: PILIHAN LANGKAH DEMI LANGKAH --}}
            <div class="builder-steps">
                <!-- LANGKAH 1: PILIH JENIS AKSESORIS -->
                <div id="step-1" class="step">
                    <h3 class="step-title">Langkah 1: Tentukan Jenis Aksesoris</h3>
                    <div class="choice-grid">
                        <div class="choice-item" data-choice="Gelang/Kalung">
                            <img src="https://placehold.co/100x100/A07855/FFF?text=Gelang" alt="Gelang/Kalung">
                            <span>Gelang/Kalung</span>
                        </div>
                        <div class="choice-item" data-choice="Cincin">
                            <img src="https://placehold.co/100x100/A07855/FFF?text=Cincin" alt="Cincin">
                            <span>Cincin</span>
                        </div>
                    </div>
                </div>

                <!-- LANGKAH 2: PILIH BAHAN KERANGKA (Konten Dinamis) -->
                <div id="step-2" class="step step-content">
                    <h3 class="step-title">Langkah 2: Pilih Bahan Kerangka</h3>
                    <div class="choice-grid">
                        @foreach($bahanKerangka as $kerangka)
                            <div class="choice-item kerangka-item" data-price="{{ $kerangka->price }}" data-id="{{ $kerangka->id }}" data-image="{{ $kerangka->image ? asset('storage/' . $kerangka->image) : 'https://placehold.co/100x100/eeeeee/cccccc?text=No+Img' }}" data-accessory-type="{{ $kerangka->accessory_type }}">
                                <img src="{{ $kerangka->image ? asset('storage/' . $kerangka->image) : 'https://placehold.co/100x100/eeeeee/cccccc?text=No+Img' }}" alt="{{ $kerangka->name }}">
                                <span>{{ $kerangka->name }}</span>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="kerangka_id" id="kerangka_id">
                </div>

                <!-- LANGKAH 3: PILIH BATU ALAM (Konten Dinamis) -->
                <div id="step-3" class="step step-content">
                    <h3 class="step-title">Langkah 3: Pilih Batu Alam</h3>
                    <div class="choice-grid">
                         @foreach($batuAlam as $batu)
                            <div class="choice-item batu-item" data-price="{{ $batu->price }}" data-id="{{ $batu->id }}" data-image="{{ $batu->image ? asset('storage/' . $batu->image) : 'https://placehold.co/100x100/eeeeee/cccccc?text=No+Img' }}">
                                <img src="{{ $batu->image ? asset('storage/' . $batu->image) : 'https://placehold.co/100x100/eeeeee/cccccc?text=No+Img' }}" alt="{{ $batu->name }}">
                                <span>{{ $batu->name }}</span>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="batu_id" id="batu_id">
                </div>

                <!-- LANGKAH 4: PILIH TAMBAHAN -->
                <div id="step-4" class="step step-content">
                    <h3 class="step-title">Langkah 4: Opsi Tambahan (Opsional)</h3>
                     @foreach($customOptions as $option)
                        <div>
                            <label class="checkbox-option">
                                <!-- PERUBAHAN DI SINI: Menambahkan atribut data-target -->
                                <input class="addon-checkbox" type="checkbox" name="custom_options[]" value="{{ $option->id }}" data-price="{{ $option->price }}"
                                       @if(str_contains(strtolower($option->name), 'ukir')) data-details-target="#details-for-{{ $option->id }}" @endif>
                                {{ $option->name }} (+Rp {{ number_format($option->price, 0, ',', '.') }})
                            </label>

                            <!-- PERUBAHAN DI SINI: Menambahkan input teks yang tersembunyi -->
                            @if(str_contains(strtolower($option->name), 'ukir'))
                                <div class="details-input" id="details-for-{{ $option->id }}">
                                    <input type="text" name="addon_details[{{ $option->id }}]" placeholder="Tuliskan nama/inisial di sini...">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- KOLOM KANAN: PREVIEW & HARGA --}}
            <div class="builder-summary">
                <div class="preview-canvas">
                    <img id="preview-kerangka" class="preview-layer" src="" alt="Preview Kerangka">
                    <img id="preview-batu" class="preview-layer" src="" alt="Preview Batu">
                </div>
                <div class="price-display">
                    <small>Total Harga</small>
                    <div id="total-price" class="total-price">Rp 0</div>
                    <button type="submit" class="btn btn-detail" style="width: 100%; margin-top: 15px;">Tambahkan ke Keranjang</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selections = {
        kerangka: { id: null, price: 0 },
        batu: { id: null, price: 0 },
        addons: []
    };

    const steps = {
        step2: document.getElementById('step-2'),
        step3: document.getElementById('step-3'),
        step4: document.getElementById('step-4')
    };

    function updatePrice() {
        let totalPrice = 0;
        totalPrice += selections.kerangka.price;
        totalPrice += selections.batu.price;
        selections.addons.forEach(addon => {
            totalPrice += addon.price;
        });

        const formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(totalPrice);
        document.getElementById('total-price').textContent = formattedPrice.replace('Rp', 'Rp ');
    }

    function resetStep(stepNumber) {
        if (stepNumber <= 2) {
            selections.kerangka = { id: null, price: 0 };
            document.querySelectorAll('.kerangka-item').forEach(el => el.classList.remove('selected'));
            document.getElementById('preview-kerangka').classList.remove('visible');
            document.getElementById('kerangka_id').value = '';
            steps.step3.style.display = 'none';
        }
        if (stepNumber <= 3) {
            selections.batu = { id: null, price: 0 };
            document.querySelectorAll('.batu-item').forEach(el => el.classList.remove('selected'));
            document.getElementById('preview-batu').classList.remove('visible');
            document.getElementById('batu_id').value = '';
            steps.step4.style.display = 'none';
        }
        updatePrice();
    }

    // LANGKAH 1: Memilih Jenis Aksesoris
    document.querySelectorAll('#step-1 .choice-item').forEach(item => {
        item.addEventListener('click', function() {
            const choice = this.dataset.choice;
            document.querySelectorAll('#step-1 .choice-item').forEach(el => el.classList.remove('selected'));
            this.classList.add('selected');

            resetStep(2); // Reset semua pilihan setelah ini

            document.querySelectorAll('.kerangka-item').forEach(kerangka => {
                if (kerangka.dataset.accessoryType === choice) {
                    kerangka.style.display = 'block';
                } else {
                    kerangka.style.display = 'none';
                }
            });
            steps.step2.style.display = 'block';
        });
    });

    // LANGKAH 2: Memilih Bahan Kerangka
    document.querySelectorAll('.kerangka-item').forEach(item => {
        item.addEventListener('click', function() {
            resetStep(3);
            document.querySelectorAll('.kerangka-item').forEach(el => el.classList.remove('selected'));
            this.classList.add('selected');

            selections.kerangka = { id: this.dataset.id, price: parseFloat(this.dataset.price) };
            document.getElementById('kerangka_id').value = this.dataset.id;
            document.getElementById('preview-kerangka').src = this.dataset.image;
            document.getElementById('preview-kerangka').classList.add('visible');

            steps.step3.style.display = 'block';
            updatePrice();
        });
    });

    // LANGKAH 3: Memilih Batu Alam
    document.querySelectorAll('.batu-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.batu-item').forEach(el => el.classList.remove('selected'));
            this.classList.add('selected');

            selections.batu = { id: this.dataset.id, price: parseFloat(this.dataset.price) };
            document.getElementById('batu_id').value = this.dataset.id;
            document.getElementById('preview-batu').src = this.dataset.image;
            document.getElementById('preview-batu').classList.add('visible');

            steps.step4.style.display = 'block';
            updatePrice();
        });
    });

    // LANGKAH 4: Memilih Addons
    document.querySelectorAll('.addon-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            selections.addons = [];
            document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
                selections.addons.push({ id: cb.value, price: parseFloat(cb.dataset.price) });
            });
            updatePrice();

            // PERUBAHAN DI SINI: Logika untuk menampilkan/menyembunyikan input teks
            const targetId = this.dataset.detailsTarget;
            if (targetId) {
                const targetElement = document.querySelector(targetId);
                if (this.checked) {
                    targetElement.style.display = 'block';
                } else {
                    targetElement.style.display = 'none';
                    targetElement.querySelector('input').value = ''; // Kosongkan input jika tidak dicentang
                }
            }
        });
    });

    // Validasi sebelum submit
    document.getElementById('builder-form').addEventListener('submit', function(e) {
        if (!document.getElementById('kerangka_id').value || !document.getElementById('batu_id').value) {
            e.preventDefault();
            alert('Harap selesaikan pemilihan Bahan Kerangka dan Batu Alam terlebih dahulu.');
        }
    });
});
</script>
@endpush
