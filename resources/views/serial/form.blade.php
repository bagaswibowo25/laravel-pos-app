<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')
            
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="id_product" class="col-lg-2 col-lg-offset-1 control-label">Product</label>
                            <div class="col-lg-6">
                                <select name="id_product" id="id_product" class="form-control" required>
                                    <option value="">Pilih Product</option>
                                    @foreach ($product as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    <div class="form-group row">
                        <label for="warranty_start" class="col-lg-2 col-lg-offset-1 control-label">Warranty Start</label>
                        <div class="col-lg-6">
                            <input type="date" name="warranty_start" id="warranty_start" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="warranty_year" class="col-lg-2 col-lg-offset-1 control-label">Warranty Year</label>
                        <div class="col-lg-6">
                            <input type="warranty_year" name="warranty_year" id="warranty_year" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="used" class="col-lg-2 col-lg-offset-1 control-label">Used</label>
                        <div class="col-lg-6">
                            <input type="number" name="used" id="used" class="form-control" required value="0" max=1>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>

        </form>
    </div>
</div>