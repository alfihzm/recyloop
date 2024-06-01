<body class="main-body light-theme">

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top" class="back-to-top rounded-circle shadow all-ease-03 fade-in">
        <i class="fe fe-arrow-up"></i>
    </a>
    <!-- END BACK-TO-TOP -->

    <!-- PAGE -->
    <div class="page">
        <!-- MAIN-CONTENT -->
        <div class="main-content app-content"></div>
        <section>
            <div class="section banner-4 banner-section">
                <div class="row">
                    <div class="container col-10 col-md-10 col-lg-8">
                        <div class="card p-4 d-flex align-items-center justify-content-center" style="height: 100%;">
                            <div class="heading-section p-2">
                                <div class="heading-subtitle"><span class="tx-primary tx-16 fw-semibold">Histori</span>
                                </div>
                                <div class="heading-title mb-4">
                                    <span class="tx-primary">
                                        Tarik Tunai Anda
                                    </span>
                                </div>
                                <a href="<?= base_url('member/histori'); ?>" class="btn btn-secondary">Pemberian</a>
                                <a href="<?= base_url('member/withdraw'); ?>" class="btn btn-success"
                                    style="color: #000; font-weight: 600;">Tarik
                                    Tunai</a>
                            </div>
                            <?php if(empty($detailWithdraw)): ?>
                            <img class="mb-4" style="width: 10%;"
                                src="<?= base_url('assets/images/logo/sad-face.png') ?>">
                            <h3> Maaf Anda Belum Mempunyai Transaksi </h3>
                            <?php else: ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 50px">No</th>
                                        <th scope="col" style="width: 150px">Tanggal</th>
                                        <th scope="col" style="width: 150px">Nominal</th>
                                        <th scope="col" style="width: 150px">Lokasi Transaksi</th>
                                        <th scope="col" style="width: 150px;">Detail Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($detailWithdraw as $dw): ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td><?= $dw['tanggal']; ?></td>
                                        <td><?= $dw['nominal']; ?> koin</td>
                                        <td><?= $dw['lokasi']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary detail-btn" data-toggle="modal"
                                                data-target="#detailModal" data-tanggal="<?= $dw['tanggal']; ?>"
                                                data-nominal="<?= $dw['nominal']; ?>"
                                                data-lokasi="<?= $dw['lokasi']; ?>">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                            <button type="button" class="btn btn-close btn-small btn-cross" data-dismiss="modal"
                                aria-label="Close">
                                <i class="fas fa-regular fa-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width: 200px;"><strong>Tanggal</strong></td>
                                        <td><span id="modalTanggal"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nominal</strong></td>
                                        <td><span id="modalNominal"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Lokasi Transaksi</strong></td>
                                        <td><span id="modalLokasi"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailButtons = document.querySelectorAll('.detail-btn');

            detailButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const tanggal = button.getAttribute('data-tanggal');
                    const nominal = button.getAttribute('data-nominal');
                    const lokasi = button.getAttribute('data-lokasi');

                    document.getElementById('modalTanggal').innerText = tanggal;
                    document.getElementById('modalNominal').innerText = nominal + " koin";
                    document.getElementById('modalLokasi').innerText = lokasi;
                });
            });
        });
        </script>