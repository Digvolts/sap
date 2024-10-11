@extends('layouts.app')

@section('content')
<div class="container">
    <title>Buat Surat Tugas Baru</title>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .form-title {
            color: #007bff;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .form-label {
            flex: 0 0 30%;
            margin-bottom: 0;
            padding-right: 15px;
        }
        .form-control, .form-select {
            flex: 0 0 70%;
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .btn-submit {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 8px;
        }
        .suggestions-box {
            position: absolute;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 8px;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-container">
                <h2 class="form-title text-center"><i class="fas fa-file-alt me-2"></i>Buat Surat Tugas Baru</h2>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('surat_tugas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="unit" class="form-label">Unit</label>
                        <span>Direktorat Pemberdayaan Informatika | Tim Literasi Digital Sektor Masyarakat Umum</span>
                    </div>

                    <div class="form-group">
                        <label for="jenis_pd" class="form-label">Jenis PD</label>
                        <div style="flex: 0 0 70%; display: flex; flex-wrap: wrap; align-items: center;">
                            <div style="flex: 0 0 33.33%; padding-right: 5px;">
                                <select class="form-select" id="jenis_pd" name="jenis_pd" required>
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option value="524111">Biasa - 524111</option>
                                    <option value="524119">Luar Kota - 524119</option>
                                    <option value="524114">Dalam Kota (M) - 524114</option>
                                    <option value="524219">Luar Negeri - 524219</option>
                                    <option value="524113">Dalam Kota (T) - 524113</option>
                                    <option value="521131">Operasional - 521131</option>
                                    <option value="524211">Luar Negeri (Biasa) - 524211</option>
                                    <option value="524212">Luar Negeri (Tetap) - 524212</option>
                                </select>
                            </div>
                            <div style="flex: 0 0 33.33%; padding-left: 5px; padding-right: 5px;">
                                <select class="form-select" id="jenis_pd_2" name="jenis_pd_2" required>
                                    <option value="" selected disabled>- Pilih -</option>
                                    <option value="ST">ST -</option>
                                    <option value="GU">GU -</option>
                                </select>
                            </div>
                            <div id="kurs_container">
                                <input type="text" class="form-control" id="kurs" name="kurs" placeholder="Kurs">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="asal" class="form-label">Asal</label>
                        <input type="text" class="form-control" id="asal" name="asal" autocomplete="off" placeholder="Ketik nama kota asal...">
                        <div id="asal-suggestions" class="suggestions-box"></div>
                    </div>

                    <div class="form-group">
                        <label for="tujuan" class="form-label">Tujuan</label>
                        <input type="text" class="form-control" id="tujuan" name="tujuan" autocomplete="off" placeholder="Ketik nama kota tujuan...">
                        <div id="tujuan-suggestions" class="suggestions-box"></div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kegiatan_mulai" class="form-label">Tanggal Kegiatan Mulai</label>
                        <input type="text" class="form-control datepicker" id="tanggal_kegiatan_mulai" name="tanggal_kegiatan_mulai" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kegiatan_selesai" class="form-label">Tanggal Kegiatan Selesai</label>
                        <input type="text" class="form-control datepicker" id="tanggal_kegiatan_selesai" name="tanggal_kegiatan_selesai" required>
                    </div>

                    <div class="form-group">
                        <label for="lama_kegiatan" class="form-label">Lama Kegiatan (hari)</label>
                        <input type="number" class="form-control" id="lama_kegiatan" name="lama_kegiatan" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="pelaksana" class="form-label">Pelaksana</label>
                        <button type="button" class="btn btn-primary" id="pelaksanaButton">Open Form</button>
                    </div>

                    @include('components.modal-form')

                    <div class="form-group">
                        <label for="maksut" class="form-label">Maksud perjalanan</label>
                        <select class="form-select" id="maksut" name="maksut" required>
                            <option value="melaksanakan">melaksanakan </option>
                            <option value="menghadiri">menghadiri</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="meeting_online" class="form-label">Meeting Online</label>
                        <select class="form-select" id="meeting_online" name="meeting_online">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                        <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" required>
                    </div>

                    <div class="form-group">
                        <label for="dasar" class="form-label">Dasar</label>
                        <textarea class="form-control" id="dasar" name="dasar" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="detail_jadwal" class="form-label">Detail Jadwal PD</label>
                        belum ada pelaksana perjalanan dinas
                    </div>

                    <div class="form-group">
                        <label for="penandatanganan" class="form-label">Set Penandatanganan</label>
                        Dapat diakses di modul keuangan pada tombol <button class="btn btn-danger">Pdt</button>
                    </div>

                    <div class="form-group">
                        <label for="lampiran" class="form-label">Upload Lampiran</label>
                        <input type="text" class="form-control" id="lampiran" name="lampiran">
                    </div>

                    <div class="form-group">
                        <label for="is_draft" class="form-label">Draft</label>
                        <select class="form-select" id="is_draft" name="is_draft">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-submit"><i class="fas fa-save me-2"></i>Simpan</button>
                    </div>
                </form>
                <div id="addedEmployeesList" class="mt-4"></div> <!-- Placeholder for added employees -->
            </div>
        </div>
    </div>

</div>

<!-- Load jQuery before Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://cdn.tiny.cloud/1/woi3njzxlaf1wiard6pwi9xwevxnki6eoyjpk0xgfe9imhpp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".datepicker", {
        dateFormat: "d-m-Y",
        allowInput: true,
        clickOpens: true,
        disableMobile: "true"
    });


    pelaksanaButton.addEventListener('click', function() {
        $('#formModal').modal('show'); // jQuery is now available here
    });

    // Duration and Kurs functionality
    const startDateInput = document.getElementById('tanggal_kegiatan_mulai');
    const endDateInput = document.getElementById('tanggal_kegiatan_selesai');
    const durationInput = document.getElementById('lama_kegiatan');
    const jenisPdSelect = document.getElementById('jenis_pd');
    const kursContainer = document.getElementById('kurs_container');

    function calculateDuration() {
        const startDateStr = startDateInput.value;
        const endDateStr = endDateInput.value;

        if (startDateStr && endDateStr) {
            const [startDay, startMonth, startYear] = startDateStr.split('-');
            const [endDay, endMonth, endYear] = endDateStr.split('-');

            const startDate = new Date(startYear, startMonth - 1, startDay);
            const endDate = new Date(endYear, endMonth - 1, endDay);

            const diffTime = endDate - startDate;
            const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both start and end days
            durationInput.value = diffDays;
        }
    }

    function toggleKursInput() {
        const selectedValue = jenisPdSelect.value;
        if (selectedValue === '524219' || selectedValue === '524211' || selectedValue === '524212') {
            kursContainer.style.display = 'block';
        } else {
            kursContainer.style.display = 'none';
        }
    }

    startDateInput.addEventListener('change', calculateDuration);
    endDateInput.addEventListener('change', calculateDuration);
    jenisPdSelect.addEventListener('change', toggleKursInput);

    // Calculate duration on page load if dates are already set
    calculateDuration();
    // Check if kurs input should be displayed on page load
    toggleKursInput();

    // City suggestions
    const asalInput = document.getElementById('asal');
    const tujuanInput = document.getElementById('tujuan');
    const asalSuggestions = document.getElementById('asal-suggestions');
    const tujuanSuggestions = document.getElementById('tujuan-suggestions');

    function fetchCitySuggestions(query, inputField, suggestionsBox) {
        if (query.length >= 2) {
            fetch(`/search-cities?q=${query}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    data.forEach(city => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.classList.add('suggestion-item');
                        suggestionItem.textContent = `${city.city_name}, ${city.prov_name}`;
                        suggestionItem.addEventListener('click', () => {
                            inputField.value = city.city_name;
                            suggestionsBox.innerHTML = '';
                        });
                        suggestionsBox.appendChild(suggestionItem);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        } else {
            suggestionsBox.innerHTML = '';
        }
    }

    asalInput.addEventListener('input', () => fetchCitySuggestions(asalInput.value, asalInput, asalSuggestions));
    tujuanInput.addEventListener('input', () => fetchCitySuggestions(tujuanInput.value, tujuanInput, tujuanSuggestions));

    // Initialize TinyMCE
    tinymce.init({
        selector: '#dasar',
        plugins: 'lists link image charmap print preview',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | link image',
        menubar: false,
        height: 200,
    });
});
</script>
@endsection
