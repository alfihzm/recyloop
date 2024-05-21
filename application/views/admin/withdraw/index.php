    <style>
        .btn-small {
            transform: scale(0.5);
            transform-origin: center;
        }

        .btn-cross {
            margin-bottom: -20px;
        }
    </style>

    <div class="main-panel" style="font-family: quicksand;">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title"><?= $judul; ?></h4>
                </div>
                <!-- 
                <a href=" <?= base_url('admin/tambah_sampah'); ?>" class="btn btn-secondary mb-3"> Tambah Jenis Sampah</a> 
                -->
                <div class="alert alert-info" role="alert" style="margin-top: -15px; background: white; color: #1A2035; border-radius: 5px;">
                    <b>
                        <li>Pastikan Anda secara aktif memeriksa antrian konfirmasi penyerahan sampah!</li>
                        <li>Catatan: BP Botol Plastik | KA Kaleng Alumunium | KK Kertas Kardus</li>
                    </b>
                </div>
                <a href="" data-toggle="modal" data-target="#newTransactionModal" class="btn btn-info mb-3" style="color:white;"><b>Tambah
                        Transaksi</b></a>

                <div class="row">
                    <div class="col-lg-6">
                        <?= $this->session->flashdata('message') ?>
                    </div>
                </div>

                <div class="containers">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Kode Member</th>
                                <th scope="col">User</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">BP</th>
                                <th scope="col">KA</th>
                                <th scope="col">KK</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi as $t) : ?>
                                <?php if ($t['status'] === 'Belum dikonfirmasi') : ?>
                                    <tr>
                                        <td><?= $t['id_member']; ?></td>
                                        <td><?= $t['username']; ?></td>
                                        <td><?= $t['tanggal']; ?></td>
                                        <td><?= $t['jumlah_botol']; ?></td>
                                        <td><?= $t['jumlah_kaleng']; ?></td>
                                        <td><?= $t['jumlah_kardus']; ?></td>
                                        <td><?= $t['lokasi']; ?></td>
                                        <td><?= $t['status']; ?></td>
                                        <td>
                                            <div style="display: inline-block; text-align: center; margin-bottom: 2px;">
                                                <a href="<?= base_url('transaction/edit_transaction/'   . $t['id']); ?>" class="btn btn-light btn-sm" style="width: 30px; height: 30px;"><i style="color: #000;" class="fa-solid fa-pencil"></i></a>
                                                <a href="<?= base_url('transaction/delete_transaksi/' . $t['id']); ?>" class="btn btn-light btn-sm" style="width: 30px; height: 30px;"><i style="color: #000;" class="fa-solid fa-trash"></i></a>
                                            </div>
                                            <div style="display: inline-block; text-align: center;">
                                                <a href="<?= base_url('transaction/updatetransaction/' . $t['id']); ?>" class="btn btn-light btn-sm" style="width: 30px; height: 30px;"><i style="color: #000;" class="fa-solid fa-check"></i></a>
                                                <a href="<?= base_url('transaction/info_transaction/' . $t['id']); ?>" class="btn btn-light btn-sm" style="width: 30px; height: 30px;"><i style="color: #000;" class="fa-solid fa-info"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Transaksi Penyerahan  -->
        <div class="modal fade" id="newTransactionModal" tabindex="-1" aria-labelledby="newTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="background-color: #1A2035; border-radius: 10px;">
                <div class="modal-content" style="background-color: #1A2035;">
                    <div class="modal-header">
                        <h2 class="modal-title text-white" id="newTransactionModalLabel"><b>Transaksi Baru</b></h2>
                        <button type="button" class="btn btn-close btn-small btn-cross" data-dismiss="modal" aria-label="Close">
                            <!-- &times; -->X
                        </button>
                    </div>
                    <form action="<?= base_url('transaction') ?>" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="formGroupExampleInput">ID Member</label>
                                <input style="background: #01E7f4; color: #1A2035; font-weight: 600;" type="text" class="form-control" id="id_member" name="id_member" placeholder="Ketik ID milik member">
                                <?= form_error('id_member', '<small class="text-light">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="formGroupExampleInput">User</label>
                                <input style="background: #01E7f4; color: #1A2035; font-weight: 600;" type="text" class="form-control" id="username" name="username" placeholder="ID Member tidak ditemukan!">
                            </div>
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="jumlah_botol">Botol Plastik</label>
                                <input style="background: #01E7f4; color: #1A2035; font-weight: 600;" type="number" class="form-control" id="jumlah_botol" name="jumlah_botol" placeholder="Ketik jumlah botol yang ditukar" min="0" value="0">
                            </div>
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="jumlah_kaleng">Kaleng Alumunium</label>
                                <input style="background: #01E7f4; color: #1A2035; font-weight: 600;" type="number" class="form-control" id="jumlah_kaleng" name="jumlah_kaleng" placeholder="Ketik jumlah kaleng yang ditukar" min="0" value="0">
                            </div>
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="jumlah_kardus">Kertas Kardus</label>
                                <input style="background: #01E7f4; color: #1A2035; font-weight: 600;" type="number" class="form-control" id="jumlah_kardus" name="jumlah_kardus" placeholder="Ketik kardus kaleng yang ditukar" min="0" value="0">
                            </div>
                            <input type="hidden" id="total" name="total">
                            <input type="hidden" id="totalkoin" name="totalkoin">
                            <input type="hidden" id="totalkonversi" name="totalkonversi">
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="formGroupExampleInput2">Tanggal Penukaran</label>
                                <input style="background: #01E7f4; color: #1A2035; font-weight: 600;" type="date" class="form-control" id="tanggal" name="tanggal">
                                <?= form_error('tanggal', '<small class="text-light">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="lokasi">Lokasi</label>
                                <select class="form-control" id="lokasi" name="lokasi" style="background: #01E7f4; color: #1A2035;">
                                    <option value="" disabled selected>Pilih lokasi</option>
                                    <option value="Tenant Official">Tenant Official</option>
                                    <option value="RW 001">RW 001</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="color: #01E7f4 !important;" for="formGroupExampleInput">Komentar</label>
                                <textarea style="background: #01E7f4; color: #1A2035; font-weight: 600;" class="form-control" id="catatan" name="catatan" placeholder="Tulis komentar di sini"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            window.setTimeout(function() {
                $(".col-lg-6").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 2000);
        </script>