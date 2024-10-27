@extends('layouts.adminlte')

@section('contents')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs for categories -->
                <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                    @foreach($kategoris as $kategori)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if($loop->first) active @endif" id="tab-{{ $kategori->idkategori }}" data-toggle="tab" href="#category-{{ $kategori->idkategori }}" role="tab" aria-controls="category-{{ $kategori->idkategori }}" aria-selected="@if($loop->first) true @else false @endif">
                                {{ $kategori->nama }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab content -->
                <div class="tab-content" id="categoryTabContent">
                    @foreach($kategoris as $kategori)
                        <div class="tab-pane fade @if($loop->first) show active @endif" id="category-{{ $kategori->idkategori }}" role="tabpanel" aria-labelledby="tab-{{ $kategori->idkategori }}">
                            <div class="table-responsive" id="div_tabel_{{ $kategori->idkategori }}">
                                <!-- Product data will be loaded here -->
                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        // Initialize tabs if necessary
        $('#categoryTabs a:first').tab('show'); // Activate the first tab

        // Load product data for each category
        @foreach($kategoris as $kategori)
            loadProductData('{{ csrf_token() }}', '#div_tabel_{{ $kategori->idkategori }}', '{{ route('penjualan.data') }}', '{{ $kategori->idkategori }}');
        @endforeach
    });

    function loadProductData(token, target, act, kategoriId) {
        $(target).html(`<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border text-primary" role="status"></div></div>`);
        $.post(act, {
                _token: token,
                kategori_id: kategoriId // Send category ID to filter products
            })
            .done(function(data) {
                $(target).html(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                var errormess = "";
                try {
                    errormess = jqXHR['responseJSON']['message'];
                } catch (error) {}
                $(target).html("Error loading data: " + textStatus + " - " + errorThrown + " " + errormess);
            });
    }
</script>
@endsection
