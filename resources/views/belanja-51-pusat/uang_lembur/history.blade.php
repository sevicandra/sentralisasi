@extends('layout.main')
@section('aside-menu')
    @include('belanja-51-pusat.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap justify-between">
                <div class="flex gap-1 flex-wrap">
                    <a href="{{ $back }}" class="btn btn-xs btn-primary">Kembali</a>
                </div>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div>
                <div>

                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <div>
                    <ul class="timeline timeline-snap-icon timeline-compact timeline-vertical">
                        @foreach ($data as $item)
                        <li>
                          <div class="timeline-middle">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                              class="h-5 w-5">
                              <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                            </svg>
                          </div>
                          <div class="timeline-end mb-10 md:text-start">
                            <time class="font-mono italic">{{ $item->created_at }}</time>
                            <div class="text-lg font-black">{{ $item->nama }}</div>
                            <p class="text-md font-bold">{{ $item->action }}</p>
                            <p class="text-sm">{{ $item->catatan }}</p>
                          </div>
                          <hr />
                        </li>
                            
                        @endforeach
                      </ul>
                </div>
            </div>
        </div>
        <div>
            {{-- {{ $data->links() }} --}}
        </div>
    </div>
@endsection
