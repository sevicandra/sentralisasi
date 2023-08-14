@extends('layout.main')
@section('aside-menu')
    @include('spt.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
      @include('layout.flashmessage')
    </div>
    <div id="main-content">
        <div class="row mb-2">
          <div class="col-xxl-6">
            <div class="card">
              <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('POST')
                <div class="card-header">
                  <div class="card-text">
                    <p></p>
                  </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                          <div class="form-group">
                              <label for="">Upload File <span>Template (<a href="/template/Upload_spt.xlsx">download</a>)</span>  Excel: </label>
                              <div class="custom-file">
                              <input type="file" class="form-control custom @error('file') is-invalid @enderror" name="file_excel" accept=".xlsx" required>
                              @error('file_excel')
                              <div class="text-danger">
                                  <small>
                                      {{ $message }}
                                  </small>
                              </div>
                              @enderror
                          </div>
                              <span><small class="text-muted ">file dengan format .xlsx</small></span>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <a href="/spt" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
                  <button type="submit" class="btn btn-sm btn-success ml-2"><i class="fa fa-save"></i> Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @if ((Session::has('rowsErrors')))
          <div class="row">
            <div class="table-warper">
              <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center align-middle">
                        <th>No</th>
                        <th>tahun</th>
                        <th>nip</th>
                        <th>npwp</th>
                        <th>alamat</th>
                        <th>kdgol</th>
                        <th>kdkawin</th>
                        <th>kdjab</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Session::get('rowsErrors') as $item)
                        <tr
                          class=" @if ($item->status)
                              text-success
                              @else
                              text-danger
                          @endif "
                        >
                            <td class="text-center">{{ $item->row }}</td>
                            <td>{{ $item->errors->tahun }}</td>
                            <td>{{ $item->errors->nip }}</td>
                            <td>{{ $item->errors->npwp }}</td>
                            <td>{{ $item->errors->alamat }}</td>
                            <td>{{ $item->errors->kdgol }}</td>
                            <td>{{ $item->errors->kdkawin }}</td>
                            <td>{{ $item->errors->kdjab }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
          </div>
        @endif
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection