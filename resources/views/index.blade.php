<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .btn:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25); 
            transform: translateY(-5px); 
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <h2 class="mb-3 text-center">Todo List</h2>
        
        <div class="card mb-5" style="max-width: 400px; margin: auto;">
            <div class="p-3">
                <form action="{{ isset($todo) ? route('update', $todo->id) : route('store') }}" method="POST">
                    @csrf 
                    @if(isset($todo))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-2">
                        <label for="nama" class="form-label">Nama Tugas</label>
                        <input type="text" class="form-control form-control-sm" id="nama" name="nama" value="{{ $todo->nama ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="prioritas" class="form-label">Prioritas</label>
                        <select class="form-select form-select-sm" id="prioritas" name="prioritas" required>
                            <option value="1" {{ (isset($todo) && $todo->prioritas == 1) ? 'selected' : '' }}>1</option>
                            <option value="2" {{ (isset($todo) && $todo->prioritas == 2) ? 'selected' : '' }}>2</option>
                            <option value="3" {{ (isset($todo) && $todo->prioritas == 3) ? 'selected' : '' }}>3</option>
                            <option value="4" {{ (isset($todo) && $todo->prioritas == 4) ? 'selected' : '' }}>4</option>
                            <option value="5" {{ (isset($todo) && $todo->prioritas == 5) ? 'selected' : '' }}>5</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-sm btn-primary w-100">{{ isset($todo) ? 'Update' : 'Tambah' }}</button>
                </form>
            </div>
        </div>
        <form action="{{ route('index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Todo..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        {{-- <div class="d-flex justify-content-center mt-4">
            <div class="card w-50 mx-auto p-3">
                @foreach ($todos as $t)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div class="flex-grow-1">
                            {{ $t->nama }}
                        </div>
                        <div class="mx-5">
                            @if($t->prioritas == 1)
                                <i class="bi bi-1-square-fill fs-3"></i>
                            @elseif($t->prioritas == 2)
                                <i class="bi bi-2-square-fill fs-3"></i>
                            @elseif($t->prioritas == 3)
                                <i class="bi bi-3-square-fill fs-3"></i>
                            @elseif($t->prioritas == 4)
                                <i class="bi bi-4-square-fill fs-3"></i>
                            @else
                                <i class="bi bi-5-square-fill fs-3"></i>
                            @endif
                        </div>
                        <div class="">
                            <form action="{{ route('updateStatus', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $t->status ? 'btn-success' : 'btn-secondary' }}">
                                    <i class="bi {{ $t->status ? 'bi-clipboard-check' : 'bi-clipboard-x' }}"></i>
                                </button>                            
                            </form>
                            <a href="{{ route('edit', $t->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pen-fill"></i></a>
                            <form action="{{ route('destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                        <br>
                    </div>
                @endforeach
            </div>
        </div> --}}
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Prioritas</th>
                    <th>Tanggal dikerjakan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todos as $t)
                <tr>
                    <td>{{ $t->nama }}</td>
                    <td>
                        @php
                            $prioritas = $t->prioritas;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $prioritas)
                                <i class="bi bi-star-fill text-warning"></i> {{-- Bintang kuning --}}
                            @else
                                <i class="bi bi-star-fill text-secondary"></i> {{-- Bintang putih --}}
                            @endif
                        @endfor
                    </td>
                    
                    <td>{{ $t->tgl_dicentang }}</td>
                    <td>
                        <form action="{{ route('updateStatus', $t->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm fs-4 {{ $t->status ? 'btn-success' : 'btn-secondary' }}">
                                <i class="bi {{ $t->status ? 'bi-clipboard-check' : 'bi-clipboard-x' }}"></i>
                            </button>                            
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('edit', $t->id) }}" class="btn btn-warning btn-sm fs-4"><i class="bi bi-pen-fill"></i></a>
                        <form action="{{ route('destroy', $t->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm fs-4 delete-btn">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                toast: true,
                position: 'top-end'
            });
            @endif

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); 

                    let form = this.closest("form"); 

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); 
                        }
                    });
                });
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
