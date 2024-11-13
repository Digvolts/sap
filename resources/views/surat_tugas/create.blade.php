@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container-custom {
    width: 100%; /* Mengisi seluruh lebar layar */
    margin: auto;
    padding: 20px;
    display: flex;
    gap: 20px;
}

.left-column {
    flex-grow: 1; /* Kolom kiri menyesuaikan lebar layar */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.right-column {
    width: 500px; /* Lebar tetap untuk kolom kanan */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-right: 70px;
}

.form-heading {
    font-size: 2em;
    margin-bottom: 20px;
    color: #333;
}

.pegawai-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-control {
    width: 100%;
    padding: 12px;
    font-size: 1.2em;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: border 0.3s;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 25px;
    font-size: 1.2em;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.pegawai-list {
    margin-top: 30px;
}

.pegawai-list h4 {
    font-size: 1.8em;
    color: #333;
    margin-bottom: 20px;
}

.no-data {
    color: #888;
    font-size: 1.2em;
}

.list-group {
    list-style-type: none;
    padding-left: 0;
}

.list-item {
    padding: 15px;
    margin-bottom: 12px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
}

.date-range {
    color: #666;
    font-size: 1.1em;
}

.alert {
    color: #856404;
    background-color: #fff3cd;
    padding: 15px;
    border: 1px solid #ffeeba;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 1.1em;
}

.suggestions-box {
    display: none;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    z-index: 1000;
    width: calc(100% - 24px);
    margin-top: 5px;
    border-radius: 6px;
}

.suggestions-box.active {
    display: block;
}

.suggestion-item {
    padding: 12px;
    font-size: 1.1em;
    cursor: pointer;
}

.suggestion-item:hover {
    background-color: #e0e0e0;
}

select.form-control {
    width: 100%;  /* or any desired width */
    height: auto; /* or a specific height */
}

</style>
<title>Buat Surat Tugas Baru</title>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="container-custom">
    <!-- Kolom Kiri: Form Surat Tugas Baru -->
    <div class="left-column">
        <h2 class="card-title text-center mb-4"><i class="fas fa-file-alt me-2"></i>Buat Surat Tugas Baru</h2>
          
          <form method="POST" action="{{ route('surat_tugas.store') }}" id="suratTugasForm">
            @csrf
            <div class="mb-3">
              <label for="unit" class="form-label">Unit</label>
              <input type="text" class="form-control" id="unit" name="unit" value="Direktorat Pemberdayaan Informatika | Tim Literasi Digital Sektor Masyarakat Umum" readonly>
            </div>

            <div class="mb-3">
              <label class="form-label">Jenis PD</label>
              <div class="row">
                <div class="col-md-6">
                  <select class="form-select @error('jenis_pd') is-invalid @enderror" id="jenis_pd" name="jenis_pd" required>
                    <option value="" selected disabled>- Pilih Jenis -</option>
                    <option value="524111">Biasa - 524111</option>
                    <option value="524119">Luar Kota - 524119</option>
                    <option value="524114">Dalam Kota (M) - 524114</option>
                    <option value="524219">Luar Negeri - 524219</option>
                    <option value="524113">Dalam Kota (T) - 524113</option>
                    <option value="521131">Operasional - 521131</option>
                    <option value="524211">Luar Negeri (Biasa) - 524211</option>
                    <option value="524212">Luar Negeri (Tetap) - 524212</option>
                  </select>
                  @error('jenis_pd')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <select class="form-select @error('jenis_pd_2') is-invalid @enderror" id="jenis_pd_2" name="jenis_pd_2" required>
                    <option value="" selected disabled>- Pilih Tipe -</option>
                    <option value="ST">ST</option>
                    <option value="GU">GU</option>
                  </select>
                  @error('jenis_pd_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="asal" class="form-label">Asal</label>
                <input type="text" class="form-control @error('asal') is-invalid @enderror" id="asal" name="asal" autocomplete="off" placeholder="Ketik nama kota asal...">
                @error('asal')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="asal-suggestions" class="suggestions-box"></div>
              </div>
              <div class="col-md-6">
                <label for="tujuan" class="form-label">Tujuan</label>
                <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" autocomplete="off" placeholder="Ketik nama kota tujuan...">
                @error('tujuan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="tujuan-suggestions" class="suggestions-box"></div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="tanggal_kegiatan_mulai" class="form-label">Tanggal Kegiatan Mulai</label>
                <input type="text" class="form-control datepicker  @error('tanggal_kegiatan_mulai') is-invalid @enderror" id="tanggal_kegiatan_mulai" name="tanggal_kegiatan_mulai" value="{{ old('tanggal_kegiatan_mulai', session('tanggal_kegiatan_mulai')) }}"  required>
                @error('tanggal_kegiatan_mulai')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="tanggal_kegiatan_selesai" class="form-label">Tanggal Kegiatan Selesai</label>
                <input type="text" class="form-control datepicker @error('tanggal_kegiatan_selesai') is-invalid @enderror" id="tanggal_kegiatan_selesai" name="tanggal_kegiatan_selesai"  value="{{ old('tanggal_kegiatan_selesai', session('tanggal_kegiatan_selesai')) }}"   required>
                @error('tanggal_kegiatan_selesai')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label for="lama_kegiatan" class="form-label">Lama Kegiatan (hari)</label>
              <input type="number" class="form-control @error('lama_kegiatan') is-invalid @enderror" id="lama_kegiatan" name="lama_kegiatan" readonly required>
              @error('lama_kegiatan')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="maksut" class="form-label">Maksud perjalanan</label>
              <select class="form-select @error('maksut') is-invalid @enderror" id="maksut" name="maksut" required>
                <option value="melaksanakan">melaksanakan</option>
                <option value="menghadiri">menghadiri</option>
              </select>
              @error('maksut')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="meeting_online">Meeting Online</label>
              <select class="form-control @error('meeting_online') is-invalid @enderror" id="meeting_online" name="meeting_online" required>
                <option value="1" {{ old('meeting_online') == 1 ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ old('meeting_online') == 0 ? 'selected' : '' }}>Tidak</option>
              </select>
              @error('meeting_online')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
              <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" id="nama_kegiatan" name="nama_kegiatan" required>
              @error('nama_kegiatan')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
              <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror" id="jumlah_peserta" name="jumlah_peserta" required>
              @error('jumlah_peserta')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="dasar" class="form-label">Dasar</label>
              <textarea class="form-control @error('dasar') is-invalid @enderror" id="dasar" name="dasar" rows="3" required></textarea>
              @error('dasar')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="lampiran" class="form-label">Upload Lampiran</label>
              <input type="file" class="form-control @error('lampiran') is-invalid @enderror" id="lampiran" name="lampiran">
              @error('lampiran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="is_draft">Status Draft</label>
              <select class="form-control @error('is_draft') is-invalid @enderror" id="is_draft" name="is_draft" required>
                <option value="1" {{ old('is_draft') == 1 ? 'selected' : '' }}>Draft</option>
                <option value="0" {{ old('is_draft') == 0 ? 'selected' : '' }}>Final</option>
              </select>
              @error('is_draft')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="catatan" class="form-label">Catatan</label>
              <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"></textarea>
              @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          
            <button type="submit" class="btn btn-primary">Simpan Surat Tugas</button>
          </form>
        </div>
   

        <div class="right-column">
        <form action="{{ route('pegawai_surat_tugas.store') }}" method="POST" class="form mt-4" id="formPegawaiSuratTugas">
                @csrf
                <div id="pegawai-section">
                    <h4 class="form-heading">Tambah Pegawai</h4>
                    <div class="pegawai-form">
                        <input type="hidden" id="tanggal_mulai_hidden" name="tanggal_kegiatan_mulai">
                        <input type="hidden" id="tanggal_selesai_hidden" name="tanggal_kegiatan_selesai">
                        
                        <input type="text" id="nama" name="pegawai[0][nama]" class="form-control" placeholder="Nama Pegawai" required>
                        <div id="nama-suggestions" class="suggestions-box"></div>
                        <input type="text" id="nip" name="pegawai[0][nip]" class="form-control" placeholder="NIP" required>
                        <input type="text" id="golongan" name="pegawai[0][golongan]" class="form-control" placeholder="Golongan" required>
                        <input type="text" id="jabatan" name="pegawai[0][jabatan]" class="form-control" placeholder="Jabatan" required>
                        <div>
                            <input type="radio" id="eselon1" name="pegawai[0][status]" value="Eselon 1" required>
                            <label for="eselon1">Eselon 1</label>

                            <input type="radio" id="eselon2" name="pegawai[0][status]" value="Eselon 2">
                            <label for="eselon2">Eselon 2</label>

                            <input type="radio" id="eselon3" name="pegawai[0][status]" value="Eselon 3" checked>
                            <label for="eselon3">Eselon 3</label>
                        </div>

                        <div class="form-group">
                            <select id="pegawai[0][pelaksana]" name="pegawai[0][pelaksana]" class="form-control" required>
                                <option value="Peserta">Peserta</option>
                                <option value="Narasumber">Narasumber</option>
                                <option value="Moderator">Moderator</option>
                                <option value="Mentor">Mentor</option>
                                <option value="Pelaksana">Pelaksana</option>
                                <option value="Pelaksana (PPNPN)">Pelaksana (PPNPN)</option>
                                <option value="Peserta (PPNPN)">Peserta (PPNPN)</option>
                                <option value="Panitia Pusat">Panitia Pusat</option>
                                <option value="Panitia Daerah">Panitia Daerah</option>
                                <option value="Fasilitator">Fasilitator</option>
                                <option value="Pembawa Acara">Pembawa Acara</option>
                            </select>
                        </div>

                        <input type="text" id="keterangan" name="pegawai[0][keterangan]" class="form-control" placeholder="Keterangan instansi" >

                        <button type="submit" class="btn btn-primary mt-2">Tambah Pegawai ke Form</button>
                    </div>
                </div>
            </form>

        <div class="pegawai-list mt-4">
            <h4>Daftar Pegawai</h4>

            @if(session()->has('conflictMessages'))
                @foreach(session('conflictMessages') as $message)
                    <div class="alert alert-warning">{{ $message }}</div>
                @endforeach
            @endif

            @if(empty($pegawaiList))
                <p class="no-data">Tidak ada pegawai yang ditambahkan.</p>
            @else
                <ul class="list-group">
                    @foreach($pegawaiList as $pegawai)
                        <li class="list-item">
                            <strong>{{ $pegawai['nama'] }}</strong> - {{ $pegawai['jabatan'] }} - NIP: {{ $pegawai['nip'] }} <br>
                            <span class="date-range">
                                {{ $pegawai['tanggal_kegiatan_mulai'] == $pegawai['tanggal_kegiatan_selesai'] ? date('j F Y', strtotime($pegawai['tanggal_kegiatan_mulai'])) : date('j', strtotime($pegawai['tanggal_kegiatan_mulai'])) . ' - ' . date('j F Y', strtotime($pegawai['tanggal_kegiatan_selesai'])) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
     // Fungsi untuk menyalin nilai tanggal dari form utama ke input hidden di form "Tambah Pegawai"
     function syncTanggal() {
        const tanggalMulai = document.getElementById('tanggal_kegiatan_mulai').value;
        const tanggalSelesai = document.getElementById('tanggal_kegiatan_selesai').value;

        // Salin nilai ke input hidden di form "Tambah Pegawai"
        document.getElementById('tanggal_mulai_hidden').value = tanggalMulai;
        document.getElementById('tanggal_selesai_hidden').value = tanggalSelesai;
    }

    // Event listener untuk menyinkronkan tanggal ketika input tanggal diubah
    document.getElementById('tanggal_kegiatan_mulai').addEventListener('change', syncTanggal);
    document.getElementById('tanggal_kegiatan_selesai').addEventListener('change', syncTanggal);

    // Sinkronisasi otomatis saat halaman dimuat
    syncTanggal();

    // Event saat form pegawai disubmit
    document.getElementById('formPegawaiSuratTugas').addEventListener('submit', function(event) {
        // Salin tanggal dari form utama sebelum submit
        syncTanggal();
    });
});



    flatpickr(".datepicker", {
        dateFormat: "d-m-Y",
        allowInput: true,
        clickOpens: true,
        disableMobile: "true"
    });

    const startDateInput = document.getElementById('tanggal_kegiatan_mulai');
    const endDateInput = document.getElementById('tanggal_kegiatan_selesai');
    const durationInput = document.getElementById('lama_kegiatan');

    function calculateDuration() {
        const startDateStr = startDateInput.value;
        const endDateStr = endDateInput.value;

        if (startDateStr && endDateStr) {
            const [startDay, startMonth, startYear] = startDateStr.split('-');
            const [endDay, endMonth, endYear] = endDateStr.split('-');

            const startDate = new Date(startYear, startMonth - 1, startDay);
            const endDate = new Date(endYear, endMonth - 1, endDay);

            const diffTime = endDate - startDate;
            const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1;
            durationInput.value = diffDays;
        }
    }

    startDateInput.addEventListener('change', calculateDuration);
    endDateInput.addEventListener('change', calculateDuration);
    calculateDuration();

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
                    if (data.length > 0) {
                        suggestionsBox.classList.add('active');
                    } else {
                        suggestionsBox.classList.remove('active');
                    }
                    data.forEach(city => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.classList.add('suggestion-item');
                        suggestionItem.textContent = `${city.city_name}, ${city.prov_name}`;
                        suggestionItem.addEventListener('click', () => {
                            inputField.value = city.city_name;
                            suggestionsBox.innerHTML = '';
                            suggestionsBox.classList.remove('active');
                        });
                        suggestionsBox.appendChild(suggestionItem);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        } else {
            suggestionsBox.innerHTML = '';
            suggestionsBox.classList.remove('active');
        }
    }

    document.getElementById('asal').addEventListener('input', () => fetchCitySuggestions(document.getElementById('asal').value, document.getElementById('asal'), document.getElementById('asal-suggestions')));
    document.getElementById('tujuan').addEventListener('input', () => fetchCitySuggestions(document.getElementById('tujuan').value, document.getElementById('tujuan'), document.getElementById('tujuan-suggestions')));

    document.getElementById('nama').addEventListener('input', function() {
    const query = this.value;
    const suggestionsBox = document.getElementById('nama-suggestions');

    // Debounce untuk membatasi panggilan API
    clearTimeout(this.debounceTimeout);
    this.debounceTimeout = setTimeout(() => {
        if (query.length > 2) {
            fetch(`/pegawai/suggestions?query=${query}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    if (data.length > 0) {
                        suggestionsBox.classList.add('active');
                    } else {
                        suggestionsBox.classList.remove('active');
                    }
                    data.forEach(item => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.textContent = item.nama;
                        suggestionItem.classList.add('suggestion-item');
                        suggestionItem.onclick = () => {
                            document.getElementById('nama').value = item.nama;
                            document.getElementById('nip').value = item.nip;
                            document.getElementById('golongan').value = item.golongan;
                            document.getElementById('jabatan').value = item.jabatan;

                            suggestionsBox.innerHTML = '';
                            suggestionsBox.classList.remove('active');
                        };
                        suggestionsBox.appendChild(suggestionItem);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        } else {
            suggestionsBox.innerHTML = '';
            suggestionsBox.classList.remove('active');
        }
    }, 300); // Delay 300ms untuk debounce
});

// Menyembunyikan kotak saran saat klik di luar
document.addEventListener('click', function(event) {
    const suggestionsBox = document.getElementById('nama-suggestions');
    const inputNama = document.getElementById('nama');
    if (!suggestionsBox.contains(event.target) && event.target !== inputNama) {
        suggestionsBox.innerHTML = '';
        suggestionsBox.classList.remove('active');
    }
});


    // Add form submit validation
    document.getElementById('suratTugasForm').addEventListener('submit', function(e) {
    const pegawaiEntries = document.querySelectorAll('#pegawai-section .pegawai-form');
    if (pegawaiEntries.length === 0) {
        e.preventDefault();
        alert('Harap tambahkan minimal satu pegawai');
        return false;
    }
});

</script>
@endsection