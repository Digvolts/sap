<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Pelaksana Perjalanan Dinas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="employeeForm">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama/NIP">
                        <div id="nama-suggestions" class="suggestions-box"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" placeholder="NIP">
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
                        <input class="form-check-input" type="radio" name="eselon" id="eselon1" value="Eselon 1">
                        <label class="form-check-label" for="eselon1">Eselon 1</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="eselon" id="eselon2" value="Eselon 2">
                        <label class="form-check-label" for="eselon2">Eselon 2</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="eselon" id="eselon3" value="Eselon 3" checked>
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

    if (query.length > 2) { // Only search if input length is greater than 2
        fetch(`/pegawai/suggestions?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const suggestionsBox = document.getElementById('nama-suggestions');
                suggestionsBox.innerHTML = ''; // Clear previous suggestions

                data.forEach(item => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.textContent = item.nama; // Adjust based on your data structure
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.onclick = () => {
                        // Set input values based on the selected suggestion
                        document.getElementById('nama').value = item.nama; // Set Nama
                        document.getElementById('nip').value = item.nip; // Set NIP
                        document.getElementById('jabatan_1').value = item.jabatan_1; // Set Jabatan
                        document.getElementById('golongan').value = item.golongan; // Set Golongan
                        suggestionsBox.innerHTML = ''; // Clear suggestions
                    };
                    suggestionsBox.appendChild(suggestionItem);
                });
            });
    } else {
        document.getElementById('nama-suggestions').innerHTML = ''; // Clear suggestions if input is too short
    }
});


const employeeData = []; // Array to keep track of added employees

document.getElementById('add-button').addEventListener('click', function() {
    // Get values from input fields
    const nama = document.getElementById('nama').value;
    const nip = document.getElementById('nip').value;
    const jabatan = document.getElementById('jabatan_1').value;
    const golongan = document.getElementById('golongan').value;

    // Validate input
    if (!nama || !nip || !jabatan || !golongan) {
        alert('Please fill in all fields.');
        return;
    }

    // Check for duplicates
    const exists = employeeData.some(employee => employee.nip === nip);
    if (exists) {
        alert('Employee with this NIP already exists.');
        return;
    }

    // Create a new employee entry
    const employee = { nama, nip, jabatan, golongan };
    employeeData.push(employee); // Add to the employee data array

    const employeeList = document.getElementById('employee-list');
    const employeeItem = document.createElement('div');
    employeeItem.classList.add('employee-item');
    employeeItem.innerHTML = `
        <strong>Nama:</strong> ${nama}, 
        <strong>NIP:</strong> ${nip}, 
        <strong>Jabatan:</strong> ${jabatan}, 
        <strong>Golongan:</strong> ${golongan}
    `;
    employeeList.appendChild(employeeItem);

    // Clear input fields after adding
    document.getElementById('nama').value = '';
    document.getElementById('nip').value = '';
    document.getElementById('jabatan_1').value = '';
    document.getElementById('golongan').value = '';
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
</style>
