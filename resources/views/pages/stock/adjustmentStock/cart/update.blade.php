<div class="modal fade" id="updateCart{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penyesuaian.stok.cart.update', $item->id) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="form-label">Stok Aktual</label>
                        <input type="number" class="form-control" name="stock_actual"
                            value="{{ $item->stock_actual }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="remark" value="{{ $item->remark }}">
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
