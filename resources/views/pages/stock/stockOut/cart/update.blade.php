<div class="modal fade" id="updateCart{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('masuk.cart.update', $item->id) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="qty" value="{{ $item->qty }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
