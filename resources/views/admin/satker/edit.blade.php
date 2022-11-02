@extends('layout.main')
@section('aside-menu')
    @include('admin.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
    </div>
    <div id="main-content">
        <div class="row">
          <div class="col-xxl-8">
            <div class="card">
              <form action="/admin/satker/{{$data->kdsatker}}" method="post" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="card-header">
                  <div class="card-text">
                    <p></p>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="">Nama Satker:</label>
                        <input type="text" name="nmsatker" class="form-control @error('nmsatker') is-invalid @enderror" value="{{ $data->nmsatker }}">
                        @error('nmsatker')
                          <div class="invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 ">
                      <div class="form-group">
                        <label for="jumlah">Kode Satker:</label>
                        <input type="text" name="kdsatker" class="form-control @error('kdsatker') is-invalid @enderror" value="{{ $data->kdsatker }}">
                        @error('kdsatker')
                          <div class="invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label for="">Jenis Satker:</label>
                        <select id="jnssatker" name="jnssatker" class="form-control">
                          <option value="1" @if ($data->jnssatker === "1") selected @endif>Eselon 1</option>
                          <option value="2" @if ($data->jnssatker === "2") selected @endif>Eselon 2</option>
                          <option value="3" @if ($data->jnssatker === "3") selected @endif>Eselon 3</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row" id="koordinator" style="display: none">
                    <div class="col-lg-12 ">
                      <div class="form-group">
                        <label for="jumlah">Kode Satker Koordinator:</label>
                        <input type="text" name="kdkoordinator" class="form-control @error('kdsatker') is-invalid @enderror" value="{{ $data->kdkoordinator }}">
                        @error('kdkoordinator')
                          <div class="invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>

                </div>
                <div class="card-footer">
                  <a href="/admin/satker" class="btn btn-sm btn-secondary float-left"><i class="fa fa-undo"></i> Kembali</a>
                  <button type="submit" class="btn btn-sm btn-success ml-2"><i class="fa fa-save"></i> Simpan</button>
                </div>
              </form>
            </div>
          </div>
          </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection

@section('main-footer')
    <script>
        $("#jnssatker").change(function(){
          $("#koordinator").css("display", "none")
          if ($("#jnssatker").val() === "3") {
            $("#koordinator").removeAttr( 'style' );
          }
        })
    </script>
    @if (old('jnssatker') === "3") 
      <script>
        $("#koordinator").removeAttr( 'style' );
      </script>
    @endif
@endsection