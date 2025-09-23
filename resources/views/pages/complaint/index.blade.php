@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Aduan</h1>
        @if (isset(auth()->user()->resident))
             <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> BUat Aduan</a> 
        @endif
      
    </div>

       @if (session('success'))
                <script>
                    Swal.fire({
                        title: "Berhasil",
                        text: "{{ session()->get('success') }}",
                        icon: "success"
                    });
                </script>
            @endif
               @if (session('error'))
                <script>
                    Swal.fire({
                        title: "Gagal, Terjadi kesahalan",
                        text: "{{ session()->get('error') }}",
                        icon: "error"
                    });
                </script>
            @endif

    {{-- Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-responsive table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Isi Aduan</th>
                                <th>Status</th>
                                <th>Foto BUkti</th>
                                <th>Tanggal Laporan </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        {{-- @dd(@empty($residents)) --}}
                        @if (count($complaints) < 1)
                            <tbody>
                                <tr>
                                    <td colspan="11">
                                        <p class="pt-3 text-center">Tidak Ada Data</p>
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                                @foreach ($complaints as $item)
                                    <tr>
<td>{{ $loop->iteration + $complaints->firstItem() - 1 }}</td>
<td>{{ $item->title }}</td>
<td>{!! nl2br(wordwrap($item->content, 50, "\n")) !!}</td>
<td>{{ $item->status }}</td>
<td>@if (isset($item->photo_proof))
    @php
        $filePath = 'storage/' .$item->photo_proof;
    @endphp
  <a href="{{  $filePath  }}" target="_blank" rel="noopener noreferrer">
      <img src="{{  $filePath  }}" alt="Bukti Foto" style="max-width: 300px;">
  </a>
    @else
    Tidak Ada
   @endif

</td>
<td>{{$item->report_date_label}}</td>
<td>@if (
        auth()->check() 
        && auth()->user()->role_id == 2 
        && auth()->user()->resident 
        && $item->status === 'new'
    )
        {{-- tombol edit/hapus --}}
    @elseif(auth()->check() && auth()->user()->role_id == 1)
        <div>
            <form id="formChangeStatus{{ $item->id }}" action="/complaint/update-status/{{ $item->id }}" method="post">
                @csrf
                <div class="form-group">
                    <select name="status" class="form-control" style="min-width:100px"
                        oninput="document.getElementById('formChangeStatus{{ $item->id }}').submit();">
                        @foreach ([
                            (object)['label' => 'Baru', 'value' => 'new'],
                            (object)['label' => 'Sedang Di Proses', 'value' => 'processing'],
                            (object)['label' => 'Selesai', 'value' => 'completed'],
                        ] as $status)
                            <option value="{{ $status->value }}" @selected($item->status == $status->value)>
                                {{ $status->label }}
                            </option>
                        @endforeach
                </select>
            </div>
        </form>
    </div>
    @endif
</td>
</tr>
@include('pages.complaint.confirmation-delete')
{{-- @if (!is_null($item->user_id))

@endif --}}
@endforeach

</tbody>
@endif

                    </table>

                </div>

                @if($complaints->lastPage() > 1)
                <div class="card-footer">
                    {{ $residents->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    @endsection
