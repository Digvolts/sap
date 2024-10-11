@extends('layouts.app')

@section('content')
<style>
.container-fluid {
    max-width: 100% !important; /* Ensures the container always takes up the full width */
    width: 100%;
}


.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Makes scrolling smooth on touch devices */
}

.table {
    table-layout: auto; /* Allows table to adapt its width dynamically */
    width: 100%; /* Ensures the table takes up the full container width */
}

</style>
<div class="container-fluid mt-5 p-4" style="background-color: #ffffff; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
    <h1 class="text-center text-primary mb-4">Daftar Pegawai</h1>

    <!-- Controls for showing entries and search -->
    <div class="row mb-3">
        <!-- Show box -->
        <div class="col-md-6">
            <label for="per_page" class="mr-2">Show:</label>
            <select id="per_page" class="form-control d-inline-block w-auto" onchange="fetchData()">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <!-- Search Box -->
        <div class="col-md-6 text-end">
            <input type="text" id="search" placeholder="Cari pegawai..." class="form-control d-inline-block w-auto" onkeyup="fetchData()">
        </div>
    </div>

    <a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>ID</th>
                    <th>Nama / NISP</th>
                    <th>NIP</th>
                    <th>Golongan</th>
                    <th>Jabatan 1</th>
                    <th>Jabatan 2</th>
                    <th>Email / HP</th>
                    <th>NPWP</th>
                    <th>KTP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="pegawai-table-body">
                <!-- Data will be populated here using JS -->
            </tbody>
        </table>
    </div>

    <div id="pagination-links" class="mt-3">
        <!-- Pagination links will be added here -->
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchData() {
        let search = $('#search').val();
        let perPage = $('#per_page').val();

        $.ajax({
            url: "{{ route('pegawai.data') }}",
            method: 'GET',
            data: {
                search: search,
                per_page: perPage
            },
            success: function(data) {
                // Clear the table body
                $('#pegawai-table-body').empty();

                // Populate the table with the new data
                data.data.forEach(pegawai => {
                    $('#pegawai-table-body').append(`
                        <tr>
                            <td><strong>${pegawai.unit}</strong><br>${pegawai.direktorat}</td>
                            <td>[${pegawai.id}]</td>
                           <td>${pegawai.nama}<br>${pegawai.nisp ? pegawai.nisp : '-'}</td>

                            <td>${pegawai.nip ? pegawai.nip : ''}</td>
                            <td>${pegawai.golongan ? pegawai.golongan : ''}</td>
                            <td>${pegawai.jabatan_1}(${pegawai.status === 'non pegawai' ? '<strong>non</strong>' : pegawai.status}
)</td>
                            <td>${pegawai.jabatan_2 ? pegawai.jabatan_2 : ''}</td>
                            
                            <td>${pegawai.email ? pegawai.email : ''}<br>${pegawai.no_handphone ? pegawai.no_handphone : ''}</td>
                            <td>${pegawai.npwp ? pegawai.npwp : ''}</td>
                            <td>${pegawai.ktp ? pegawai.ktp : ''}</td>
                            <td>
                                <a href="/pegawai/${pegawai.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/pegawai/${pegawai.id}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    
                                </form>
                            </td>
                        </tr>
                    `);
                });

                // Render pagination links
                let paginationHtml = '';
                for (let i = 1; i <= data.last_page; i++) {
                    paginationHtml += `<button class="btn btn-link" onclick="changePage(${i})">${i}</button>`;
                }
                $('#pagination-links').html(paginationHtml);
            }
        });
    }

    function changePage(page) {
        let search = $('#search').val();
        let perPage = $('#per_page').val();

        $.ajax({
            url: "{{ route('pegawai.data') }}",
            method: 'GET',
            data: {
                search: search,
                per_page: perPage,
                page: page
            },
            success: function(data) {
                // Clear the table body
                $('#pegawai-table-body').empty();

                // Populate the table with the new data
                data.data.forEach(pegawai => {
                    $('#pegawai-table-body').append(`
                        <tr>
                            <td><strong>${pegawai.unit}</strong><br>${pegawai.direktorat}</td>
                            <td>${pegawai.id}</td>
                            <td>${pegawai.nama}<br>${pegawai.nisp ? pegawai.nisp : ''}</td>
                            <td>${pegawai.nip ? pegawai.nip : ''}</td>
                            <td>${pegawai.golongan ? pegawai.golongan : ''}</td>
                            <td>${pegawai.jabatan_1}</td>
                            <td>${pegawai.jabatan_2 ? pegawai.jabatan_2 : ''}</td>
                            <td>${pegawai.no_handphone ? pegawai.no_handphone : ''}</td>
                            <td>${pegawai.email ? pegawai.email : ''}</td>
                            <td>${pegawai.npwp ? pegawai.npwp : ''}</td>
                            <td>${pegawai.ktp ? pegawai.ktp : ''}</td>
                            <td>${pegawai.status ? pegawai.status : ''}</td>
                            <td>
                                <a href="/pegawai/${pegawai.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/pegawai/${pegawai.id}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    `);
                });

                // Render pagination links
                let paginationHtml = '';
                for (let i = 1; i <= data.last_page; i++) {
                    paginationHtml += `<button class="btn btn-link" onclick="changePage(${i})">${i}</button>`;
                }
                $('#pagination-links').html(paginationHtml);
            }
        });
    }

    // Initial fetch
    $(document).ready(function() {
        fetchData();
    });
</script>
@endsection
