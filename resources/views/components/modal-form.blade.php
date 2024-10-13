<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Pelaksana Perjalanan Dinas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                <form id="employeeForm">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama">
                        <div id="nama-suggestions" class="suggestions-box"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" placeholder="NIP" maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan_1" placeholder="Jabatan/Instansi">
                    </div>
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Penata / III-c</label>
                        <input type="text" class="form-control" id="golongan" placeholder="Penata / III-c">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="eselon1" value="Eselon 1">
                        <label class="form-check-label" for="eselon1">Eselon 1</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="eselon2" value="Eselon 2">
                        <label class="form-check-label" for="eselon2">Eselon 2</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="eselon3" value="Eselon 3" checked>
                        <label class="form-check-label" for="eselon3">Eselon 3 ke bawah</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="add-button" class="btn btn-primary">Add</button>
                <div id="employee-list" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
    
document.getElementById('nama').addEventListener('input', function() {
    const query = this.value;

    if (query.length > 2) {
        fetch(`/pegawai/suggestions?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const suggestionsBox = document.getElementById('nama-suggestions');
                suggestionsBox.innerHTML = '';

                data.forEach(item => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.textContent = item.nama;
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.onclick = () => {
                        document.getElementById('nama').value = item.nama;
                        document.getElementById('nip').value = item.nip;
                        document.getElementById('jabatan_1').value = item.jabatan_1;
                        document.getElementById('golongan').value = item.golongan;
                        suggestionsBox.innerHTML = '';
                    };
                    suggestionsBox.appendChild(suggestionItem);
                });
            });
    } else {
        document.getElementById('nama-suggestions').innerHTML = '';
    }
});

document.getElementById('add-button').addEventListener('click', function(event) {
    event.preventDefault();
    
    const nama = document.getElementById('nama').value;
    const nip = document.getElementById('nip').value;
    const jabatan = document.getElementById('jabatan_1').value;
    const golongan = document.getElementById('golongan').value;
    const status = document.querySelector('input[name="status"]:checked')?.value || '';

    const errorMessageDiv = document.getElementById('error-message');
    errorMessageDiv.style.display = 'none';
    errorMessageDiv.textContent = '';

    $.ajax({
        url: '/pegawai/add',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            nama: nama,
            nip: nip,
            jabatan_1: jabatan,
            golongan: golongan,
            status: status
        },
        success: function(response) {
            if (response.success) {
                let pelaksanaField = $('#pelaksana_ids');
                pelaksanaField.append(`<input type="hidden" name="pelaksana_ids[]" value="${response.id}">`);
                $('#addedEmployeesList').append(`<div>${nama} (${nip || 'NIP tidak diisi'})</div>`);
                $('#formModal').modal('hide');
                
                document.getElementById('employeeForm').reset();
            } else {
                errorMessageDiv.textContent = response.message || 'Gagal menambahkan pegawai. Silakan coba lagi.';
                errorMessageDiv.style.display = 'block';
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan. Pegawai gagal ditambahkan.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            errorMessageDiv.textContent = errorMessage;
            errorMessageDiv.style.display = 'block';
        }
    });
});


</script>

<style>
.suggestions-box {
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    position: absolute;
    background: white;
    z-index: 1000;
}

.suggestion-item {
    padding: 10px;
    cursor: pointer;
}

.suggestion-item:hover {
    background-color: #f0f0f0;
}
#error-message {
        margin-bottom: 15px;
    }
</style>


